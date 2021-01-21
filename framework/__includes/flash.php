<?php
/**
    Flash - A Flash Messages Plugin for the PHP Fat-Free Framework
    
    The contents of this file are subject to the terms of the GNU General
    Public License Version 3.0. You may not use this file except in
    compliance with the license. Any of the license terms and conditions
    can be waived if you get permission from the copyright holder.
    
    Copyright (c) 2015 ~ ikkez
    Christian Knuth <ikkez0n3@gmail.com>
 
        @version 0.2.0
        @date: 21.01.2015
 **/

/**
 * Class Flash
 */
class Flash extends Prefab {

    /** @var \Base */
    protected $f3;

    /** @var array */
    protected $msg;

    /** @var array */
    protected $key;

    /**
     * @param string $key
     */
    public function __construct($key = 'flash') {
        $this->f3 = \Base::instance();
        $this->msg = &$this->f3->ref('SESSION.'.$key.'.msg');
        $this->key = &$this->f3->ref('SESSION.'.$key.'.key');
    }

    /**
     * Creates new flash message
     * @param $text
     * @param string $status
     */
    public function addMessage($text,$status = 'info') {
        $this->msg[] = array('text'=>$text,'status'=>$status);
    }

    /**
     * Retrieves flash message
     * @return array
     */
    public function getMessages() {
        $out = $this->msg;
        $this->clearMessages();
        return $out;
    }

    /**
     * Clears Flash Messages
     */
    public function clearMessages() {
        $this->msg = array();
    }

    /**
     * Check if a message exists
     * @return bool
     */
    public function hasMessages() {
        return !empty($this->msg);
    }

    /**
     * @param $key
     * @param bool $val
     */
    public function setKey($key,$val=TRUE) {
        $this->key[$key] = $val;
    }

    /**
     * @param $key
     * @return null
     */
    public function getKey($key) {
        $out = NULL;
        if ($this->key && array_key_exists($key,$this->key)) {
            $out = $this->key[$key];
            unset($this->key[$key]);
        }
        return $out;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasKey($key) {
        return ($this->key && array_key_exists($key,$this->key));
    }
}

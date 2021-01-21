<?php
/**
 Purpose: JIG Based Config Wrapper
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

class Config extends \DB\Jig\Mapper {
    /**
     * Load Site Configuration
     */
	public function __construct() {
		$db = new \DB\Jig('framework/data/');
		parent::__construct($db,'site_config.json');
		$this->load();
	}

    /**
     *
     */
	public function expose() {
		$arr = $this->cast();
		\Base::instance()->mset($arr);
	}

    /**
     * Define Configuration Instance for Site
     * @return Config|object
     */
	static public function instance() {
		if (\Registry::exists('CONFIG'))
			$cfg = \Registry::get('CONFIG');
		else {
			$cfg = new self;
			\Registry::set('CONFIG',$cfg);
		}
		return $cfg;
	}

}
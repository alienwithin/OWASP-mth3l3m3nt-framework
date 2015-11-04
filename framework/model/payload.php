<?php
/**
 Purpose: Handles Payload Table Structure and statistics 
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Model;
/**
 * Defines Schema of Payload Table
 * Class Payload
 * @package Model
 */
class Payload extends Mth3l3m3nt {

    protected
        $fieldConf = array(
            'pName' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'nullable'=>false,
                'required'=>true,
                'unique'=>true,
            ),
            'pType' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR256,
                'nullable'=>false,
                'required'=>true,
            ),
                    
            'payload' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
                
            ),
			'pCategory' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
                
            ),
            'pDescription' => array(
                'type' => \DB\SQL\Schema::DT_TEXT,
                'required' => true,
            ),
         ),
        $table = 'payload',
        $db = 'DB';

    /**
     * Returns total count of Payloads in DB
     * @return mixed
     */
    static public function countAll() {
        $payloads = new self;
        return $payloads->count();
    }

    /**
     * Returns count of all Payloads that are SQL Injection
     * @return mixed
     */
	 static public function countSQLi() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','SQLi'));
		
    }

    /**
     * Returns count of all Payloads that are XSS Related
     * @return mixed
     */
	static public function countXSS() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','XSS'));
		
    }

    /**
     * Returns Count of all HTML Injection Payloads
     * @return mixed
     */
	static public function countHTMLi() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','HTMLi'));
		
    }

    /**
     * Returns Count of All LFI Payloads
     * @return mixed
     */
	static public function countLFI() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','LFI'));
		
    }

    /**
     * Returns Count of All Miscellaneous Payloads
     * @return mixed
     */
	static public function countMisc() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','Miscellaneous'));
		
    }
}

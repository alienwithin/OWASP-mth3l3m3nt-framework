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


    static public function countAll() {
        $payloads = new self;
        return $payloads->count();
    }
	 static public function countSQLi() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','SQLi'));
		
    }
	static public function countXSS() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','XSS'));
		
    }
	static public function countHTMLi() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','HTML Injection'));
		
    }
	static public function countLFI() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','LFI'));
		
    }
	static public function countMisc() {
        $payloads = new self;
        return $payloads->count(array('pType = ?','Miscellaneous'));
		
    }
}

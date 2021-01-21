<?php
/**
 Purpose: Handles the LFI Plugins Table Structure
    
    Copyright (c) 2016 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 22.08.2016
        @url : http://munir.skilledsoft.com
 **/
namespace Model;
/**
 * This defines Schema of Local and Remote FI Plugins Table
 * Class Webot
 * @package Model
 */
class Lfiplugins extends Mth3l3m3nt {

    protected
        $fieldConf = array(
            'lTitle' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'nullable'=>false,
                'required'=>true,
                
            ),
			'lType' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'nullable'=>false,
                'required'=>true,
                
            ),
			'lMethod' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'nullable'=>false,
                'required'=>true,
                
            ),
            'lPayload' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR256,
                'nullable'=>false,
                'required'=>true,
            ),               
            'lDescription' => array(
                'type' => \DB\SQL\Schema::DT_TEXT,
                'required' => true,
            ),
         ),
        $table = 'lfi',
        $db = 'DB';
  
}

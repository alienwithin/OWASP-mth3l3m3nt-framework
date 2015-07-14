<?php
/**
 Purpose: Handles the Web Botnet Table Structure
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Model;

class Webot	extends Mth3l3m3nt {

    protected
        $fieldConf = array(
            'zName' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'nullable'=>false,
                'required'=>true,
                
            ),
            'zLoc' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR256,
                'nullable'=>false,
                'required'=>true,
            ),               
            'zParam' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR256,
                'required'=>true,
            ),  
         ),
        $table = 'webot',
        $db = 'DB';
  
}

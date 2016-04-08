<?php
/**
Purpose: XSS Information Stealer DB Schema

Copyright (c) 2016 ~ alienwithin
Munir Njiru <munir@skilledsoft.com>

@version 1.0.0
@date: 31.03.2016
@url : http://munir.skilledsoft.com
 **/
namespace Model;
class Xssr extends Mth3l3m3nt {
    protected
        $fieldConf = array(
        'hosttag' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required'=>false,
        ),
        'vulnerableUrl' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required'=>false,
        ),
        'referer' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required' => false,
        ),
        'cookiemonster' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required'=>false,
        ),
        'vulnerablePageContent' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required'=>false,

        ),
        'indirect_target_page' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required'=>false,
        ),
        'dateattacked' => array(
            'type' => \DB\SQL\Schema::DT_VARCHAR256,
            'nullable'=>true,
            'required'=>false,
        ),
    ),
        $table = 'xssr',
        $db = 'DB';

}
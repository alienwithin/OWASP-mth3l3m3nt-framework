<?php
/**
 Purpose: Base View
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace View;

abstract class Base {

    public $data = array();

    /**
     * create and return response content
     * @return mixed
     */
    abstract public function render();

}
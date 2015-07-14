<?php
/**
 Purpose: Handles JSON Data
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace View;

class JSON extends Base {

	public function render() {
		header('Content-Type: application/json');
		return json_encode($this->data);
	}

}
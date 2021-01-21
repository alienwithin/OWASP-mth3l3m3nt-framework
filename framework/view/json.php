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
/**
 * Class JSON
 * @package View
 */
class JSON extends Base {
    /**
     * Handles JSON Encoding
     * @return mixed|string
     */
	public function render() {
		header('Content-Type: application/json');
		return json_encode($this->data);
	}

}
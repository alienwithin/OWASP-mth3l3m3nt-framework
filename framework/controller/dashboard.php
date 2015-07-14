<?php
/**
 Purpose: Serves the Dashboard on login
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

namespace Controller;

class Dashboard extends Mth3l3m3nt{
	

    protected
        $response;

    /**
     * init the View
     */
    public function beforeroute() {
        $this->response = new \View\Backend();
    }

    /**
     * fetch data for an overview page
     */
    public function main($f3) {
        $this->response->data['LAYOUT'] = 'overview.html';
    }

}
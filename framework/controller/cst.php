<?php
/**
Purpose: Handles Client Side Code tools

Copyright (c) 2015 ~ alienwithin
Munir Njiru <munir@skilledsoft.com>

@version 1.0.0
@date: 21.10.2015
@url : http://munir.skilledsoft.com
 */

namespace Controller;


class Cst extends Mth3l3m3nt {
    /**
     * Loads main Layout for the interface
     */
    public function beforeroute() {
        $this->response = new \View\Backend();
        $this->response->data['LAYOUT'] = 'websaccre_layout.html';
    }

    public function client_side_obfuscator(\Base $f3)
    {
        $this->response->data['SUBPART'] = 'websaccre_cst.html';

    }
    public function random_string_generator(\Base $f3)
    {
        $this->response->data['SUBPART'] = 'websaccre_ran_string.html';

    }



} 
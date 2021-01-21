<?php
/**
 Purpose: Handles Frontend View
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace View;
/**
 * Class Frontend
 * @package View
 */
class Frontend extends Base {
    /**
     * Renders Front end views
     * @return mixed|string
     */
    public function render() {
        /** @var \Base $f3 */
        $f3 = \Base::instance();
        if($this->data)
            $f3->mset($this->data);
        return \Template::instance()->render('templates/layout.html');
    }

}
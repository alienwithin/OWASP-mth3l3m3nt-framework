<?php
/**
 Purpose: Handles Backend View 
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace View;
/**
 * Class Backend
 * @package View
 */
class Backend extends Base {

	protected
		$template = 'templates/layout.html';

    /**
     * Checks Backend Sessions and Pages
     */
	public function __construct() {
		/** @var \Base $f3 */
		$f3 = \Base::instance();
		
		$f3->copy('BACKEND_UI','UI');
		// save last visited URL
		if ($f3->exists('SESSION.CurrentPageURL')) {
			if ($f3->get('SESSION.CurrentPageURL') != $f3->get('PARAMS.0'))
				$f3->copy('SESSION.CurrentPageURL', 'SESSION.LastPageURL');
		} else
			$f3->set('SESSION.LastPageURL', '');
		$f3->set('SESSION.CurrentPageURL', $f3->get('PARAMS.0'));
	}

    /**
     * Defines how to load backend templates
     * @param $filepath
     */
	public function setTemplate($filepath) {
		$this->template = $filepath;
	}

    /**
     * Renders Backend Layouts
     * @return mixed|string
     */
	public function render() {
		// add template data to F3 hive
		if($this->data)
			\Base::instance()->mset($this->data);
		// render base layout, the rest happens in template
		return \Template::instance()->render($this->template);
	}

}
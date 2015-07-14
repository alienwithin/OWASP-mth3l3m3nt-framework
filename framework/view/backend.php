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

class Backend extends Base {

	protected
		$template = 'templates/layout.html';

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

	public function setTemplate($filepath) {
		$this->template = $filepath;
	}

	public function render() {
		// add template data to F3 hive
		if($this->data)
			\Base::instance()->mset($this->data);
		// render base layout, the rest happens in template
		return \Template::instance()->render($this->template);
	}

}
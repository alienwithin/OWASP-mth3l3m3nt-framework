<?php
/**
 Purpose: Error Handler
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

/**
 * Class Error
 */
class Error {
    /**
     * Handles Errors and how they are mailed or shown
     */
	function render() {

		// Clean all output given first
		while(ob_get_level())
			ob_end_clean();

		$f3 = \Base::instance();
		$f3->set('headline', 'Error '.$f3->get('ERROR.code'));
		$f3->set('text', $f3->get('ERROR.text'));
		$f3->set('ESCAPE', false);
		
		if ($f3->get('AJAX')) {
			die(json_encode(array('error'=>$f3->get('ERROR.text'))));
		}

		if ($f3->get('ERROR.code') == 400) {
			\Flash::instance()->addMessage($f3->get('ERROR.text'),'warning');
			$f3->set('HALT',false);
			return;
		}
		elseif ($f3->get('ERROR.code') == 404) {
			$f3->set('headline', 'Page not found');
		}
		elseif ($f3->get('ERROR.code') == 405) {
			$f3->set('headline', 'This action is not allowed');
		}
		elseif ($f3->get('ERROR.code') == 500) {
			$f3->set('headline', 'Internal Server Error');
				if ($f3->get('DEV'))
					$f3->set('trace',$f3->highlight($f3->get('ERROR.trace')));
			@mail($f3->get('error_mail'),'Mth3l3m3nt Framework Error',$f3->get('ERROR.text')."\n\n".$f3->get('ERROR.trace'));
		}
		$f3->set('LAYOUT', 'error.html');
		$f3->set('HALT', true);
		echo \Template::instance()->render('themes/default/layout.html');

	}

} 
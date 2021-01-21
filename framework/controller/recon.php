<?php
/**
 * Purpose: Handles Recon stuff


    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

namespace Controller;
/**
 * Class Websaccre
 * @package Controller
 */

class Recon extends Mth3l3m3nt {


	public function beforeroute() {
		$this->response = new \View\Backend();
		$this->response->data['LAYOUT'] = 'websaccre_layout.html';
	}


	public function getwhois(\Base $f3){
		$web=\Web::instance();
		$this->response->data['SUBPART'] = 'websaccre_whois.html';
		
		if($f3->get('VERB') == 'POST') {
			$error = false;
			if($f3->devoid('POST.hostname')) {
				$error=true;
				\Flash::instance()->addMessage('Please enter a hostname e.g. africahackon.com','warning');
			} else {
                $address=$f3->get('POST.hostname');
			    $mywhois=$web->whois($address);
					 if (!($mywhois)){
				    	\Flash::instance()->addMessage('You have entered an invalid hostname try something like: africahackon.com','warning');
					        }
					else{

						$this->response->data['content']=$mywhois;
					    }
					
				}
				
			}
		}



}
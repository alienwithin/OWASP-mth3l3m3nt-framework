<?php
/**
 Purpose: Base Controller
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;

abstract class Mth3l3m3nt {

	/** @var \View\Base */
	protected $response;

	/**
	 * set a new view
	 * @param \View\Base $view
	 */
	public function setView(\View\Base $view) {
		$this->response = $view;
	}

	/**
	 * init the View
	 */
	public function beforeroute() {
		$this->response = new \View\Frontend();
	}

	/**
	 * kick start the View, which creates the response
	 * based on our previously set content data.
	 * finally echo the response or overwrite this method
	 * and do something else with it.
	 * @return string
	 */
	public function afterroute() {
		if (!$this->response)
			trigger_error('No View has been set.');
		echo $this->response->render();
	}
}
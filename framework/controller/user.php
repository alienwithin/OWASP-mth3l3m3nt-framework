<?php
/**
 Purpose: Handles User CRUD
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

namespace Controller;
/**
 * Hydrates User Model
 * Class User
 * @package Controller
 */
class User extends Resource {

    /**
     * Initialize mapper and load appropriate model
     */
	public function __construct() {
		$mapper = new \Model\User();
		parent::__construct($mapper);
	}

    /**
     * @param \Base $f3
     * @param array $params
     */
	public function getSingle(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'user_edit.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry())
				$f3->error(404, 'User not found');
			$this->response->data['POST'] = $this->resource;
		}
	}

    /**
     * @param \Base $f3
     * @param array $param
     */
	public function getList(\Base $f3,$param) {
		$this->response->data['SUBPART'] = 'user_list.html';
		$this->response->data['content'] = $this->resource->find();
	}

    /**
     * @param \Base $f3
     * @param array $params
     */
	public function post(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'user_edit.html';
		$msg = \Flash::instance();
		if (isset($params['id'])) {
			// update existing
			$this->resource->load(array('_id = ?', $params['id']));
			if ($f3->get('HOST') == 'mth3l3m3nt-mvc.com'
				&& !$this->resource->dry() && $this->resource->username == 'mth3l3m3nt') {
				$msg->addMessage("You are not allowed to change the demo-admin",'danger');
				$f3->reroute('/cnc/'.$params['module']);
				return;
			}
	
		}
		parent::post($f3,$params);
	}

    /**
     * @param \Base $f3
     * @param array $params
     */
	public function delete(\Base $f3, $params) {
		$this->resource->reset();
		$msg = \Flash::instance();
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($f3->get('HOST') == 'mth3l3m3nt.com'
				&& !$this->resource->dry() && $this->resource->username == 'mth3l3m3nt') {
				$msg->addMessage("You are not allowed to delete the demo-admin",'danger');
				$f3->reroute('/cnc/'.$params['module']);
				return;
			}
			parent::delete($f3,$params);
		}
		$f3->reroute($f3->get('SESSION.LastPageURL'));
	}



}

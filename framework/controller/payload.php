<?php
/**
 Purpose: Handles CRUD for Payloads
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;
/**
 * Hydrates and handles CRUD for Payloads
 * Class Payload
 * @package Controller
 */
class Payload extends Resource {

    /**
     * Initialize the database mapper and load Model
     */
	public function __construct() {
		$mapper = new \Model\Payload();
		parent::__construct($mapper);
	}

    /**
     * Load 1 record
     * @param \Base $f3
     * @param array $params
     */
	public function getSingle(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'payload_edit.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry())
				$f3->error(404, 'Payload not found');
			$this->response->data['POST'] = $this->resource;
		}
	}

    /**
     * @param \Base $f3
     * @param array $param
     */
	public function getList(\Base $f3,$param) {
		$this->response->data['SUBPART'] = 'payload_list.html';
		$page = \Pagination::findCurrentPage();
		if ($this->response instanceof \View\Backend) {
			// backend view
		$records = $this->resource->paginate($page-1,10,null,
				array('order'=>'id desc'));
		} else {
			// frontend view
			
			$records = $this->resource->paginate($page-1,10,null,
				array('order'=>'id desc'));
		}
		$this->response->data['content'] = $records;
	}

    /**
     * @param \Base $f3
     * @param array $params
     */
	public function post(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'payload_edit.html';
		$msg = \Flash::instance();
		if (isset($params['id'])) {
			// update existing
			$this->resource->load(array('_id = ?', $params['id']));
	}
		parent::post($f3,$params);
	}

    /**
     * View Single Item
     * @param \Base $f3
     * @param array $params
     */
	public function viewSingle(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'payload_view.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry())
				$f3->error(404, 'Payload not found');
			$this->response->data['POST'] = $this->resource;
		}
		
	}

    /**Search Payloads Backend
     * @param $f3
     */
	public function getSearchResults($f3) {
	  $this->response->data['SUBPART'] = 'payload_list.html';
	  $page = \Pagination::findCurrentPage();
	  
	  $term=$f3->get('GET.term');
	  $search_filter = array('pName LIKE ? OR pDescription LIKE ? OR payload LIKE ? OR pCategory LIKE ? ',"%$term%","%$term%","%$term%","%$term%");
	  
	  $records = $this->resource->paginate($page-1,10,
      $search_filter,	array('order' => 'id desc'));
	  
	
	  $this->response->data['content'] = $records;
	}

    /**
     * Search Payloads Frontend
     * @param $f3
     */
	public function search_frontend($f3) {
	  $this->response->data['SUBPART'] = 'payload_list.html';
	  $page = \Pagination::findCurrentPage();
	  
	  $term=$f3->get('GET.term');
	  $search_filter = array('pName LIKE ? OR pDescription LIKE ? OR payload LIKE ? OR pCategory LIKE ? ',"%$term%","%$term%","%$term%","%$term%");
	  
	  $records = $this->resource->paginate($page-1,10,
      $search_filter,	array('order' => 'id desc'));
	  
	
	  $this->response->data['content'] = $records;
	}


    /**
     * Delete Payloads
     * @param \Base $f3
     * @param array $params
     */
	public function delete(\Base $f3, $params) {
		$this->resource->reset();
		$msg = \Flash::instance();
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			
			parent::delete($f3,$params);
		}
		$f3->reroute($f3->get('SESSION.LastPageURL'));
	}

}

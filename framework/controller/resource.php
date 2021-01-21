<?php
/**
 Purpose: Helps make CRUD less heavy for each database related object
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

namespace Controller;

abstract class Resource extends Mth3l3m3nt {

	// mapper
	protected $resource;

	/** @var \View\Mth3l3m3nt */
	protected $response;

	/**
	 * @param \Model\Mth3l3m3nt $model
	 */
	public function __construct(\Model\Mth3l3m3nt $model) {
		$this->resource = $model;
	}

	/**
	 * get single record
	 * @param \Mth3l3m3nt $f3
	 * @param array $params
	 */
	public function getSingle(\Base $f3,$params) {
		$f3->error(403);
	}
	/**
	 * View single record
	 * @param \Mth3l3m3nt $f3
	 * @param array $params
	 */
	public function viewSingle(\Base $f3,$params) {
		$f3->error(403);
	}
	
	public function edit(\Base $f3,$params) {
		if ($f3->get('VERB') == 'POST')
			$this->post($f3,$params);
		elseif ($f3->get('VERB') == 'GET')
			$this->getSingle($f3,$params);
	}

	/**
	 * get collection of records
	 * @param \Mth3l3m3nt $f3
	 * @param array $params
	 */
	public function getList(\Base $f3,$params) {
		$f3->error(403);
	}

	/**
	 * create / update a record
	 * @param \Mth3l3m3nt $f3
	 * @param array $params
	 */
	public function post(\Base $f3, $params) {
		$flash = \Flash::instance();
		$this->resource->reset();
		if (isset($params['id'])) {
			// update existing
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry()) {
				$flash->addMessage('No record found with this ID.','danger');
				$f3->reroute('/cnc/'.$params['module']);
				return;
			}
		}
		$fields = $this->resource->getFieldConfiguration();
		$this->resource->copyfrom('POST', array_keys($fields));
		$this->resource->save();
		if (!$f3->get('ERROR')) {
			// display the list again after saving
			$flash->addMessage('Successfully saved.', 'success');
			$f3->reroute('/cnc/'.$params['module']);
		}
	}

	/**
	 * delete a record
	 * @param \Mth3l3m3nt $f3
	 * @param array $params
	 */
	public function delete(\Base $f3, $params) {
		$this->resource->reset();
		$flash = \Flash::instance();
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry()) {
				$flash->addMessage('No record found with this ID.', 'danger');
			} else {
				$this->resource->erase();
				$flash->addMessage("Record deleted.", 'success');
			}
		}
		$f3->reroute($f3->get('SESSION.LastPageURL'));
	}

}
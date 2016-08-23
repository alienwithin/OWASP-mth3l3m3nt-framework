<?php
/**
 Purpose: Serve as Plugins Based on LARFI (Local and Remote File Inclusion)
    
    Copyright (c) 2016 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 22.08.2016
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;
/**
 * Creates Exploits based on LARFI
 * Class Lfiplugins
 * @package Controller
 */
class Larfi extends Resource {
    public function __construct() {
		$mapper = new \Model\lfiplugins();
		parent::__construct($mapper);
	}

	public function getSingle(\Base $f3, $params) {
		$this->response->data['SUBPART'] = 'larfi_edit.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			if ($this->resource->dry())
				$f3->error(404, 'LFI Plugin not found');
			$this->response->data['POST'] = $this->resource;
		}
	}
	
//The \Base is for \Base:instance from f3 base class not our abstract class
    /**
     * @param \Base $f3
     * @param array $param
     */
	public function getList(\Base $f3,$param) {
		$this->response->data['SUBPART'] = 'larfi_list.html';
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
		$this->response->data['SUBPART'] = 'lfi_edit.html';
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
		$this->response->data['SUBPART'] = 'larfi_page.html';
		if (isset($params['id'])) {
			$this->resource->load(array('_id = ?', $params['id']));
			$this->response->data['POST'] = $this->resource;
			if ($this->resource->dry()){
				$f3->error(404, 'LFI Plugin not found');
			}
			else{
				
				$this->response->data['SUBPART'] = 'larfi_page.html';
				
				$url=$f3->get('POST.url');
				$blankurl=$f3->devoid('POST.url');
				$lfi_type=$f3->get('POST.lType');
				$payload=$f3->get('POST.lPayload');
				$method=$f3->get('POST.lMethod');
				switch ($lfi_type){
					case "Generic":
						\Flash::instance()->addMessage('Exploited by injecting into the URL/Body where applicable','info');
						return $this->uri_based_lfi($method,$blankurl,$url,$payload);
					break;
					case "Cookie":
						\Flash::instance()->addMessage('Exploited by injecting into the cookie','info');
						return $this->cookie_based_lfi($method,$blankurl,$url,$payload);
					break;
					default:
						\Flash::instance()->addMessage('This is an invalid attack type','warning');
				}

			}	
		}		
		
	}

    /**
     * @param $f3
     */
	public function getSearchResults($f3) {
	  $this->response->data['SUBPART'] = 'larfi_list.html';
	  $page = \Pagination::findCurrentPage();
	  
	  $term=$f3->get('GET.term');
	  $search_filter = array('lTitle LIKE ? lPayload LIKE ? ',"%$term%","%$term%");
	  
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

	   /**
     * Helps Generate a standard LFI using GET Requests
     * @param $blankurl
     * @param $url
     * @param $payload
     */
public function uri_based_lfi($method,$blankurl, $url, $payload){
		$web=\Web::instance();
		$f3=\Base::instance();
		$audit_instance = \Audit::instance();
		if($f3->get('VERB') == 'POST') {
			$error = false;
			if($blankurl) {
				$error=true;
				\Flash::instance()->addMessage('Please enter a url e.g. http://africahackon.com','warning');
			} else {
				$audited_url=$audit_instance->url($url);
				if ($audited_url==TRUE){
					$url=rtrim($url,"/");
					if( ini_get('open_basedir') ){
						$follow_loc=FALSE;
					}else{
						$follow_loc=TRUE;
					}
					
					if ($method=="POST"){
						$options = array(
						'content'=>$payload,
						'follow_location'=>$follow_loc		   
						);
						$request_successful=$web->request($url,$options);
					}else{
						$options = array(
						'follow_location'=>$follow_loc		   
						);
						$request_successful=$web->request($url.$payload,$options);
					}
					
					 if (!($request_successful)){
				    	\Flash::instance()->addMessage('You have entered an invalid URL try something like: http://africahackon.com','warning');
					}
					else{
							$result_body=$request_successful['body'];
					    	$result_headers=$request_successful['headers'];
					    	$response_header=$result_headers["0"];
					    	$engine=$request_successful['engine'];
					    	$headers_max=implode("\n",$result_headers);
						if (strpos($response_header,'200 OK') !== false) {
						  	
							$myFinalRequest="Headers: \n\n".$headers_max."\n\n Body:\n\n".$result_body."\n\n Engine Used: ".$engine;
							$this->response->data['content']=$myFinalRequest;
						}
						else {
							$this->response->data['content']= "Not Exploitable Application Returned the response below: \n\n ".$headers_max;
						}
						//convert array header to string
						
					}
					
				}
				else{
					\Flash::instance()->addMessage('You have entered an invalid URL try something like: http://africahackon.com','danger');
				}
				
			}
		}
			
	}

    /**
     * Handles Generating an LFI based on Cookies
     * @param $method
     * @param $blankurl
     * @param $url
     * @param $payload
     */
	public function cookie_based_lfi($method, $blankurl, $url, $payload){
		$web=\Web::instance();
		$f3=\Base::instance();
		if( ini_get('open_basedir') ){
			$follow_loc=FALSE;
		}else{
			$follow_loc=TRUE;
		}
		$options = array(
		    'method'  => $method,
			'follow_location' => $follow_loc,
		    'header' => array(
			     'Accept: */*',
				 'User-Agent: Mth3l3m3ntFramework/4.0 (compatible; MSIE 6.0; HackingtoshTuxu 4.0; .NET CLR 1.1.4322)', 
				 'Cookie: '.$payload, 
				 'Connection: Close',
				 'Pragma: no-cache',
				 'Cache-Control: no-cache'
		    )
		);

		$audit_instance = \Audit::instance();
		if($f3->get('VERB') == 'POST') {
			$error = false;
			if($blankurl) {
				$error=true;
				\Flash::instance()->addMessage('Please enter a url e.g. http://africahackon.com','warning');
			} else {
				$audited_url=$audit_instance->url($url);
				if ($audited_url==TRUE){
					$request_successful=$web->request($url,$options);
					 if (!($request_successful)){
				    	\Flash::instance()->addMessage('You have entered an invalid URL try something like: http://africahackon.com','warning');
					}
					else{
							$result_body=$request_successful['body'];
					    	$result_headers=$request_successful['headers'];
					    	$response_header=$result_headers["0"];
					    	$engine=$request_successful['engine'];
					    	$headers_max=implode("\n",$result_headers);
						if (strpos($response_header,'200 OK') !== false) {
						  	
							$myFinalRequest="Headers: \n\n".$headers_max."\n\n Body:\n\n".$result_body."\n\n Engine Used: ".$engine;
							$this->response->data['content']=$myFinalRequest;
						}
						else {
							$this->response->data['content']= "Not Exploitable Application Returned the response below: \n\n ".$headers_max;
						}
						//convert array header to string
						
					}
					
				}
				else{
					\Flash::instance()->addMessage('You have entered an invalid URL try something like: http://africahackon.com','danger');
				}
				
			}
		}
			
	}
    
	
}
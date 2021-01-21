<?php
/**
 Purpose: Handles Encoding and Decoding using various systems
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

namespace Controller;

/**
 * This Handles Encoding and Decoding Values
 * Class Dencoder
 * @package Controller
 */
class Dencoder extends Mth3l3m3nt {

    /**
     * Loads main Layout for the interface
     */
	public function beforeroute() {
		$this->response = new \View\Backend();
		$this->response->data['LAYOUT'] = 'websaccre_layout.html';
	}

    /**
     * Handles various encoding functions
     * @param \Base $f3
     */
	public function encoder_multi(\Base $f3){
		$this->response->data['SUBPART'] = 'dencoder_encoder_multi.html';
		$audit_instance = \Audit::instance();
		if($f3->get('VERB') == 'POST') {
			$error = false;
			if($f3->devoid('POST.plaintext')) {
				$error=true;
				\Flash::instance()->addMessage('Please enter Some text to encode e.g. 0x746573746d65 I want to encode this string','warning');
			} 
			else{
				$plain_text_string=$f3->get('POST.plaintext');
			    $encodeFormat=$f3->get('POST.encodeFormat');
				
				switch ($encodeFormat){
					case "base64":
						$encoded=base64_encode($plain_text_string);
						$this->response->data['content']=$encoded;
					break;
					case "hex":
						$encoded=bin2hex($plain_text_string);
						$this->response->data['content']=$encoded;
					break;
					case "hex_0x":
						$encoded=bin2hex($plain_text_string);
						$this->response->data['content']="0x".$encoded;
					break;
					case "hex_slash_x":
						$encoded=bin2hex($plain_text_string);
						$encoded=chunk_split($encoded,2,"\\x");
						$encoded="\\x".substr($encoded,0,-2);
						$this->response->data['content']=$encoded;
					break;
					case "rot13":
						$encoded=str_rot13($plain_text_string);
						$this->response->data['content']=$encoded;
					break;
					case "all":
						$base_64=base64_encode($plain_text_string);
						$hex_regular=bin2hex($plain_text_string);
						$hex_0x="0x".$hex_regular;
						$split_hex=chunk_split($hex_regular,2,"\\x");
						$hex_slash_x="\\x".substr($split_hex,0,-2);
						$str_rot13=str_rot13($plain_text_string);
						$amalgam="Base 64:".$base_64."\n\n Hex Plain: ".$hex_regular."\n\n Hex with 0x prefix: ".$hex_0x."\n\n Hex in \x Format: ".$hex_slash_x."\n\n Rot13: ".$str_rot13;
						$this->response->data['content']=$amalgam;
					break;
					default:
						\Flash::instance()->addMessage('Seems You have not selected a valid encoding \n I can\'t process','warning');
					
				}		
			}
		}
	}

    /**
     * Handles Decoding Functions
     * @param \Base $f3
     */
	public function decoder_multi(\Base $f3){
		$this->response->data['SUBPART'] = 'dencoder_decoder_multi.html';
		$audit_instance = \Audit::instance();
		if($f3->get('VERB') == 'POST') {
			$error = false;
			if($f3->devoid('POST.encoded')) {
				$error=true;
				\Flash::instance()->addMessage('Please enter Some text to decode e.g. 0xaaaa ','warning');
			} 
			else{
				$encoded_text_string=$f3->get('POST.encoded');
			    $encodedFormat=$f3->get('POST.encodedFormat');
			    switch ($encodedFormat){
					case "base64":
						$decoded=trim($encoded_text_string);
						if (base64_encode(base64_decode($decoded))===$decoded){
							$decoded=base64_decode($decoded,true);
							$this->response->data['content']=$decoded;
						}
						else{
							\Flash::instance()->addMessage('Please enter a valid base 64 string e.g. dGVzdG1l ','warning');
						}
					break;
					case "hex":
						 $decoded=trim($encoded_text_string);
						if (is_numeric('0x'.$decoded)){
							if(function_exists('hex2bin')){
							$decoded=hex2bin($decoded);
							$this->response->data['content']=$decoded;
							}
							else{
							  \Flash::instance()->addMessage('Seems you are missing the hex2bin function , this is common with PHP 5.3 and below \n Sorry I can\'t work this . ','warning');
							}
						}
						else{
							\Flash::instance()->addMessage('Invalid Hexadecimal String detected, check for trailing spaces or invalid characters then try again.','warning');
						}
					break;
					case "hex_0x":
						$clear_prefix=str_replace("0x","",$encoded_text_string);
						$clear_prefix=trim($clear_prefix);
						if (is_numeric('0x'.$clear_prefix)){
							if(function_exists('hex2bin')){
								$decoded=hex2bin($clear_prefix);
								$this->response->data['content']=$decoded;
							}
							else{
							 \Flash::instance()->addMessage('Seems you are missing the hex2bin function , this is common with PHP 5.3 and below \n Sorry I can\'t work this . ','warning');
							}
						}
						else{
							\Flash::instance()->addMessage('Invalid Hexadecimal String detected, check for trailing spaces or invalid characters then try again.','warning');
							}
					break;
					case "hex_slash_x":
							$clear_prefix=str_replace("\x","",$encoded_text_string);
							$clear_prefix=trim($clear_prefix);
							if (is_numeric('0x'.$clear_prefix)){
							if(function_exists('hex2bin')){
								$decoded=hex2bin($clear_prefix);
								$this->response->data['content']=$decoded;
							}
							else{
							   \Flash::instance()->addMessage('Seems you are missing the hex2bin function , this is common with PHP 5.3 and below \n Sorry I can\'t work this . ','warning');
							}
						}
						else{
							\Flash::instance()->addMessage('Invalid Hexadecimal String detected, check for trailing spaces or invalid characters then try again.','warning');
							}
												
					
					break;
					case "rot13":
						$decoded=str_rot13(trim($encoded_text_string));
						$this->response->data['content']=$decoded;
					break;
					default:
						\Flash::instance()->addMessage('Seems You have Broken something or text is invalid \n I can\'t process','warning');
				}
		}
	 } 
   }
}
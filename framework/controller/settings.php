<?php
/**
 Purpose: Handles Site Settings Stored in site_config.json
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;


class Settings extends Mth3l3m3nt {


	public function beforeroute() {
		$this->response = new \View\Backend();
		$this->response->data['LAYOUT'] = 'settings_layout.html';
	}

	public function general( \Base $f3 ) {
		$this->response->data['SUBPART'] = 'settings_general.html';

		$cfg = \Config::instance();
		if($f3->get('VERB') == 'POST') {

			$error = false;
			if($f3->devoid('POST.framework_title')) {
				$error=true;
				\Flash::instance()->addMessage('Please enter a Framework Title','warning');
			} else {
				$cfg->set('framework_title',$f3->get('POST.framework_title'));
			}

			$cfg->set('ssl_backend',$f3->get('POST.ssl_backend')=='1');
			
			if(!$error) {
				\Flash::instance()->addMessage('Configuration saved','success');
				$cfg->save();
			}
		}
		$cfg->copyto('POST');

	}
	public function api_keys( \Base $f3 ) {
		$this->response->data['SUBPART'] = 'settings_unphp_api.html';

		$cfg = \Config::instance();
		if($f3->get('VERB') == 'POST') {

			$error = false;
			if($f3->devoid('POST.unphp_api_key')) {
				$error=true;
				\Flash::instance()->addMessage('Please enter an API Key from unphp.net ','warning');
			} else {
				$cfg->set('unphp_api_key',$f3->get('POST.unphp_api_key'));
			}

						
			if(!$error) {
				\Flash::instance()->addMessage('Configuration saved','success');
				$cfg->save();
			}
		}
		$cfg->copyto('POST');

	}

	public function database( \Base $f3 ) {
		$this->response->data['SUBPART'] = 'settings_database.html';

		$cfg = \Config::instance();
		if ($f3->get('VERB') == 'POST' && $f3->exists('POST.active_db')) {

			$type = $f3->get('POST.active_db');
			$cfg->{'DB_'.$type} = $f3->get('POST.DB_'.$type);
			$cfg->ACTIVE_DB = $type;

			$cfg->save();
			\Flash::instance()->addMessage('Config saved','success');
			$setup = new \Setup();
			$setup->install($type);
			// logout
			$f3->clear('SESSION.user_id');
		}
		$cfg->copyto('POST');

		$f3->set('JIG_format', array('JSON','Serialized'));
	}

} 
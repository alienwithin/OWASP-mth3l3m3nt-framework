<?php
/**
	Model Setup Helper

	The contents of this file are subject to the terms of the GNU General
	Public License Version 3.0. You may not use this file except in
	compliance with the license. Any of the license terms and conditions
	can be waived if you get permission from the copyright holder.

	Copyright (c) 2014 ~ ikkez
	Christian Knuth <ikkez0n3@gmail.com>

		@version 0.2.0
 **/

/**
 * Class setup
 */
class setup {
    /**
     * Installs tables with default user
     * @param $db_type
     */
	public function install($db_type) {
		$f3 = \Base::instance();
		$db_type = strtoupper($db_type);
		if( $db = DBHandler::instance()->get($db_type))
			$f3->set('DB', $db);
		else {
			$f3->error(256,'no valid Database Type specified');
		}
		// setup the models
		
		\Model\User::setup();
		\Model\Payload::setup();
		\Model\Webot::setup();

		// create demo admin user
		$user = new \Model\User();
		$user->load(array('username = ?', 'mth3l3m3nt'));
		if ($user->dry()) {
			$user->username = 'mth3l3m3nt';
			$user->name = 'Framework Administrator';
			$user->password = 'mth3l3m3nt';
			$user->email = 'placeholder_mail@mth3l3m3nt.com';
			$user->save();
         //migrate payloads successfully

            $payload_file = $f3->ROOT.$f3->BASE.'/db_dump_optional/mth3l3m3nt_payload';
            if (file_exists($payload_file)) {
                $payload = new \Model\Payload();

                $payload_file_data=$f3->read($payload_file);
                $payloadarray = json_decode($payload_file_data, true);

                foreach ($payloadarray as $payloaddata) {
                    $payload->pName = $payloaddata['pName'];
                    $payload->pType = $payloaddata['pType'];
                    $payload->pCategory = $payloaddata['pCategory'];
                    $payload->pDescription = $payloaddata['pDescription'];
                    $payload->payload = $payloaddata['payload'];
                    $payload->save();
                    //ensures values set to null before continuing update
                    $payload->reset();
                }
                //migtate payloads
                \Flash::instance()->addMessage('Payload StarterPack: ,'
                    .'All Starter Pack Payloads added New database','success');
            }
            else{
                \Flash::instance()->addMessage('Payload StarterPack: ,'
                    .'StarterPack Database not Found no payloads installed ','danger');
            }


			\Flash::instance()->addMessage('Admin User created,'
                .' username: mth3l3m3nt, password: mth3l3m3nt','success');


		}
		\Flash::instance()->addMessage('New Database Setup Completed','success');
	}

    /**
     * Works on destroying table data
     */
	public function uninstall()
	{
		die('serious?');
		// clears all tables !!!
		
		\Model\User::setdown();
		\Model\Payload::setdown();
		\Model\Webot::setdown();
		$cfg = new Config();
		$cfg->clear('ACTIVE_DB');
		$cfg->save();
		\Base::instance()->clear('SESSION');
		echo "Done Uninstalling Current Tables!";
	}

}
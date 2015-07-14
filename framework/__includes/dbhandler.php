<?php
/**
 Purpose: Enables us switch between DB Settings
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

class DBHandler extends Prefab {

	public function get($type) {
		$cfg = Config::instance();
		$type = strtoupper($type);
		switch ($type) {
			case 'JIG':
				$db = new \DB\Jig($cfg->DB_JIG['dir'],$cfg->DB_JIG['format']);
				break;
			case 'MYSQL':
				$db = new \DB\SQL('mysql:host='.$cfg->DB_MYSQL['host'].
					';port='.$cfg->DB_MYSQL['port'].';dbname='.$cfg->DB_MYSQL['dbname'],
					$cfg->DB_MYSQL['user'], $cfg->DB_MYSQL['password']);
				break;
			case 'PGSQL':
				$db = new \DB\SQL('pgsql:host='.$cfg->DB_PGSQL['host'].
					';dbname='.$cfg->DB_PGSQL['dbname'],
					$cfg->DB_PGSQL['user'], $cfg->DB_PGSQL['password']);
				break;
			case 'SQLSRV':
				$db = new \DB\SQL('sqlsrv:SERVER='.$cfg->DB_SQLSRV['host'].
					';Database='.$cfg->DB_SQLSRV['dbname'],
					$cfg->DB_SQLSRV['user'], $cfg->DB_SQLSRV['password']);
				break;
			case 'SQLITE':
				$db = new \DB\SQL('sqlite:'.$cfg->DB_SQLITE['path']);
				break;
			case 'MONGO':
				$db = new \DB\Mongo('mongodb://'.$cfg->DB_MONGO['host'].':'.
					$cfg->DB_MONGO['port'],$cfg->DB_MONGO['dbname']);
				break;
		}
		return isset($db) ? $db : false;
	}

	public function update($type,$conf) {
		$cfg = Config::instance();
		$cfg->set('DB_'.strtoupper($type), $conf);
		$cfg->save();
	}

}
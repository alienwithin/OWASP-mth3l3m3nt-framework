<?php
/**
 Purpose: Base Model to define table structure and key fields as well as determinants for cortex use in our specific models
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Model;

class Mth3l3m3nt extends \DB\Cortex {

	// persistence settings
	protected $table, $db, $fieldConf;

	/**
	 * init the model
	 */
	public function __construct() {
		$f3 = \Base::instance();
		$this->table = $f3->get('db_table_prefix').$this->table;
		$this->db = 'DB';
		parent::__construct();
		// validation & error handler
		$class = get_called_class(); // PHP 5.3 bug
		$saveHandler = function(\DB\Cortex $self) use($class) {
			$valid = true;
			foreach($self->getFieldConfiguration() as $field=>$conf) {
				if (isset($conf['type'])) {
					$val = $self->get($field);
					$model = strtolower(str_replace('\\','.',$class));
					// check required fields
					if (isset($conf['required']))
						$valid = \Validation::instance()->required($val,$field,'error.'.$model.'.'.$field);
					// check unique
					if (isset($conf['unique']))
						$valid = \Validation::instance()->unique($self,$val,$field,'error.'.$model.'.'.$field);
				}
			}
			return $valid;
		};
		$this->beforesave($saveHandler);
	}

	/**
	 * just a little mass update shortcut
	 * @param $filter
	 * @param $key
	 * @param $value
	 * @return bool
	 */
	public function updateProperty($filter, $key, $value) {
		$this->load($filter);
		if ($this->dry()) {
			return false;
		} else {
			while (!$this->dry()) {
				$this->set($key, $value);
				$this->save();
				$this->next();
			}
			return true;
		}
	}

}
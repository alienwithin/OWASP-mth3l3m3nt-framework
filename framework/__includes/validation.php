<?php

/**
 Purpose: Extra Validation apart from what is offered by fatfree
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
class Validation extends \Prefab {
	
	protected $f3;
	
	function __construct() {
		$this->f3 = \Base::instance();
	}

	/**
	 * check if a model field is empty, but required
	 * @param mixed $val
	 * @param string $field
	 * @param string $context
	 * @return bool
	 */
	function required($val, $field, $context=null) {
		if (!$this->f3->exists($context.'.required',$errText))
			$errText = $field.' field is required';
		if(empty($val) && $val!==0) {
			$this->f3->error(400, $errText);
			\Flash::instance()->setKey($context,'has-error');
			return false;
		}
		return true;
	}

	/**
	 * check if a model field value is unique
	 * @param \DB\Cortex $model
	 * @param mixed $val
	 * @param string $field
	 * @param string $context
	 * @return bool
	 */
	function unique($model, $val, $field, $context=null) {
		$valid = true;
		if (empty($val))
			return $valid;
		if (!$this->f3->exists($context.'.unique',$errText))
			$errText = 'This '.$field.' is already taken';
		$filter = $model->dry()
			// new record
			? array($field.' = ?',$val)
			// change field of existing record, excludes itself
			: array($field.' = ? and _id != ?',$val,$model->_id);
		if ($model->findone($filter)) {
			$this->f3->error(400, $errText);
			\Flash::instance()->setKey($context,'has-error');
			$valid = false;
		}
		return $valid;
	}

	/**
	 * validate email address
	 * @param string $val
	 * @param string $context
	 * @param bool $mx
	 * @return bool
	 */
	function email($val, $context=null, $mx=true) {
		$valid = true;
		if (!$context)
			$context = 'error.validation.email';
		if (!empty($val)) {
			if (!\Audit::instance()->email($val,false)) {
				$val = NULL;
				if (!$this->f3->exists($context.'.invalid',$errText))
					$errText = 'e-mail is not valid';
				$this->f3->error(400, $errText);
				$valid = false;
			}
			elseif ($mx && !\Audit::instance()->email($val,true)) {
				$val = NULL;
				if (!$this->f3->exists($context.'.host',$errText))
					$errText = 'unknown mail mx.host';
				$this->f3->error(400, $errText);
				$valid = false;
			}
		}
		if (!$valid)
			\Flash::instance()->setKey($context,'has-error');
		return $valid;
	}

}
<?php
/**
    Abstract TagHandler for creating own Tag-Element-Renderer
    
    The contents of this file are subject to the terms of the GNU General
    Public License Version 3.0. You may not use this file except in
    compliance with the license. Any of the license terms and conditions
    can be waived if you get permission from the copyright holder.
    
    Copyright (c) 2014 ~ ikkez
    Christian Knuth <ikkez0n3@gmail.com>
 
        @version 0.1.1
        @date: 07.03.14 
 **/

namespace Template;

abstract class TagHandler extends \Prefab {

	/** @var  \Template */
	protected $template;

	protected static $engine;


	public function __construct() {
		$this->template = ($tmpl=static::$engine)
			? $tmpl::instance() : \Template::instance();
	}

	static public function setEngine(\Template $obj) {
		static::$engine = $obj;
	}

	/**
	 * build tag string
	 * @param $attr
	 * @param $content
	 * @return string
	 */
	abstract function build($attr,$content);


	/**
	 * incoming call to render the given node
	 * @param $node
	 * @return string
	 */
	static public function render($node) {
		$attr = $node['@attrib'];
		unset($node['@attrib']);

		/** @var TagHandler $handler */
		$handler = new static;
		$content = (isset($node[0])) ? $handler->template->build($node) : '';

		return $handler->build($attr,$content);
	}


	/**
	 * general bypass for unhandled tag attributes
	 * @param array $params
	 * @return string
	 */
	protected function resolveParams(array $params) {
		$out = '';
		foreach ($params as $key => $value) {
			// build dynamic tokens
			if (preg_match('/{{(.+?)}}/s', $value))
				$value = $this->template->build($value);
			if (preg_match('/{{(.+?)}}/s', $key))
				$key = $this->template->build($key);
			// inline token
			if (is_numeric($key))
				$out .= ' '.$value;
			// value-less parameter
			elseif ($value == NULL)
				$out .= ' '.$key;
			// key-value parameter
			else
				$out .= ' '.$key.'="'.$value.'"';
		}
		return $out;
	}


	/**
	 * modify a token to fit into another token
	 * @param $val
	 * @return string
	 */
	protected function makeInjectable($val) {
		if (preg_match('/({{.+?}})/s', $val)) {
			$split = preg_split('/({{.+?}})/s', $val, -1,
				PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
			foreach ($split as &$part) {
				if (substr($part, 0, 2) == '{{') {
					$part = $this->template->token($part);
				} else
					$part = "'".$part."'";
			}
			$val = implode('.', $split);
		} else {
			$val = "'".$val."'";
		}
		return $val;
	}
} 
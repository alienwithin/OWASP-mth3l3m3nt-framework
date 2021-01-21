<?php

namespace Template\Tags;

class Input extends \Template\TagHandler {

	/**
	 * build tag string
	 * @param $attr
	 * @param $content
	 * @return string
	 */
	function build($attr, $content) {
		if (isset($attr['type']) && isset($attr['name'])) {
			$name = $this->makeInjectable($attr['name']);
			if ($attr['type'] == 'checkbox') {
				$value = $this->makeInjectable(isset($attr['value'])?$attr['value']:'on');
				// basic match
				$str = '(isset(@POST['.$name.']) && @POST['.$name.']=='.$value.')';
				// dynamic array match
				if (preg_match('/({{.+?}})/s', $attr['name'])) {
					$str.= ' || (isset(@POST[substr('.$name.',0,-2)]) && is_array(@POST[substr('.$name.',0,-2)])'.
						' && in_array('.$value.',@POST[substr('.$name.',0,-2)]))';
				}
				// static array match
				elseif (preg_match('/(\[\])/s', $attr['name'])) {
					$name=substr($attr['name'],0,-2);
					$str='(isset(@POST['.$name.']) && is_array(@POST['.$name.'])'.
						' && in_array('.$value.',@POST['.$name.']))';
				}
				$str = '{{'.$str.'?\'checked="checked"\':\'\'}}';
				$attr[] = $this->template->build($str);

			} elseif ($attr['type'] == 'radio' && isset($attr['value'])) {
				$value = $this->makeInjectable(isset($attr['value'])?$attr['value']:'on');
				$attr[] = $this->template->build('{{ isset(@POST['.$name.']) && '.
					'@POST['.$attr['name'].']=='.$value.'?\'checked="checked"\':\'\'}}');
			} elseif($attr['type'] != 'password' && !array_key_exists('value',$attr)) {
				// all other types, except password fields
				$ar_name = preg_replace('/\'*(\w+)(\[.*\])\'*/i','[$1]$2',$name,-1,$i);
				$name = $i ? $ar_name : '['.$name.']';
				$attr['value'] = $this->template->build('{{ isset(@POST'.$name.')?@POST'.$name.':\'\'}}');
			}
		}
		// resolve all other / unhandled tag attributes
		$attr = $this->resolveParams($attr);
		// create element and return
		return '<input'.$attr.' />';
	}
}
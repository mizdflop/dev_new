<?php

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 */
 
class AppModel extends Model {

	public $recursive = -1;
	
	public $actsAs = array('Containable');
	
	//all of your validation error messages translated by default
	public function invalidate($field, $value = true) {
		return parent::invalidate($field, __($value, true));
	}
	
	public  function compareTo($check,$field) {
		// $data array is passed using the form field name as the key
		// have to extract the value to make the function generic
		$value = array_values($check);
		$value = $value[0];
	
		return $value === $this->data[$this->alias][$field];
	}
}
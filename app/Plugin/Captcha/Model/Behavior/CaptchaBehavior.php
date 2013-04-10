<?php

App::uses('Captcha', 'Captcha.Lib');
App::uses('ModelBehavior', 'Model');

class CaptchaBehavior extends ModelBehavior {
	
	protected $_defaults = array(
			
	);

	public function setup(Model $Model, $settings = array()) {
		
		$this->settings[$Model->alias] = array_merge($this->_defaults, (array)$settings);
	}
	
	
	public function captcha(Model $Model, $check) {
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (CakeSession::check('captcha')) {
			
			$captcha = strtolower(CakeSession::read('captcha'));
			$value = strtolower($value);
			CakeSession::delete('captcha');
			
			if ($value == $captcha) {
				return true;
			}
		}
		
		return false;
	}
}
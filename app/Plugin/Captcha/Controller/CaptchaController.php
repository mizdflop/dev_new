<?php

App::uses('Captcha', 'Captcha.Lib');
App::uses('CaptchaAppController', 'Captcha.Controller');

class CaptchaController extends CaptchaAppController {
	
	public $uses = array();
	
	public function display() {
		
		$captcha = new Captcha();
		$captcha->width = 300;
		$captcha->height = 70;
		$captcha->resourcesPath = APP.'Plugin'.DS.'Account'.DS.'webroot'.DS.'resources';
		$captcha->CreateImage();
		
		$this->_stop();
	}
}
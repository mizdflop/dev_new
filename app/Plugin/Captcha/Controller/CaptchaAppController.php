<?php

App::uses('AppController','Controller');

class CaptchaAppController extends AppController {
	
	function beforeFilter(){
		
		parent::beforeFilter();
		$this->Auth->allow('captcha');		
	}
}
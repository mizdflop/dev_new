<?php

class AccountAppController extends AppController {
	
	public function beforeFilter() {
	
		parent::beforeFilter();
	
		$this->Auth->allow();
	}
}
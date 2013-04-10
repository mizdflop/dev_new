<?php

App::uses('AccountAppController', 'Account.Controller');

/**
 * Accounts Controller
 *
 */
class AccountController extends AccountAppController {

	public $uses = array('User');
	
	public $helpers = array('Captcha.Captcha');
	
	public function beforeFilter() {
	
		parent::beforeFilter();		
	}	
	
/**
 * confirm
 * 		- /account/confirm/<field>/<hash>
 *
 * @param string $token Hash
 *
 * @return void
 */
	public function confirm($field, $token = null) {

		if (($user = $this->User->verifyToken('confirm', $field, $token)) !== false) {
	
			if ($this->User->confirm($field, $user['User']['id'])) {
				
				$this->Session->setFlash(sprintf('Your %s has been validated',$field),'flash',array('type' => 'success'));
			} else {
				$this->Session->setFlash(sprintf('Your %s has been not validated',$field),'flash',array('type' => 'error'));
			}
		} else {
			$this->Session->setFlash('The url you accessed is not longer valid','flash',array('type' => 'error'));			
		}
		
		$this->redirect(array('plugin' => null,'controller' => 'users','action' => 'login'));
	}	
	
/**
 * reset
 * 		- /account/reset/<field>
 * 		- /account/reset/<field>/<hash>
 * 
 * @param string $field 
 * @param string $token hash
 * 
 * @return void
 */	
	public function reset($field, $hash = null) {
		
		if (!empty($hash)) {
		
			if (($user = $this->User->verifyToken('reset', $field, $hash)) !== false) {
		
				if ($this->request->is('post')) {
				
					if ($this->User->reset($field, $user['User']['id'], $this->request->data)) {
						
						$this->Session->setFlash(sprintf('%s has been changed',$field),'flash',array('type' => 'success'));
						if (!$this->Auth->user()) {
							return $this->redirect(array('plugin' => null,'controller' => 'users','action' => 'login'));
						} else {
							return $this->redirect(array('plugin' => null,'controller' => 'users','action' => 'home'));
						}
					}
				}
				
				return $this->render('reset_'.$field);
				
			} else {
				$this->Session->setFlash('The url you accessed is not longer valid','flash',array('type' => 'error'));
				return $this->redirect(array('plugin' => null,'controller' => 'users','action' => 'login'));			
			}		
		
		} else {
			
			if ($this->request->is('post')) {
			
				if (($user = $this->User->createToken('reset', $field, $this->request->data)) !== false) {
			
					$this->Session->setFlash('You should receive an email with further instructions shortly','flash',array('type' => 'success'));
					if (!$this->Auth->user()) {
						return $this->redirect(array('plugin' => null,'controller' => 'users','action' => 'login'));
					} else {
						return $this->redirect(array('plugin' => null,'controller' => 'users','action' => 'home'));
					}
				}
			}
			
			return $this->render('request_reset_'.$field);			
		}
	}	

}
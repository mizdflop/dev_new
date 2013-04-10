<?php

App::uses('AccountAppController', 'Account.Controller');
App::uses('Opauth', 'Account.Lib/Opauth');

/**
 * Accounts Controller
 *
 */
class OpauthController extends AccountAppController {

	public $uses = array('User');
	
	public function beforeFilter() {
	
		parent::beforeFilter();

		$this->autoRender = false;
		$this->layout = null;
	}

	
	public function authenticate() {

		Opauth::authenticate();
	}	
	
	
	public function endpoint() {

		if (($response = Opauth::endpoint()) !== false) {
			
			if (!$this->Auth->user()) {
			
				$auth = $this->User->Authentication->find('first', array( 
					'conditions' => array('Authentication.provider' => $response['auth']['provider'],'Authentication.identifier' => $response['auth']['uid']),
					'contain' => array('User')	
				));
			
				if (!empty($auth)) {
				
					// auto login
					$this->Auth->login($auth['User']);
					$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'home'));
								
				} else {
				
					// register new user
					if (($id = $this->User->register($response, User::REGISTER_SOCIAL)) != false) {
											
						$auth = $this->User->find('first', array('conditions' => array('User.id' => $id)));
						$this->Auth->login($auth['User']);
						$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'home'));
					} else {					
						$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'login'));
					}				
				}
			} else {
				
				if ($this->User->Authentication->save(array('Authentication' => array(
						'user_id' => $this->Auth->user('id'),
						'provider' => $response['auth']['provider'],
						'identifier' => $response['auth']['uid'],
						'email' => $data['auth']['info']['email'],
						'display_name' => $data['auth']['info']['name'],
						'avatar' => $data['auth']['info']['image'],						 
					)))) {
					
					$this->Session->setFlash('Social linked succesfully','flash',array('type' => 'success'));
				}
				$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'linked'));
			}
			
			return $this->render('endpoint');
		}
		
		if ($this->Auth->user()) {
			$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'linked'));
		} else {
			$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'login'));
		}		
		$this->Session->setFlash('Social linked invalid','flash',array('type' => 'error'));
		return $this->render('endpoint');
	}
}
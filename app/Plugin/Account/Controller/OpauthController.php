<?php

App::uses('AccountAppController', 'Account.Controller');
//App::uses('Opauth', 'Account.Lib/Opauth');

/**
 * Accounts Controller
 *
 */
class OpauthController extends AccountAppController {

	public $uses = array('User');
	
	public function beforeFilter() {
	
		parent::beforeFilter();

		$this->layout = null;
	}

	
	public function authenticate() {
		
		$this->autoRender = false;		
		
		$Opauth = new Opauth( Configure::read('Opauth') );
	}	
	
	
	public function endpoint() {
		
		if ($this->Auth->user()) {
			$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'linked'));
		} else {
			$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'login'));
		}		
		
		$Opauth = new Opauth( Configure::read('Opauth'), false );

		/**
		 * Fetch auth response, based on transport configuration for callback
		 */
		$response = null;		
		switch($Opauth->env['callback_transport']) {
			case 'session':
				$response = $_SESSION['opauth'];
				unset($_SESSION['opauth']);
				break;
			case 'post':
				$response = unserialize(base64_decode( $_POST['opauth'] ));
				break;
			case 'get':
				$response = unserialize(base64_decode( $_GET['opauth'] ));
				break;
			default:
				$this->Session->setFlash('Unsupported callback_transport.','flash',array('type' => 'error'));
				return $this->render('endpoint');
				break;
		}
		
		/**
		 * Check if it's an error callback
		 */
		if (array_key_exists('error', $response)) {
			$this->Session->setFlash('Authentication error: Opauth returns error auth response.','flash',array('type' => 'error'));
		}
		
		/**
		 * Auth response validation
		 *
		 * To validate that the auth response received is unaltered, especially auth response that
		 * is sent through GET or POST.
		 */
		else {
			if (empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])) {
				$this->Session->setFlash('Invalid auth response: Missing key auth response components.','flash',array('type' => 'error'));				
			} elseif (!$Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason)) {
				$this->Session->setFlash(sprintf('Invalid auth response: %s',$reason),'flash',array('type' => 'error'));				
			} else {				
		
				/**
				 * It's all good. Go ahead with your application-specific authentication logic
				 */
				
				if (!$this->Auth->user()) {
						
					$auth = $this->User->Authentication->find('first', array(
						'conditions' => array('Authentication.provider' => $response['auth']['provider'],'Authentication.identifier' => $response['auth']['uid']),
						'contain' => array('User')
					));
						
					if (!empty($auth)) {
						$this->Auth->login($auth['User']);
						$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'play'));
					} else {
						if (($id = $this->User->register($response, User::REGISTER_SOCIAL)) != false) {
							$auth = $this->User->find('first', array('conditions' => array('User.id' => $id)));
							$this->Auth->login($auth['User']);
							$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'play'));
						} else {
							$this->set('redirect_to', array('plugin' => null, 'controller' => 'users','action' => 'login'));
						}
					}
				} else {
				
					if (!$this->User->Authentication->hasAny(array('Authentication.user_id' => $this->Auth->user('id'),'Authentication.provider' => $response['auth']['provider']))) {
						$data = array(
							'Authentication' => array(
								'user_id' => $this->Auth->user('id'),
								'provider' => $response['auth']['provider'],
								'identifier' => $response['auth']['uid'],
								'email' => $data['auth']['info']['email'],
								'display_name' => $data['auth']['info']['name'],
								'avatar' => $data['auth']['info']['image'],
							)
						);
						$this->User->Authentication->create();
						if ($this->User->Authentication->save($data)) {
							$this->Session->setFlash('Social linked succesfully','flash',array('type' => 'success'));
						}
					} else {
						$this->Session->setFlash('Social was linked already','flash',array('type' => 'error'));
					}
				}				
			}
		}
	}
}
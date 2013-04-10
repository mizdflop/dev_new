<?php

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 */
class AppController extends Controller {
	
	public $uses = array('User');
	
	public $helpers = array('Session', 'Form', 'Html', 'Js', 'Number', 'Text', 'Time');
	
	public $components = array(
		'Cookie',
		'Session',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'email','password' => 'password')
				)
			),
			'authorize' => array('Controller')
		),
		'RequestHandler',
			/*'DebugKit.Toolbar'*/
	);
	
	function beforeFilter() {
	
		if (!CakeSession::started()) {
			CakeSession::start();
		}
	
		$this->Auth->allow(array('display'));
	}
	
	function beforeRender() {
	
		if ($this->Auth->user()) {
			$user = $this->User->find('first',array(
				'conditions' => array('User.id' => $this->Auth->user('id'))
			));
			$auth = $user[$this->User->alias];
		} else {
			$auth = null;
		}
	
		$this->set(compact('auth'));
	}
	
	public function isAuthorized($user = null) {
	
		// Any registered user can access public functions
		if (empty($this->request->params['admin'])) {
			return true;
		}
	
		// Only admins can access admin functions
		if (isset($this->request->params['admin'])) {
			return (bool)($user['role'] === 'admin');
		}
	
		// Default deny
		return false;
	}
}
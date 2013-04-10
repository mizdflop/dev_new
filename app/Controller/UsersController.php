<?php
/**
 * Users controller
 * 
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow(array('signup'));	
	}	
	
	public function login() {
		
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect(array('action' => 'home'));
			} else {
				$this->Session->setFlash('Username or password is incorrect', 'flash', array('type' => 'error'), 'auth');
			}
		}
	}
	
	public function logout() {
		
		$this->Auth->logout();		
		$this->redirect('/');
	}
	
	public function signup() {
		
		if ($this->request->is('post')) {
			
			if (($id = $this->User->register($this->request->data, User::REGISTER_GENERAL)) != false) {
				
				$this->Session->setFlash('Thanks for joining monabar!', 'flash', array('type' => 'success'));

				return $this->redirect(array('action' => 'login'));
			}
		}
	}
	
	public function home() {
		
		$user = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
		));
		
		$this->set(compact('user'));		
	}	
}
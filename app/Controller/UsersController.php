<?php
/**
 * Users controller
 * 
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow(array('signup','authenticated'));	
	}	
	
	public function login() {
		
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect(array('action' => 'play'));
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
				
				$this->Session->setFlash('A conformation email has been sent to your account. Please click the link within that email to continue.', 'flash', array('type' => 'success'));

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

	
	public function edit($section = 'account') {
	
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->User->update($section, $this->request->data)) {	
				$this->Session->setFlash('You have updated succesfully', 'flash', array('type' => 'success'));
				return $this->redirect(array('action' => 'home'));
			}
		}
	
		$this->request->data = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
			'contain' => array('Authentication')
		));
	
		return $this->render('profile/'.$section);
	}	
	
	public function linked() {
	
		$user = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
			'contain' => array('Authentication')
		));
		
		$this->set(compact('user'));		
	}	
	
	public function play() {
		
	}
	
	public function authenticated() {
				
		if ($this->Auth->user()) {
			$this->set(array(				'id' => $this->Auth->user('id'),				'_serialize' => array('id')			));				
		} else {
			$this->response->statusCode(401);
			$this->set(array(				'error' => 'User not authorized',				'_serialize' => array('error')			));			
		}
	}
}
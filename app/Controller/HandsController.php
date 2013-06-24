<?php
App::uses('AppController', 'Controller');
/**
 * Hands Controller
 *
 * @property Hand $Hand
 */
class HandsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	/*
	public function index() {
		$this->Hand->recursive = 0;
		$this->set('hands', $this->paginate());
	}*/

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*
	public function view($id = null) {
		if (!$this->Hand->exists($id)) {
			throw new NotFoundException(__('Invalid hand'));
		}
		$options = array('conditions' => array('Hand.' . $this->Hand->primaryKey => $id));
		$this->set('hand', $this->Hand->find('first', $options));
	}*/
	
/**
 * search hand
 */	
	public function search() {
		
		//fb($this->request->query());exit;

		if ($this->request->query('action') == 'search') {
			
			$hand = $this->Hand->search($this->request->query);			
			$this->set(compact('hand'));
		}		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Hand->create();
			if ($this->Hand->save($this->request->data)) {
				$this->set(array('response' => true,'_serialize' => array('response')));				
			} else {
				$this->response->statusCode(401);				$this->set(array('error' => 'Hand not saved','_serialize' => array('error')));				
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*
	public function edit($id = null) {
		if (!$this->Hand->exists($id)) {
			throw new NotFoundException(__('Invalid hand'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Hand->save($this->request->data)) {
				$this->Session->setFlash(__('The hand has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hand could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Hand.' . $this->Hand->primaryKey => $id));
			$this->request->data = $this->Hand->find('first', $options);
		}
	}*/

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*
	public function delete($id = null) {
		$this->Hand->id = $id;
		if (!$this->Hand->exists()) {
			throw new NotFoundException(__('Invalid hand'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Hand->delete()) {
			$this->Session->setFlash(__('Hand deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Hand was not deleted'));
		$this->redirect(array('action' => 'index'));
	}*/
}

<?php

App::uses('ModelBehavior', 'Model');

class AccountBehavior extends ModelBehavior {
	
	protected $_defaults = array(
		'expire' => '+7 days'		
	);	
	
/**
 * Initiate behaviour
 *
 * @param object $Model
 * @param array $settings
 */
	public function setup(Model $Model, $config = array()) {

		// Setup settings
		$settings = array_merge($this->_defaults, $config);
		$this->settings[$Model->alias] = $settings;
		
		// Attach captcha behavior
		if (!$Model->Behaviors->loaded('Captcha.Captcha')) {
			$Model->Behaviors->load('Captcha.Captcha');
		}
		
		// Attach events on model
		$Model->getEventManager()->attach(array($Model,'beforeRegister'), "Model.{$Model->alias}.beforeRegister");
		$Model->getEventManager()->attach(array($Model,'afterRegister'), "Model.{$Model->alias}.afterRegister");
		$Model->getEventManager()->attach(array($Model,'afterCreateToken'), "Model.{$Model->alias}.afterCreateToken");
		
		
		// Bind social models
		$Model->bindModel(array(
			'hasOne' => array(
				'Facebook' => array(
					'className' => 'Account.Authentication',
					'foreignKey' => 'user_id',
					'conditions' => array('Facebook.provider' => 'Facebook'),
					'fields' => '',
					'order' => ''
				),
				'Twitter' => array(
					'className' => 'Account.Authentication',
					'foreignKey' => 'user_id',
					'conditions' => array('Twitter.provider' => 'Twitter'),
					'fields' => '',
					'order' => ''
				),
				'Google' => array(
					'className' => 'Account.Authentication',
					'foreignKey' => 'user_id',
					'conditions' => array('Google.provider' => 'Google'),
					'fields' => '',
					'order' => ''
				),/*
				'LinkedIn' => array(
					'className' => 'Account.Authentication',
					'foreignKey' => 'user_id',
					'conditions' => array('LinkedIn.provider' => 'LinkedIn'),
					'fields' => '',
					'order' => ''
				),*/					
			),
			'hasMany' => array(
				'Authentication' => array(
					'className' => 'Account.Authentication',
					'foreignKey' => 'user_id',
					'dependent' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				),	
				'UserHash' => array(
					'className' => 'Account.UserHash',
					'foreignKey' => 'user_id',
					'dependent' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
				)								
			)				
		), false);
		
	}
	
/**
 * Request reset 
 *
 * @param string $type reset|confirm
 * @param string $field password|email
 * @param array $data post data
 *
 * @return array $user
 */
	public function createToken(Model $Model, $type, $field, $data = array(), $id = null) {
		
		if (empty($field) || empty($type) || !in_array($field, array('password','email')) || !in_array($type, array('reset','confirm'))) {
			throw new InvalidArgumentException('Invalid agruments');
		}		
		
		if (empty($data)) {
			$data = $Model->data;
		}
		
		$action = $type.'_'.$field;
		
		switch ($action) {
			
			case 'reset_password':
				$Model->validator()->remove('email');
				$Model->validator()->remove('captcha');
				$Model->validator()->add('email', array(
					'notempty' => array(
						'rule' => array('notempty'),
						'message' => 'Email address is required',
						'required' => true,
					),
					'email' => array(
						'rule' => array('email'),
						'message' => 'Apply valid email address',
						'required' => true,
					),			
					'exists' => array(
						'rule' => array('fieldExists', array($Model->alias.'.confirm_email' => true)),
						'message' => 'Email address doesnt exists' 		
					)				
				));
				$Model->validator()->add('captcha', array(
					'captcha' => array(
						'rule' => array('captcha'),
						'message' => 'Captcha is wrong'		
					)	
				));
				$Model->set($data);				
				if ($Model->validator()->errors(array('fieldList' => array('email','captcha')))) {
					return false;
				}
				$user = $Model->find('first', array(
					'conditions' => array($Model->alias.'.email' => $data[$Model->alias]['email'])
				));
				
				$Model->UserHash->deleteAll(array(
					$Model->UserHash->alias.'.user_id' => $user[$Model->alias][$Model->primaryKey], 
					$Model->UserHash->alias.'.field' => $field,
					$Model->UserHash->alias.'.type' => $type						
				));
				
				$data = array(
					$Model->UserHash->alias => array(
						'user_id' => $user[$Model->alias][$Model->primaryKey],
						'token' => Security::hash(String::uuid()),
						'expire' => date('Y-m-d H:i:s', strtotime($this->settings[$Model->alias]['expire'])),
						'field' => $field,
						'type' => $type									
					)
				);
				$Model->UserHash->create();
				if ($Model->UserHash->save($data)) {					
					$Model->getEventManager()->dispatch(new CakeEvent("Model.{$Model->alias}.afterCreateToken", $Model, array(
						'id' => $user[$Model->alias][$Model->primaryKey],
						'type' => $type,
						'field' => $field								
					)));
					return $user;
				}			
				break;
				
			case 'reset_email':
				$Model->validator()->remove('password');
				$Model->validator()->add('password', array(
					'notempty' => array(
						'rule' => array('notempty'),
						'message' => 'Password is required',
					),
					'exists' => array(
						'rule' => array('fieldExists', array($Model->alias.'.id' => AuthComponent::user('id'))),
						'message' => 'Password doesnt match'
					)
				));
				$Model->validator()->remove('captcha');
				$Model->validator()->add('captcha', array(
					'captcha' => array(
						'rule' => array('captcha'),
						'message' => 'Captcha is wrong'
					)
				));
				$Model->set($data);
				if ($Model->validator()->errors(array('fieldList' => array('password','captcha')))) {
					return false;
				}				
				$user = $Model->find('first', array(
					'conditions' => array($Model->alias.'.'.$Model->primaryKey => AuthComponent::user('id'))
				));
				
				$Model->UserHash->deleteAll(array(
					$Model->UserHash->alias.'.user_id' => $user[$Model->alias][$Model->primaryKey], 
					$Model->UserHash->alias.'.field' => $field,
					$Model->UserHash->alias.'.type' => $type	
				));
				
				$data = array(
					$Model->UserHash->alias => array(
						'user_id' => $user[$Model->alias][$Model->primaryKey],
						'token' => Security::hash(String::uuid()),
						'expire' => date('Y-m-d H:i:s', strtotime($this->settings[$Model->alias]['expire'])),
						'field' => $field,
						'type' => $type
					)
				);				
				$Model->UserHash->create();
				if ($Model->UserHash->save($data)) {
					$Model->getEventManager()->dispatch(new CakeEvent("Model.{$Model->alias}.afterCreateToken", $Model, array(
						'id' => $user[$Model->alias][$Model->primaryKey],
						'type' => $type,
						'field' => $field
					)));						
					return $user;
				}				
				break;
					
			case 'confirm_email':
				if (empty($id)) {
					throw new InvalidArgumentException('Invalid agruments');
				}
				$user = $Model->find('first',array(
					'conditions' => array($Model->alias.'.'.$Model->primaryKey => $id, $Model->alias.'.confirm_email' => false)
				));
	
				if (!empty($user)) {
					
					$Model->UserHash->deleteAll(array(
						$Model->UserHash->alias.'.user_id' => $user[$Model->alias][$Model->primaryKey],
						$Model->UserHash->alias.'.field' => $field,
						$Model->UserHash->alias.'.type' => $type
					));
					$data = array(
						$Model->UserHash->alias => array(
							'user_id' => $user[$Model->alias][$Model->primaryKey],
							'token' => Security::hash(String::uuid()),
							'expire' => date('Y-m-d H:i:s', strtotime($this->settings[$Model->alias]['expire'])),
							'field' => $field,
							'type' => $type
						)
					);
					$Model->UserHash->create();
					if ($Model->UserHash->save($data)) {
						$Model->getEventManager()->dispatch(new CakeEvent("Model.{$Model->alias}.afterCreateToken", $Model, array(
							'id' => $user[$Model->alias][$Model->primaryKey],
							'type' => $type,
							'field' => $field
						)));
						return $user;
					}
				} 			
				break;	
		}
	
		return false;
	}	

/**
 * Validates the user token
 *
 * @param string $field type
 * @param string $token Token
 *
 * @return mixed false or user data
 */
	public function verifyToken(Model $Model, $type, $field, $token = null) {
		
		if (empty($field) || empty($token) || empty($type) || !in_array($field,array('email','password'))) {
			throw new InvalidArgumentException('Invalid arguments');
		}		
	
		$now = time();
		
		$Model->UserHash->deleteAll(array($Model->UserHash->alias.'.expire < NOW()'));
		
		$match = $Model->UserHash->find('first', array(
			'conditions' => array($Model->UserHash->alias . '.token' => $token, $Model->UserHash->alias . '.field' => $field),
			'contain' => array($Model->alias)
		));
		if (!empty($match)) {
			$expire = strtotime($match[$Model->UserHash->alias]['expire']);
			if ($expire > $now) {
				return $match;
			} else {
				if ($field == 'email') {
					$Model->delete($match[$Model->alias]['id']);
				} else {
					$Model->UserHash->deleteAll(array($Model->UserHash->alias . '.token' => $token, $Model->UserHash->alias . '.field' => $field));
				}
			}
		}
		return false;
	}	
	
	
/**
 * Confirm email address and activation account
 *
 * @param int $id user id
 *
 * @return boolean
 */
	public function confirm(Model $Model, $field, $id, $data = array()) {
		
		if (empty($field) || empty($id) || !in_array($field,array('email'))) {
			throw new InvalidArgumentException('Invalid arguments');
		}		
	
		$user = $Model->find('first',array(
			'conditions' => array($Model->alias.'.'.$Model->primaryKey => $id),
		));
		
		if (empty($user)) {
			throw new CakeException('User not found');
		}		
		
		switch ($field) {
			case 'email':
				$Model->id = $id;
				if ($Model->saveField('confirm_'.$field,true)) {
					return $Model->UserHash->deleteAll(array($Model->UserHash->alias.'.user_id' => $id, $Model->UserHash->alias.'.field' => $field));
				}				
				break;
		}		
		
		return false;
	}	
	
/**
 * Reset 
 * 
 * @param string $field 
 * @param int $id
 * @param array $data
 */	
	public function reset(Model $Model, $field, $id, $data = array()) {
		
		if (empty($field) || empty($id) || !in_array($field,array('email','password'))) {
			throw new InvalidArgumentException('Invalid arguments');
		}		
		
		$user = $Model->find('first',array(
			'conditions' => array($Model->alias.'.'.$Model->primaryKey => $id)	
		));
		
		if (empty($user)) {
			throw new CakeException('User not found');
		}
		
		switch ($field) {
			case 'password':
				$Model->validator()->remove('captcha');
				$Model->validator()->add('captcha', array(
					'captcha' => array(
						'rule' => array('captcha'),
						'message' => 'Captcha is wrong'
					)
				));				
				$data[$Model->alias]['id'] = $id;
				if ($Model->save($data,true,array('password','confirm_password','captcha'))) {
					return $Model->UserHash->deleteAll(array(
						$Model->UserHash->alias.'.user_id' => $id, 
						$Model->UserHash->alias.'.field' => $field,
						$Model->UserHash->alias.'.type' => 'reset'							
					));
				}				
				break;
			case 'email':
				$Model->validator()->remove('captcha');
				$Model->validator()->add('captcha', array(
					'captcha' => array(
						'rule' => array('captcha'),
						'message' => 'Captcha is wrong'
					)
				));				
				$data[$Model->alias]['id'] = $id;
				if ($Model->save($data,true,array('email','captcha'))) {
					return $Model->UserHash->deleteAll(array(
						$Model->UserHash->alias.'.user_id' => $id, 
						$Model->UserHash->alias.'.field' => $field,
						$Model->UserHash->alias.'.type' => 'reset'
					));
				}				
				break;	
		}
		
		return false;
	}	
	
/**
 * Register new user
 */	
	public function register(Model $Model, $data, $type = null) {
		
		$event = new CakeEvent("Model.{$Model->alias}.beforeRegister", $Model, compact('data','type'));
		$Model->getEventManager()->dispatch($event);
		if ($event->isStopped()) {
			return false;
		}		

		extract($event->result,EXTR_OVERWRITE);
		
		if ($Model->saveAll($data, compact('validate','fieldList'))) {
			
			$event = new CakeEvent("Model.{$Model->alias}.afterRegister", $Model, array('id' => $Model->id,'type' => $type));
			$Model->getEventManager()->dispatch($event);
			if ($event->isStopped()) {
				return false;
			}				
			return $Model->id;
		} else {
			return false;
		}		
	}	

/**
 * Additional validation rules
 * 
 */	
	public function fieldExists(Model $Model, $check, $scope = array()) {
	
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if ($field == 'password') {
			$value = AuthComponent::password($value);
		}
		
		$conditions = array($Model->alias.'.'.$field => $value);
		if (!empty($scope)) {
			$conditions = Set::merge($scope,$conditions); 
		}
	
		if ($Model->hasAny($conditions)) {
			return true;
		}
	
		return false;
	}	
	
	
	protected function _removeExpiredTokens(Model $Model) {
		return $Model->UserHash->deleteAll(array('UserHash.expire < NOW()'));
	}	
	
}
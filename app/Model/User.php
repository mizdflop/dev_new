<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 * 
 * @property Invitation $Invitation
 *
 */
class User extends AppModel {
	
	const REGISTER_GENERAL = 'general';
	
	const REGISTER_SOCIAL = 'social';
	
	public $actsAs = array(
		'Upload' => array(
			'avatar' => array(
				'thumbnails' => array(
					'small' => array('type' => 'thumbnail','size' => '50x50'),
					'large' => array('type' => 'thumbnail','size' => '300x300')
				)
			)
		),
		'Account.Account' => array(
			'expire' => '+7 days',
		)					
	);		
		
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your first name',
				'required' => true,
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your last name',
				'required' => true,
			),
		),				
		'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your email address',
				'required' => true,
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Your email address doesn\'t appear to be valid',
				'required' => true,
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Your email address is already linked to an existing account',
				'required' => true,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a password',
				'required' => true,
			),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'message' => 'Your password needs to be at least 6 characters long',
				'required' => true,
			),
		),
		'confirm_password' => array(
			'compareTo' => array(
				'rule' => array('compareTo','password'),
				'message' => 'Your passwords don\'t match',
				'required' => true,
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please confirm your password',
				'required' => true,
			),
		),			
		'avatar' => array(
			'maxSize' => array(
				'rule' => array('maxSize', '10MB'),
				'message' => 'Sorry your photo is too big!',
				'required' => true,
			),
			'ext' => array(
				'rule' => array('ext'),
				'message' => 'Apply a image!',
				'required' => true,
			),
			'minWidth' => array(
				'rule' => array('minWidth', 50),
				'required' => true,
			),
			'minHeight' => array(
				'rule' => array('minHeight', 50),
				'required' => true,
			)
		),		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
	
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
	
	);
	
	public function beforeSave($options = array()) {

		if (!empty($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}

		return true;
	}
	
/**
 * Account plugin
 * Before register callback
 * 
 * @param CakeEvent $event
 *  - type general|social
 *  - data CakeRequest::data 
 * 
 * @return boolean
 */
	public function beforeRegister(CakeEvent $event) {		
		
		extract($event->data, EXTR_OVERWRITE);		
		
		switch ($type) {
			
			case self::REGISTER_GENERAL:
				$fieldList = array(
					$this->alias => array('first_name','last_name','email','password','confirm_password','confirm_email'),
				);
				$data[$this->alias]['confirm_email'] = false;
				$validate = 'first';
				$event->result = compact('data','fieldList','validate');
				break;
				
			case self::REGISTER_SOCIAL:
				$fieldList = array(
					$this->alias => array('username','first_name','last_name','email','confirm_email'),
					$this->Authentication->alias => array('user_id','provider','identifier','email','display_name','avatar')
				);				
				$data = array(
					$this->alias => array(
						'username' => $data['auth']['info']['nickname'],
						'first_name' => $data['auth']['info']['first_name'],
						'last_name' => $data['auth']['info']['last_name'],																
						'email' => $data['auth']['info']['email'],
						'confirm_email' => true								
					),
					$this->Authentication->alias => array(
						array(
							'provider' => $data['auth']['provider'],
							'identifier' => $data['auth']['uid'],
							'email' => $data['auth']['info']['email'],
							'display_name' => $data['auth']['info']['name'],
							'avatar' => $data['auth']['info']['image'],
						)		
					)
				);
				$validate = false;				
				$event->result = compact('data','fieldList','validate');
				break;
				
			default:
				return false;
		}		
	}
	
/**
 * Account plugin
 * Before register callback
 * 
 * @param CakeEvent $event
 * 	- id User::id
 * 	- type general|social
 * 
 */
	public function afterRegister(CakeEvent $event) {

		if ($event->data['type'] == User::REGISTER_GENERAL) {
			return $this->createToken('confirm', 'email', array(), $event->data['id']);
		}
		
		return true;
	}
	
/**
 * Account plugin
 * After create token/hash
 * 
 * @param CakeEvent $event
 *	- id User::id
 *	- field email|password
 *	- type reset|confirm  		
 * 
 */
	public function afterCreateToken(CakeEvent $event) {
		
		extract($event->data, EXTR_OVERWRITE);		
	
		$user = $this->find('first',array(
			'conditions' => array($this->alias.'.id' => $id),
			'contain' => array(
				$this->UserHash->alias => array(
					'conditions' => array(
						$this->UserHash->alias.'.field' => $field,
						$this->UserHash->alias.'.type' => $type
					)
				)
			)
		));
		
		if (empty($user[$this->UserHash->alias])) {
			return true;
		}
		
		$action = $type.'_'.$field;
	
		$email = new CakeEmail('default');
	
		switch ($action) {
			case 'reset_password':
				$email->viewVars(compact('user'))->template('request_reset_password')->subject(__d('users', 'Password Reset'))->to(array($user['User']['email'] => $user['User']['first_name']))->send();
				break;
			case 'reset_email':
				$email->viewVars(compact('user'))->template('request_reset_email')->subject(__d('users', 'Email Reset'))->to(array($user['User']['email'] => $user['User']['first_name']))->send();
				break;
			case 'confirm_email':
				$email->viewVars(compact('user'))->template('account_verification')->subject(__d('users', 'Activate Your Account'))->to(array($user['User']['email'] => $user['User']['first_name']))->send();
				break;
		}
		
		return true;
	}

	
	/**
	 * Update account logged user
	 *
	 * @param string $type account|payout|avatar
	 * @param array $data CakeRequest::data
	 *
	 * @return boolean
	 */
	public function update($section, $data = array()) {
	
		if (empty($data)) {
			$data = $this->data;
		}
	
		$data[$this->alias]['id'] = AuthComponent::user('id');
	
		switch ($section) {
				
			case 'account':
				$user = $this->find('first', array(
					'conditions' => array($this->alias.'.id' => AuthComponent::user('id')),
					'contain' => array('Authentication')
				));
				$fieldList = array(
					$this->alias => array('first_name','last_name','avatar')
				);
				if (!empty($data[$this->alias]['password'])) {
					$fieldList = Set::merge($fieldList, array($this->alias => array('password','confirm_password')));
				}
				if (!empty($user['Authentication'])) {
					$fieldList = Set::merge($fieldList, array($this->alias => array('email')));
				}
				$validate = 'first';
				break;
			case 'avatar':
				break;
	
			default:
				return false;
		}
	
		return $this->saveAll($data, compact('validate','fieldList'));
	}	
}
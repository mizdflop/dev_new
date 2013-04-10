<?php

App::uses('AccountAppModel', 'Account.Model');

/**
 * UserHash Model
 *
 * @property User $User
 */
class UserHash extends AccountAppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'required' => true,
			),
		),
		'token' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'required' => true,
			),
		),
		'expire' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'required' => true,
			),
		),		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}

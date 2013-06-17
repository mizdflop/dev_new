<?php
App::uses('AppModel', 'Model');
/**
 * Hand Model
 *
 * @property Action $Action
 * @property Street $Street
 */
class Hand extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
/** * belongsTo associations * * @var array */	public $belongsTo = array(		'User' => array(			'className' => 'User',			'foreignKey' => 'user_id',			'conditions' => '',			'fields' => '',			'order' => ''		)	);	

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Street' => array(
			'className' => 'Street',
			'foreignKey' => 'hand_id',
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
	);

}

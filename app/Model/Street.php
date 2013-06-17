<?php
App::uses('AppModel', 'Model');
/**
 * Street Model
 *
 * @property User $User
 * @property Hand $Hand
 */
class Street extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Hand' => array(
			'className' => 'Hand',
			'foreignKey' => 'hand_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
/** * hasMany associations * * @var array */	public $hasMany = array(		'Action' => array(			'className' => 'Action',			'foreignKey' => 'street_id',			'dependent' => true,			'conditions' => '',			'fields' => '',			'order' => '',			'limit' => '',			'offset' => '',			'exclusive' => '',			'finderQuery' => '',			'counterQuery' => ''		),	);	
}

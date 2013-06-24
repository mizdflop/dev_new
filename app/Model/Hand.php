<?php
App::uses('AppModel', 'Model');
/**
 * Hand Model
 *
 * @property Action $Action
 * @property Street $Street
 * @property HandHistory $HandHistory
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
		),
		'HandHistory' => array(			'className' => 'HandHistory',			'foreignKey' => 'hand_id',			'dependent' => true,			'conditions' => '',			'fields' => '',			'order' => '',			'limit' => '',			'offset' => '',			'exclusive' => '',			'finderQuery' => '',			'counterQuery' => ''		),						
	);
	
	
	public function search($query) {		

		//$fields = array('Hand.id','Hand.timestamp','Hand.session','Street.street','Action.action','Action.id','Action.skill_score','User.first_name','User.last_name','User.id','HandHistory.parsed_hand_history');
		$joins = array(			array(				'table' => 'streets',				'alias' => 'Street',				'type' => 'LEFT',				'conditions' => array('Street.id = Action.street_id')			),			array(				'table' => 'hands',				'alias' => 'Hand',				'type' => 'LEFT',				'conditions' => array('Hand.id = Street.hand_id')			),
			array(				'table' => 'users',				'alias' => 'User',				'type' => 'LEFT',				'conditions' => array('User.id = Hand.user_id')			),
			array(				'table' => 'hand_histories',				'alias' => 'HandHistory',				'type' => 'LEFT',				'conditions' => array('HandHistory.hand_id = Hand.id')			)		);		
		$conditions = array();
		//$order = 'Street.street, Action.id';
		$contain = array(
			'User',
			'HandHistory',
			'Street' => array(
				'order' => 'Street.street',	
				'Action' => array('order' => 'Action.id')
			)	
		);
				foreach ($query as $key => $value) {			if ($value) {				if (!is_array($value)) {					$value = trim($value);				}				switch ($key) {					case 'hand_id':
						$conditions['OR']['Hand.id'] = $value;
						break;					case 'session_id':
						$conditions['OR'][0]['Hand.session'] = $value;						break;
					case 'hand_number':						$conditions['OR'][0]['Hand.hand_number'] = $value;						break;
					case 'most_recent_hand':
						$conditions = array('Hand.id = (SELECT MAX(hands.id) FROM hands)');
						break;						default:						break;				}			}		}
		
		return $this->find('first', compact('conditions','contain'));	}
}

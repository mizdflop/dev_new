<?phpApp::uses('AppModel', 'Model');/** * HandHistory Model * * @property Hand $Hand */class HandHistory extends AppModel {	/** * Validation rules * * @var array */	public $validate = array(		);	//The Associations below have been created with all possible keys, those that are not needed can be removed	/** * belongsTo associations * * @var array*/	public $belongsTo = array(		'Hand' => array(			'className' => 'Hand',			'foreignKey' => 'hand_id',			'conditions' => '',			'fields' => '',			'order' => ''		)	);}
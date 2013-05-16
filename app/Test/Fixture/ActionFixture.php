<?php
/**
 * ActionFixture
 *
 */
class ActionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'hand_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'street' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'action_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'hand_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'skill_score' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'max_equity' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'did_you_end_up_folding' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'action' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'action_amount' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'hand_id' => 1,
			'user_id' => 1,
			'street' => 1,
			'action_number' => 1,
			'hand_number' => 1,
			'skill_score' => 1,
			'max_equity' => 1,
			'did_you_end_up_folding' => 1,
			'action' => 1,
			'action_amount' => 1,
			'created' => '2013-05-16 05:56:34'
		),
	);

}

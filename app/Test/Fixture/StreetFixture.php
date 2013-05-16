<?php
/**
 * StreetFixture
 *
 */
class StreetFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'hand_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'street' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'hand_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'chance' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'situation' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
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
			'user_id' => 1,
			'hand_id' => 1,
			'street' => 1,
			'hand_number' => 1,
			'chance' => 1,
			'situation' => 1,
			'created' => '2013-05-16 05:58:38'
		),
	);

}

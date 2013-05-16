<?php
App::uses('Hand', 'Model');

/**
 * Hand Test Case
 *
 */
class HandTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.hand',
		'app.action',
		'app.user',
		'app.authentication',
		'app.user_hash',
		'app.street'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Hand = ClassRegistry::init('Hand');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Hand);

		parent::tearDown();
	}

}

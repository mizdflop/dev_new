<?php

	Router::connect('/account/confirm/:field', array('plugin' => 'Account','controller' => 'account','action' => 'confirm'), array(
		'pass' => array('field')
	));
	Router::connect('/account/confirm/:field/:token', array('plugin' => 'Account','controller' => 'account','action' => 'confirm'), array(
		'pass' => array('field','token')
	));
	Router::connect('/account/reset/:field', array('plugin' => 'Account','controller' => 'account','action' => 'reset'), array(
		'pass' => array('field')
	));	
	Router::connect('/account/reset/:field/:token', array('plugin' => 'Account','controller' => 'account','action' => 'reset'), array(
		'pass' => array('field','token')
	));	
	
/**
 * Routers for connect social
 */
	Router::connect('/auth/login/:provider/*',array('plugin' => 'Account','controller' => 'opauth','action' => 'authenticate'),array('pass' => array('provider')));
	Router::connect('/auth/endpoint',array('plugin' => 'Account','controller' => 'opauth','action' => 'endpoint'));	
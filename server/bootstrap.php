<?php

	error_reporting(E_ALL & ~E_DEPRECATED);
/**
 * 
 */	
	
/**
 * Path to the config directory.
 */
	if (!defined('CONFIG')) {
		define('CONFIG', ROOT . 'Config' . DS);
	}	

/**
 * Path to the application's libs directory.
 */
	define('LIBS', ROOT . 'Lib' . DS);
	
/**
 * Path to the vendors directory.
 */
	if (!defined('VENDOR')) {
		define('VENDOR', ROOT . 'vendor' . DS);
	}
/*
 * Basic functions
 */
	require ROOT . 'basics.php';
	
/**
 * Composer autoload vendor libs 
 */
	require VENDOR . 'autoload.php';
	
/**
 * App config 
 */	
	require CONFIG . 'application.php';
	
/**
 * Require the Poker Lib
 *
 * If you are not using Composer, you need to require the
 * Poker Lib and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */	
	require_once LIBS . 'Poker' . DS . 'Poker.php';
	
	\Poker\Poker::registerAutoloader();
	
/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
	$app = new \Slim\Slim($appConfig);	
	
	$app->error(function (\Exception $e) use ($app) {
		$app->response()->status(400);
		$app->response()->header('Content-Type', 'application/json');
		echo json_encode(array('error' => $e->getMessage()));
	});	
	
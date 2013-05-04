<?php

/**
 * Use the DS to separate the directories in other defines
 */
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}

/**
 * The full path to the directory which holds "Lib"
 *
 */
	if (!defined('ROOT')) {
		define('ROOT', dirname(dirname(__FILE__)));
	}

/**
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 *
 */
	if (!defined('WWW_ROOT')) {
		define('WWW_ROOT', dirname(__FILE__) . DS);
	}
	
/**
 * Step 1: Bootstrap
 *
 */
	require_once ROOT . DS . 'bootstrap.php';

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */
 
	// GET route

	$app->get('/', function() use ($app) {
		
		$app->response()->header('Content-Type', 'application/json');

		$parser = \Poker\Parser\Parser::parse('./data/game.txt');
		
		echo json_encode($parser->games);		
	});	
	
	$app->get('/pages/:name', function ($name) use ($app)  {
	
		/*
		$res = $app->response();
		$res['Content-Type'] = 'application/json';
		echo json_encode(compact('name'));
		*/
	});		

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
	$app->run();
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
		define('ROOT', dirname(dirname(__FILE__)).DS);
	}

/**
 * Step 1: Bootstrap
 *
 */
	require_once ROOT . 'bootstrap.php';

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */
 
	$app->post('/get_all_scores.json', function() use ($app) {
		
		$handHistory = $app->request()->post('hand_histrory');
		if (empty($handHistory)) {
			$app->halt(400,'hand_history param is require.');
		}

		$parser = \Poker\Parser\Parser::parse($handHistory);
		
		$app->response()->header('Content-Type', 'application/json');		
		echo json_encode($parser->games);		
	});

	$app->post('/get_skill_scores', function() use ($app) {
		
	});
	
/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
	$app->run();
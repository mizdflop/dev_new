<?php
/**
 * Step 1: Bootstrap
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
	require 'vendor/autoload.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
 	$app = new \Slim\Slim();
	
/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */
 
	// GET route
	$app->get('/', function () use ($app) {
		
		$app->response()->header('Content-Type', 'application/json');
		
		$parser = new \Poker\Parser\FullTilt('./data/game2.txt');
		$parser->parse();
		
		echo json_encode($parser->game);		
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
<?php

	error_reporting(E_ALL & ~E_DEPRECATED);
	
/**
 * Path to the config directory.
 */
	if (!defined('CONFIG')) {
		define('CONFIG', ROOT . DS . 'Config' . DS);
	}	

/**
 * Path to the application's libs directory.
 */
	define('LIBS', ROOT . DS . 'Lib' . DS);
	
/**
 * Path to the vendors directory.
 */
	if (!defined('VENDOR')) {
		define('VENDOR', ROOT . DS . 'vendor' . DS);
	}
/*
 * Basic functions
 */
	require ROOT . DS . 'basics.php';
	
/**
 * Composer autoload vendor libs 
 */
	require VENDOR . 'autoload.php';
	
/**
 * App config 
 */	
	require_once CONFIG . 'application.php';
	
/**
 * Poker load
 */
	require_once LIBS . 'Poker' . DS . 'Action.php';
	require_once LIBS . 'Poker' . DS . 'Event.php';
	require_once LIBS . 'Poker' . DS . 'Game.php';
	require_once LIBS . 'Poker' . DS . 'Player.php';
	require_once LIBS . 'Poker' . DS . 'Player.php';
	
	require_once LIBS . 'Poker' . DS . 'Parser' .DS . 'Base.php';
	require_once LIBS . 'Poker' . DS . 'Parser' .DS . 'FullTilt.php';
	require_once LIBS . 'Poker' . DS . 'Parser' .DS . 'PartyPoker.php';
	require_once LIBS . 'Poker' . DS . 'Parser' .DS . 'PokerStars.php';
	
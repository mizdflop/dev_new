<?php

$appConfig = array(

/**
 * This is an identifier for the application’s current mode of operation. The mode does not affect a Slim application’s internal functionality. 
 * Instead, the mode is only for you to optionally invoke your own code for a given mode with the configMode() application method.
 *
 * The application mode is declared during instantiation, either as an environment variable or as an argument to the Slim application constructor. 
 * It cannot be changed afterward. The mode may be anything you want — “development”, “test”, and “production” are typical, but you are free to use anything you want (e.g. “foo”).
 */		
	'mode' => 'development',
		
/**
 * If debugging is enabled, Slim will use its built-in error handler to display diagnostic information for uncaught Exceptions. 
 * If debugging is disabled, Slim will instead invoke your custom error handler, passing it the otherwise uncaught Exception as its first and only argument.
 */
	'debug' => true,
		
/**
 * Use a custom log writer to direct logged messages to the appropriate output destination. By default, Slim’s logger will write logged messages to STDERR. 
 * If you use a custom log writer, it must implement this interface:
 *
 * 	public write(mixed $message, int $level);
 * 
 * The write() method is responsible for sending the logged message (not necessarily a string) to the appropriate output destination (e.g. a text file, a database, or a remote web service).
 */
	//'log.writer' => new \My\LogWriter()

/**
 * Slim has five (5) log message levels:

	\Slim\Log::DEBUG
	\Slim\Log::INFO
	\Slim\Log::WARN
	\Slim\Log::ERROR
	\Slim\Log::FATAL
	
 */
	'log.level' => \Slim\Log::DEBUG,	

/**
 * This enables or disables Slim’s logger.
 */		
	'log.enabled' => true,
		
/**
 * The relative or absolute path to the filesystem directory that contains your Slim application’s template files. 
 * This path is referenced by the Slim application’s View to fetch and render templates.
 */
	'templates.path' => '../templates',

/**
 * The View class or instance used by the Slim application
 */		 
	//'view' => new \My\View()

/**
 * Determines the lifetime of HTTP cookies created by the Slim application. If this is an integer, it must be a valid UNIX timestamp at which the cookie expires. 
 * If this is a string, it is parsed by the strtotime() function to extrapolate a valid UNIX timestamp at which the cookie expires.
 */
	'cookies.lifetime' => '20 minutes',

/**
 * Determines the default HTTP cookie path if none is specified when invoking the Slim application’s setCookie() or setEncryptedCookie() methods.
 */		
	'cookies.path' => '/',
		
/**
 * Determines the default HTTP cookie domain if none specified when invoking the Slim application’s setCookie() or setEncryptedCookie() methods.
 */		
	'cookies.domain' => null,

/**
 * 
 */		
	'cookies.secure' => false,

		
	'cookies.httponly' => false,


	'cookies.secret_key' => 'secret',

		
	'cookies.cipher' => MCRYPT_RIJNDAEL_256,

		
	'cookies.cipher_mode' => MCRYPT_MODE_CBC,

		
	'http.version' => '1.1',		
		
);
<?php

/**
 * Autoloader for Imagine
 */
	spl_autoload_register(function($class){
		$path = $class;
		$path = APP.'Plugin'.DS.'Media'.DS.'Lib'.DS.str_replace('\\', DS, $path) . '.php';
		if (file_exists($path)) {
			require_once $path;
		}	
	});
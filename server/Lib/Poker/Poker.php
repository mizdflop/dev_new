<?php

namespace Poker;

/**
 * Poker's main resource pool and initialization & configuration class.
 *
 * This static class is used to handle Propel initialization and to maintain all of the
 * open database connections and instantiated database maps.
 *
 */
class Poker {
	
	/********************************************************************************
	 * PSR-0 Autoloader
	*
	* Do not use if you are using Composer to autoload dependencies.
	*******************************************************************************/
	
	/**
	 * Poker PSR-0 autoloader
	 */
	public static function autoload($className)
	{
		
		$thisClass = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
	
		$baseDir = __DIR__;
	
		if (substr($baseDir, -strlen($thisClass)) === $thisClass) {
			$baseDir = substr($baseDir, 0, -strlen($thisClass));
		}
	
		$className = ltrim($className, '\\');
		$fileName  = $baseDir;
		$namespace = '';
		if ($lastNsPos = strripos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	
		if (file_exists($fileName)) {
			require $fileName;
		}
	}
	
	/**
	 * Register Poker's PSR-0 autoloader
	 */
	public static function registerAutoloader()
	{
		spl_autoload_register(__NAMESPACE__ . "\\Poker::autoload");
	}	
}

<?php

App::uses('FirePHP', 'FirePHP.Lib');

/*
 * Start output buffering. Turn on output buffering if option( output_buffering ) isnt set in php.ini
*/
	ob_start();

/**
 * Register error handler
 */	
	Configure::write('Error.handler', 'FirePHP::errorHandler');
	
/**
 * Register exception handler
 */	
	//Configure::write('Exception.handler', 'FirePHP::exceptionHandler');
	
/**
 * Register sql log to console
 */	
	register_shutdown_function(function() {
		if (!class_exists('ConnectionManager') || Configure::read('debug') < 2) {
			return;
		}
		$sources = ConnectionManager::sourceList();
		$logs = array();
		foreach ($sources as $source){
			$db = ConnectionManager::getDataSource($source);
			if (!method_exists($db, 'getLog'))
				continue;
			$logs[$source] = $db->getLog();
		}
		foreach ($logs as $source => $logInfo) {			
			$text = $logInfo['count'] > 1 ? 'queries' : 'query';
			
			$label = "{$logInfo['count']} {$text} took {$logInfo['time']} ms (DESCRIBE queries are not shown)";
			$table = array();
			$table[] = array("Nr", "Query", "Affected", "Num. rows", "Took (ms)");
			foreach ($logInfo['log'] as $k => $i) {            	
				// Filter numerous DESCRIBE queries from to be shown
				if (false !== stristr($i['query'],'DESCRIBE')) {
					continue;
				}				
				$table[] = array(($k + 1), $i['query'], $i['affected'], $i['numRows'], $i['took']);
			}
			if (count($table) > 1) {
				fb($table,$label,FirePHP::TABLE);
			}	
		}		
	});
	
/**
 * Register execution time to console
 */	
	register_shutdown_function(function() {
    	if (Configure::read('debug') > 0) {
    		fb("Execution time: " . round(microtime(true) - env('REQUEST_TIME'),6) . "s");
    	}    	
    });
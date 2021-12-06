<?php

function GAS_autoloader($className) {
    
  	$path = __DIR__ . "/" . str_replace("\\", DIRECTORY_SEPARATOR, trim($className, "\\")).".php";

	if(file_exists($path)) {
		require_once $path;
	}
}

spl_autoload_register('GAS_autoloader');

require "bootstrap.php";
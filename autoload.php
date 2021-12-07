<?php

/* this is probably 'funky' and should be updated for v1.0 */
function GAS_autoloader($className) {
   	$className = str_replace("lray138\\GAS\\", "", $className);
  	$path = __DIR__ . "/" . str_replace("\\", DIRECTORY_SEPARATOR, trim($className, "\\")).".php";

	if(file_exists($path)) {
		require_once $path;
	}
}

spl_autoload_register('GAS_autoloader');
<?php 

namespace lray138\GAS;

/* this is probably 'funky' and should be updated for v1.0,
this note applied to ??? it might be ok.
had this code previously in another file called 'autoload' mostly because I 
saw others use that name.  I like bootstrap better and also the code being in the same 
file is probably less clutter.
 */
function GAS_autoloader($className) {
   	$className = str_replace("lray138\\GAS\\", "", $className);
  	$path = __DIR__ . "/" . str_replace("\\", DIRECTORY_SEPARATOR, trim($className, "\\")).".php";

	if(file_exists($path)) {
		require_once $path;
	}
}

spl_autoload_register(__NAMESPACE__ . '\GAS_autoloader');

require 'Arr.php';
require 'Calendar.php';
require 'DateTime.php';
require 'DOMDocument.php';
require 'Functional.php';
require 'Filesystem.php';
require 'GasSystem.php';
require 'HTML.php';
require 'IO.php';
require 'Math.php';
require 'Model.php';
require 'Numbers.php';
require 'PDO.php';
require 'ProcessWire.php';
require 'Regex.php';
require 'Str.php';
require 'SQL.php';
require 'TypeChecks.php';
require 'Tree.php';
require 'XML.php';
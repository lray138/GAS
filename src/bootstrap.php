<?php 

namespace lray138\GAS;

/* this is probably 'funky' and should be updated for v1.0,
this note applied to ??? it might be ok.
had this code previously in another file called 'autoload' mostly because I 
saw others use that name.  I like bootstrap better and also the code being in the same 
file is probably less clutter.
 */
// function GAS_autoloader($className) {
//    	$className = str_replace("lray138\\GAS\\", "", $className);
//   	$path = __DIR__ . "/" . str_replace("\\", DIRECTORY_SEPARATOR, trim($className, "\\")).".php";

// 	if(file_exists($path)) {
// 		require_once $path;
// 	}
// }

// spl_autoload_register(__NAMESPACE__ . '\GAS_autoloader');

// removing above will delete after success, using psr-4 now.

require 'Arr.php';
require 'Calendar.php';
require 'DateTime.php';
require 'HTML5DOM.php';
require 'Functional.php';
require 'Filesystem.php';
require 'GasSystem.php';
require 'GAS.php';
require 'PHTML.php';
require 'HTML.php';
require 'HTMLForm.php';
require 'IO.php';
require 'Math.php';
require 'Model.php';
require 'Numbers.php';
require 'PDO.php';
require 'ProcessWire.php';
require 'Regex.php';
require 'Str.php';
require 'SQL.php';
require 'Types.php';
require 'Tree.php';
require 'Tools.php';
require 'XML.php';
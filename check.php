<?php 

require "vendor/autoload.php";

use lray138\GAS\Filesystem as FS;

spl_autoload_register(function ($class) {
    $prefix = 'lray138\\';
    $base_dir = __DIR__ . '/src/';

    // If the class does not use the "App" namespace, move on
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace namespace separators with directory separators
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    $file = str_replace("/src/GAS/", "/src/", $file);

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

FS\getFilesInDir_("src/Str")
    ->walk(function($x) {
        
        $testfile = str_replace(["src/", ".php"], ["tests/Unit/", "Test.php"], $x);

        $function = str_replace(["src/", ".php", "/"], ["", "", "\\"], $x); 

       $functionContent = <<<PHP
<?php 

use lray138\GAS\\$function;


PHP;
        if(!file_exists($testfile)) {
            echo "creating $testfile";
            file_put_contents($testfile, $functionContent);
        }

    });

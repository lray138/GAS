<?php 

require "vendor/autoload.php";

use lray138\GAS\Filesystem as FS;
use lray138\GAS\Str;

use function lray138\GAS\Functional\{extract, paths};
use const lray138\GAS\Functional\extract;

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
<?php namespace lray138\GAS;

require "vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as Res;

use lray138\GAS\Types\ArrType as Arr;
use function lray138\GAS\dump;

use \lray138\GAS\Types\Guz;

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

$g = Guz::get('https://reqfasdfres.in/api/users/2')
    ->map(fn(Res $r) => Arr::of(json_decode($r->getBody(), true)))
    ->run()
    //->then(fn() => asdf())
    ->wait();
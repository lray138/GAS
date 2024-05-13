<?php

use lray138\GAS\Types\Maybe;

// error_reporting(E_ALL | E_DEPRECATED | E_USER_DEPRECATED);

// // Register the custom error handler
// set_error_handler('customErrorHandler');

// // Define a custom error handler function
// function customErrorHandler($errno, $errstr, $errfile, $errline) {
//     if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
//         // Log or report the deprecation notice here
//         die ("HERE");
//         echo "Deprecation notice: $errstr\n";
//     }
// }

it('returns a Maybe instance when calling static::of()', function () {
    $maybe = Maybe::of(10);
    expect($maybe)->toBeInstanceOf(Maybe::class);
});

it('returns a Maybe instance when calling static::unit()', function () {
    $maybe = Maybe::unit(20);
    expect($maybe)->toBeInstanceOf(Maybe::class);
});

it('extracts the value correctly', function () {
    $value = 30;
    $maybe = Maybe::of($value);
    expect($maybe->extract())->toBe($value);
});

it('maps the value correctly', function () {
    $value = 40;
    $maybe = Maybe::of($value);
    $mappedMaybe = $maybe->map(function ($val) {
        return $val * 2;
    });
    expect($mappedMaybe->extract())->toBe($value * 2);
});

// Add more test cases as needed...

// restore_error_handler();
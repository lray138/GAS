<?php

use function lray138\GAS\Str\toInt;

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

it('should convert a numeric string to an integer', function () {
    $str = "123";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(123);
});

it('should convert a string with leading zeros to an integer', function () {
    $str = "007";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(7);
});

it('should convert a string with negative number to an integer', function () {
    $str = "-123";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(-123);
});

it('should convert a string with non-numeric characters at the end to an integer', function () {
    $str = "123abc";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(123);
});

it('should convert a string with non-numeric characters at the beginning to an integer', function () {
    $str = "abc123";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(0);
});

it('should convert an empty string to an integer', function () {
    $str = "";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(0);
});

it('should convert a string with only non-numeric characters to an integer', function () {
    $str = "abc";
    $result = toInt($str);
    expect($result)->toBeInt();
    expect($result)->toBe(0);
});

// restore_error_handler();
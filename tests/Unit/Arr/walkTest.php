<?php 

use function lray138\GAS\Arr\walk;

it('applies a function to each element of the array', function () {
    $array = [1, 2, 3];
    $expected = [1.0, 1.4142135623730951, 1.7320508075688772]; // Expected values after applying sqrt 
    
    $result = [];
    
    walk(function($x) use (&$result) {
    	$result[] = sqrt($x);
    }, $array);

    expect($result)->toBe($expected);
});

it('returns an empty array when given an empty array', function () {
    $array = [];
    
    walk(function($x) use (&$result) {
    	$result[] = strtoupper($x);
    }, $array);

    $result = [];

    expect($result)->toBe([]);
});
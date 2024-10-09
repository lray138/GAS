<?php 

use function lray138\GAS\Arr\random;

it('returns a valid key from a non-empty array', function () {
    $array = ['apple', 'banana', 'cherry', 'date'];
    $key = random($array);
    expect(in_array($key, array_keys($array)))->toBeTrue();
});

it('returns a valid string key from a non-empty array', function () {
    $array = [
    	'first' => 'apple', 
    	'second' => 'banana', 
    	'third' => 'cherry', 
    	'fourth' => 'date'
    ];

    $key = random($array);
    expect(in_array($key, array_keys($array)))->toBeTrue();
});

it('returns a valid key when only one element is present', function () {
    $array = ['only' => 'value'];
    $key = random($array);

    expect($key)->toBe('only'); // The only key should be returned
});

it('returns a valid key for a large array', function () {
    $array = range(1, 1000); // Create an array with 1000 elements
    $key = random($array);

    expect(in_array($key, array_keys($array)))->toBeTrue(); // Key should exist in the array
});
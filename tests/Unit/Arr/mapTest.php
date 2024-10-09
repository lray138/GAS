<?php 

use function lray138\GAS\Arr\map;

it('maps a function to each element of an indexed array', function () {
    // Test case 1: Square each element of an indexed array
    $array1 = [1, 2, 3, 4, 5];
    $result1 = map(function($x) { return $x * $x; }, $array1);
    expect($result1)->toBe([1, 4, 9, 16, 25]);
});

/* note here that the strtoupper will return it as a string '30' not the int */
it('maps a function to each element of an associative array', function () {
    // Test case 2: Uppercase each value in an associative array
    $array2 = ['name' => 'john', 'age' => 30, 'city' => 'new york'];
    $result2 = map('strtoupper', $array2);
    expect($result2)->toBe(['name' => 'JOHN', 'age' => '30', 'city' => 'NEW YORK']);
});

it('handles empty arrays correctly', function () {
    // Test case 3: Empty array
    $emptyArray = [];
    $result3 = map('strtoupper', $emptyArray);
    expect($result3)->toBe([]);
});

it('handles arrays with mixed types', function () {
    // Test case 4: Convert each value to string in a mixed type array
    $mixedArray = [1, 'two', 3.5, true];
    $result4 = map('strval', $mixedArray);
    expect($result4)->toBe(['1', 'two', '3.5', '1']);
});
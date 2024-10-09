<?php 

use function lray138\GAS\Arr\length;

it('returns 0 for an empty array', function () {
    $emptyArray = [];
    expect(length($emptyArray))->toBe(0);
});

it('returns the correct length for a non-empty indexed array', function () {
    $indexedArray = [10, 20, 30, 40, 50];
    expect(length($indexedArray))->toBe(5);
});

it('returns the correct length for an array with mixed types', function () {
    $mixedArray = ['apple', 'banana', 1, 2.5];
    expect(length($mixedArray))->toBe(4);
});

it('returns the correct length for an associative array', function () {
    $assocArray = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    expect(length($assocArray))->toBe(3);
});

it('returns the correct length for an array with null values', function () {
    $arrayWithNull = [1, null, 'apple', null, 5];
    expect(length($arrayWithNull))->toBe(5);
});
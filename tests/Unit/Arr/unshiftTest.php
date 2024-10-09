<?php 

use function lray138\GAS\Arr\unshift;

it('adds a single value to the beginning of a numeric indexed array', function () {
    $array = [2, 3, 4];
    $value = 1;
    $result = unshift($value, $array);
    expect($result)->toBe([1, 2, 3, 4]);
});

it('adds array of values to the beginning of a numeric indexed array', function () {
    $array = [4, 5];
    $values = [1, 2, 3];
    $result = unshift($values, $array);
    expect($result)->toBe([[1, 2, 3], 4, 5]);
});

it('adds a value to the beginning of an associative array', function () {
    $array = ['b' => 2, 'c' => 3];
    $value = 1;
    $result = unshift($value, $array);
    expect($result)->toBe([0 => 1, 'b' => 2, 'c' => 3]);
});

it('handles an empty array', function () {
    $array = [];
    $value = 'first';
    $result = unshift($value, $array);
    expect($result)->toBe(['first']);
});
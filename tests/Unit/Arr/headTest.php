<?php 

use function lray138\GAS\Arr\head;

it('returns the first element of a non-empty array', function () {
    $array = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

    $result = head($array);

    expect($result)->toBe('apple');
});

it('returns the first element of a numeric array', function () {
    $array = [1, 2, 3, 4, 5];

    $result = head($array);

    expect($result)->toBe(1);
});

it('returns null for an empty array', function () {
    $array = [];

    $result = head($array);

    expect($result)->toBeNull();
});

it('returns the first element of an associative array with mixed keys', function () {
    $array = [0 => 'zero', 'a' => 'apple', 1 => 'one'];

    $result = head($array);

    expect($result)->toBe('zero');
});

it('handles arrays with null values correctly', function () {
    $array = ['a' => null, 'b' => 'banana'];

    $result = head($array);

    expect($result)->toBeNull();
});
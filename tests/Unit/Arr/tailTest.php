<?php 

use function lray138\GAS\Arr\tail;


it('1) returns the tail of a numeric indexed array', function () {
    $array = [1, 2, 3, 4, 5];
    $result = tail($array);
    expect($result)->toBe([2, 3, 4, 5]);
});

it('2) returns an empty array when given an empty array', function () {
    $array = [];
    $result = tail($array);
    expect($result)->toBe([]);
});

it('3) returns an empty array when given an array with one element', function () {
    $array = ['single'];
    $result = tail($array);
    expect($result)->toBe([]);
});

it('4) returns the tail of an associative array', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $result = tail($array);
    expect($result)->toBe(['b' => 2, 'c' => 3]);
    expect(array_values($result))->toBe([2,3]);
});

it('5) preserves keys in an associative array when returning the tail', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $result = tail($array);
    expect(array_keys($result))->toBe(['b', 'c']);
});
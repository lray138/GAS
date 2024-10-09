<?php 

use function lray138\GAS\Arr\pop;

it('1) returns the last element of the array', function () {
    $array = [1, 2, 3, 4, 5];
    $result = pop($array);
    expect($result)->toBe([1,2,3,4]);
});

it('2) immutabule: does not alter original array', function () {
    $array = [1, 2, 3, 4, 5];
    pop($array);
    expect($array)->toBe([1, 2, 3, 4, 5]);
});

it('3) returns null for an empty array', function () {
    $array = [];
    $result = pop($array);
    expect($result)->toBe([]);
});

it('4) handles an array with a single element', function () {
    $array = [42];
    $result = pop($array);
    expect($result)->toBe([]);
    expect($array)->toBe([42]);
});

it('5) handles an array with mixed types', function () {
    $array = [1, 'two', 3.0, true];
    $result = pop($array);
    expect($result)->toBe([1, 'two', 3.0]);
});
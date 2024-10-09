<?php 

use function lray138\GAS\Arr\push;

it('pushes a value onto the end of the array', function () {
    $array = [1, 2, 3];
    $value = 4;
    $result = push($value, $array);
    expect($result)->toBe([1, 2, 3, 4]);
    expect($array)->toBe([1,2,3]);
});

it('handles an empty array', function () {
    $array = [];
    $value = 'new value';
    $result = push($value, $array);
    expect($result)->toBe(['new value']);
});

it('handles pushing multiple values onto the array', function () {
    $array = [1, 2];
    $value1 = 'three';
    $value2 = 4;
    $result = push($value1, $array);
    $result = push($value2, $result);
    expect($result)->toBe([1, 2, 'three', 4]);
});

it('handles pushing a null value onto the array', function () {
    $array = [1, 2, 3];
    $value = null;
    $result = push($value, $array);
    expect($result)->toBe([1, 2, 3, null]);
});

it('handles pushing into an array with mixed types', function () {
    $array = [1, 'two', true];
    $value = ['nested' => 'value'];
    $result = push($value, $array);
    expect($result)->toBe([1, 'two', true, ['nested' => 'value']]);
});
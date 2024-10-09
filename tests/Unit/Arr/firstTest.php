<?php 

use function lray138\GAS\Arr\first;

it('returns the first element that satisfies the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $result = first(function($value) {
        return $value > 3;
    }, $array);
    expect($result)->toBe(4);
});

it('returns null when no element satisfies the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $result = first(function($value) {
        return $value > 10;
    }, $array);
    expect($result)->toBeNull();
});

it('returns null when the array is empty', function () {
    $array = [];
    $result = first(function($value) {
        return $value > 3;
    }, $array);
    expect($result)->toBeNull();
});

it('returns the first element that satisfies the condition with key', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
    $result = first(function($value, $key) {
        return $key === 'c';
    }, $array);
    expect($result)->toBe(3);
});

it('returns the first matching element for complex conditions', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
        ['id' => 3, 'name' => 'Charlie'],
    ];
    $result = first(function($value) {
        return $value['name'] === 'Bob';
    }, $array);
    expect($result)->toBe(['id' => 2, 'name' => 'Bob']);
});
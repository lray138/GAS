<?php 

use function lray138\GAS\Arr\find;

it('finds the first element that satisfies the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $result = find(function($value) {
        return $value > 3;
    }, $array);

    expect($result)->toBe(4);
});

it('returns null when no element satisfies the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $result = find(function($value) {
        return $value > 10;
    }, $array);
    
    expect($result)->toBe(null);
});

it('returns null when the array is empty', function () {
    $array = [];
    $result = find(function($value) {
        return $value > 3;
    }, $array);

    expect($result)->toBe(null);
});

it('finds the first element that satisfies the condition with key', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
    $result = find(function($value, $key) {
        return $key === 'c';
    }, $array);

    expect($result)->toBe(3);
});

it('finds the first matching element for complex conditions', function () {
    $array = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
        ['id' => 3, 'name' => 'Charlie'],
    ];
    $result = find(function($value) {
        return $value['name'] === 'Bob';
    }, $array);

    expect($result)->toBe(['id' => 2, 'name' => 'Bob']);
});
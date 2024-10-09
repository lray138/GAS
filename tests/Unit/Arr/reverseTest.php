<?php 

use function lray138\GAS\Arr\reverse;

it('reverses a numeric indexed array', function () {
    $array = [1, 2, 3, 4, 5];
    $result = reverse($array);
    expect($result)->toBe([5, 4, 3, 2, 1]);
});

it('reverses an associative array', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $result = reverse($array);
    expect($result)->toBe(['c' => 3, 'b' => 2, 'a' => 1]);
});

it('handles an empty array', function () {
    $array = [];
    $result = reverse($array);
    expect($result)->toBe([]);
});

it('handles an array with one element', function () {
    $array = ['single'];
    $result = reverse($array);
    expect($result)->toBe(['single']);
});

it('preserves keys in numeric indexed arrays', function () {
    $array = [1 => 'one', 2 => 'two', 3 => 'three'];
    $result = reverse($array);
    expect($result)->toBe(['three', 'two', 'one']);
});
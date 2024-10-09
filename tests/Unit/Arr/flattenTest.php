<?php

use function lray138\GAS\Arr\flatten;

it('flattens a multidimensional array', function () {
    $array = [1, [2, 3], [[4], 5]];

    $result = flatten($array);

    expect($result)->toBe([1, 2, 3, 4, 5]);
});

it('flattens an already flat array', function () {
    $array = [1, 2, 3];

    $result = flatten($array);

    expect($result)->toBe([1, 2, 3]);
});

it('flattens an empty array', function () {
    $array = [];

    $result = flatten($array);

    expect($result)->toBe([]);
});

it('flattens a nested empty array', function () {
    $array = [[], [[]], [[[]]]];

    $result = flatten($array);

    expect($result)->toBe([]);
});

it('flattens a complex nested array', function () {
    $array = [1, [2, [3, [4]], 5], 6];

    $result = flatten($array);

    expect($result)->toBe([1, 2, 3, 4, 5, 6]);
});

it('preserves keys when flattening associative arrays', function () {
    $array = ['a' => 1, 'b' => ['c' => 2, 'd' => 3]];

    $result = flatten($array);

    expect($result)->toBe([1, 2, 3]);
});

it('handles arrays with mixed keys', function () {
    $array = [1, 'a' => [2, 'b' => [3, 4]], 5];

    $result = flatten($array);

    expect($result)->toBe([1, 2, 3, 4, 5]);
});

it('flattens arrays with non-numeric string keys correctly', function () {
    $array = ['a' => [1, 'b' => 2], 'c' => 3];

    $result = flatten($array);

    expect($result)->toBe([1, 2, 3]);
});

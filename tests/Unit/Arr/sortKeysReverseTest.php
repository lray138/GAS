<?php 

use function lray138\GAS\Arr\sortKeysReverse;

it('sorts an array by its keys in reverse alphabetical order', function () {
    $array = ['b' => 2, 'a' => 1, 'c' => 3];

    $result = sortKeysReverse($array);

    expect($result)->toEqual(['c' => 3, 'b' => 2, 'a' => 1]); // Keys sorted in reverse alphabetical order
});

it('sorts an array by its keys in reverse numeric order', function () {
    $array = [2 => 'b', 1 => 'a', 3 => 'c'];

    $result = sortKeysReverse($array);

    expect($result)->toEqual([3 => 'c', 2 => 'b', 1 => 'a']); // Numeric keys sorted in reverse numeric order
});

it('sorts an array by its keys using SORT_NUMERIC flag in reverse', function () {
    $array = ['10' => 'ten', '2' => 'two', '1' => 'one'];

    $result = sortKeysReverse($array, SORT_NUMERIC);

    expect($result)->toEqual(['10' => 'ten', '2' => 'two', '1' => 'one']); // Numeric keys sorted in reverse numeric order
});

it('sorts an array by its keys using SORT_STRING flag in reverse', function () {
    $array = ['10' => 'ten', '2' => 'two', '1' => 'one'];

    $result = sortKeysReverse($array, SORT_STRING);

    expect($result)->toEqual(['2' => 'two', '10' => 'ten', '1' => 'one']); // Keys sorted as strings in reverse order
});

it('returns the same array when keys are already sorted in reverse order', function () {
    $array = ['c' => 1, 'b' => 2, 'a' => 3];

    $result = sortKeysReverse($array);

    expect($result)->toEqual($array); // Array is already sorted in reverse alphabetical order
});

it('returns the same array for an empty array', function () {
    $array = [];

    $result = sortKeysReverse($array);

    expect($result)->toEqual($array); // Empty array remains unchanged
});

it('returns the same array for an array with a single key', function () {
    $array = ['a' => 1];

    $result = sortKeysReverse($array);

    expect($result)->toEqual($array); // Single key array remains unchanged
});
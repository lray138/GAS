<?php 

use function lray138\GAS\Arr\sortKeys;
use function lray138\GAS\Functional\flipCurryN;
use function lray138\GAS\Functional\flip;

it('sorts an array by its keys in ascending order', function () {
    $array = ['b' => 2, 'a' => 1, 'c' => 3];

    $result = sortKeys($array);

    expect($result)->toEqual(['a' => 1, 'b' => 2, 'c' => 3]); // Keys sorted alphabetically
});

it('sorts an array by its keys in ascending numeric order', function () {
    $array = [2 => 'b', 1 => 'a', 3 => 'c'];

    $result = sortKeys($array);

    expect($result)->toEqual([1 => 'a', 2 => 'b', 3 => 'c']); // Numeric keys sorted in ascending order
});

it('sorts an array by its keys using SORT_NUMERIC flag', function () {
    $array = ['10' => 'ten', '2' => 'two', '1' => 'one'];

    $result = sortKeys($array, SORT_NUMERIC);

    expect($result)->toEqual(['1' => 'one', '2' => 'two', '10' => 'ten']); // Numeric keys sorted numerically
});

it('sorts an array by its keys using SORT_STRING flag', function () {
    $array = ['10' => 'ten', '2' => 'two', '1' => 'one'];

    $result = sortKeys($array, SORT_STRING);
    $result_2 = flipCurryN(2, "\lray138\GAS\Arr\sortKeys")(SORT_STRING)($array);
    $result_3 = flip("\lray138\GAS\Arr\sortKeys")(SORT_STRING)($array);

    expect($result)->toEqual(['1' => 'one', '10' => 'ten', '2' => 'two']); // Keys sorted as strings
    expect($result_2)->toEqual(['1' => 'one', '10' => 'ten', '2' => 'two']); // Keys sorted as strings
    expect($result_3)->toEqual(['1' => 'one', '10' => 'ten', '2' => 'two']); // Keys sorted as strings
});

it('returns the same array when keys are already sorted', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];

    $result = sortKeys($array);

    expect($result)->toEqual($array); // Array is already sorted by keys
});

it('returns the same array for an empty array', function () {
    $array = [];

    $result = sortKeys($array);

    expect($result)->toEqual($array); // Empty array remains unchanged
});

it('returns the same array for an array with a single key', function () {
    $array = ['a' => 1];

    $result = sortKeys($array);

    expect($result)->toEqual($array); // Single key array remains unchanged
});
<?php 

use function lray138\GAS\Arr\sort;

it('sorts a numeric indexed array in ascending order', function () {
    $array = [3, 1, 2, 5, 4];
    $result = sort($array);
    expect($result)->toBe([1, 2, 3, 4, 5]);
});

// this is "R" sort
// it('sorts a numeric indexed array in descending order', function () {
//     $array = [3, 1, 2, 5, 4];
//     $result = sort($array, SORT_DESC);
//     expect($result)->toBe([5, 4, 3, 2, 1]);
// });

it('sorts an associative array by values in ascending order', function () {
    $array = ['b' => 3, 'a' => 1, 'c' => 2];
    $result = sort($array);
    expect($result)->toBe([1, 2, 3]);
});

it('sorts an associative array by keys in ascending order', function () {
    $array = ['b' => 3, 'a' => 1, 'c' => 2];
    ksort($array);
    expect($array)->toBe(['a' => 1, 'b' => 3, 'c' => 2]);
});

it('handles an empty array', function () {
    $array = [];
    $result = sort($array);
    expect($result)->toBe([]);
});

//

it('sorts an array with default SORT_REGULAR flag', function () {
    $array = [3, 2, 5, 1, 4];
    $expected = [1, 2, 3, 4, 5];

    $sortedArray = sort($array, SORT_REGULAR);

    expect($sortedArray)->toBe($expected);
});

it('sorts an array with SORT_NUMERIC flag', function () {
    $array = [3, 2, '5', 1, '4'];
    $expected = [1, 2, 3, '4', '5'];

    $sortedArray = sort($array, SORT_NUMERIC);

    expect($sortedArray)->toBe($expected);
});

it('sorts an array with SORT_STRING flag', function () {
    $array = [3, 2, 5, 1, 4];
    $expected = [1, 2, 3, 4, 5];

    $sortedArray = sort($array, SORT_STRING);

    expect($sortedArray)->toBe($expected);
});

// come back to this
// it('sorts an array with SORT_LOCALE_STRING flag', function () {
//     setlocale(LC_COLLATE, 'en_US.UTF-8');
//     $array = ['z', 'a', 'ä', 'å'];
//     $expected = ['a', 'ä', 'å', 'z'];

//     $sortedArray = sort($array, SORT_LOCALE_STRING);

//     expect($sortedArray)->toBe($expected);
// });

it('sorts an array with SORT_FLAG_CASE flag', function () {
    $array = ['a', 'B', 'C', 'b', 'A', 'c'];
    $expected = ['a', 'A', 'B', 'b', 'C', 'c'];

    $sortedArray = sort($array, SORT_STRING | SORT_FLAG_CASE);

    expect($sortedArray)->toBe($expected);
});
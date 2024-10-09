<?php 

use function lray138\GAS\Arr\slice;

it('slices an array from a given offset', function () {
    $array = [1, 2, 3, 4, 5];
    $offset = 2;

    $result = slice($offset, $array);

    expect($result)->toEqual([3, 4, 5]); // From offset 2 to the end
});

it('slices an array with an offset and length', function () {
    $array = [1, 2, 3, 4, 5];
    $offset = 1;
    $length = 3;

    $result = slice($offset, $length, $array);

    expect($result)->toEqual([2, 3, 4]); // From offset 1 with length 3
});

it('slices an array from an offset with no length', function () {
    $array = [10, 20, 30, 40, 50];
    $offset = 2;

    $result = slice($offset, $array);

    expect($result)->toEqual([30, 40, 50]); // From offset 2 to the end
});

// this is an incorrect test but I'm replacing "0" with null;
it('slices an array with offset and length of zero', function () {
    $array = [10, 20, 30, 40, 50];
    $offset = 2;
    $length = null;

    $result = slice($offset, $length, $array);
    $result_2 = slice($offset, $array);

    expect($result_2)->toEqual([30, 40, 50]);
    expect($result)->toEqual([30, 40, 50]); // From offset 2 to the end
});

it('returns an empty array when offset is beyond the array length', function () {
    $array = [10, 20, 30];
    $offset = 5;

    $result = slice($offset, $array);

    expect($result)->toEqual([]); // Offset beyond array length
});

it('returns an empty array when given an empty array', function () {
    $array = [];
    $offset = 1;

    $result = slice($offset, $array);

    expect($result)->toEqual([]); // Empty array
});
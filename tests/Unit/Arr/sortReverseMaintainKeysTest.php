<?php 

use function lray138\GAS\Arr\sortReverseMaintainKeys;

it('sorts array in reverse while maintaining keys with default flag', function () {
    $input = ['b' => 3, 'a' => 1, 'c' => 2];
    $expected = ['b' => 3, 'c' => 2, 'a' => 1];
    expect(sortReverseMaintainKeys($input))->toBe($expected);
});

it('sorts array in reverse while maintaining keys with SORT_NUMERIC flag', function () {
    $input = ['b' => '3', 'a' => '1', 'c' => '2'];
    $expected = ['b' => '3', 'c' => '2', 'a' => '1'];
    expect(sortReverseMaintainKeys($input, SORT_NUMERIC))->toBe($expected);
});

it('sorts array in reverse while maintaining keys with SORT_STRING flag', function () {
    $input = ['b' => 'banana', 'a' => 'apple', 'c' => 'cherry'];
    $expected = ['c' => 'cherry', 'b' => 'banana', 'a' => 'apple'];
    expect(sortReverseMaintainKeys($input, SORT_STRING))->toBe($expected);
});

it('sorts array in reverse while maintaining keys with SORT_NATURAL | SORT_FLAG_CASE flag', function () {
    $input = ['b' => 'Banana', 'a' => 'apple', 'c' => 'cherry'];
    $expected = ['c' => 'cherry', 'a' => 'apple', 'b' => 'Banana'];
    expect(sortReverseMaintainKeys($input, SORT_FLAG_CASE))->toBe($expected);
});
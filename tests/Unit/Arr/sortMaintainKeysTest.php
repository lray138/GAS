<?php 

use function lray138\GAS\Arr\sortMaintainKeys;

it('sorts array while maintaining keys with default flag', function () {
    $input = ['b' => 3, 'a' => 1, 'c' => 2];
    $expected = ['a' => 1, 'c' => 2, 'b' => 3];
    expect(sortMaintainKeys($input))->toBe($expected);
});

it('sorts array while maintaining keys with SORT_NUMERIC flag', function () {
    $input = ['b' => '3', 'a' => '1', 'c' => '2'];
    $expected = ['a' => '1', 'c' => '2', 'b' => '3'];
    expect(sortMaintainKeys($input, SORT_NUMERIC))->toBe($expected);
});

it('sorts array while maintaining keys with SORT_STRING flag', function () {
    $input = ['b' => 'banana', 'a' => 'apple', 'c' => 'cherry'];
    $expected = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
    expect(sortMaintainKeys($input, SORT_STRING))->toBe($expected);
});

it('sorts array while maintaining keys with SORT_FLAG_CASE flag', function () {
    $input = ['b' => 'Banana', 'a' => 'apple', 'c' => 'cherry'];
    $expected = ['a' => 'apple', 'b' => 'Banana', 'c' => 'cherry'];
    expect(sortMaintainKeys($input, SORT_FLAG_CASE | SORT_STRING))->toBe($expected);
});
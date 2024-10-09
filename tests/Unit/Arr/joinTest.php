<?php 

use function lray138\GAS\Arr\join;

it('1) joins array elements with comma separator', function () {
    $array = ['apple', 'banana', 'cherry'];
    $separator = ', ';
    $expectedResult = 'apple, banana, cherry';
    expect(join($separator, $array))->toBe($expectedResult);
});

it('2) joins array elements with custom separator', function () {
    $array = ['Alice', 'Bob', 'Charlie'];
    $separator = ' - ';
    $expectedResult = 'Alice - Bob - Charlie';
    expect(join($separator, $array))->toBe($expectedResult);
});

it('3) returns empty string for null array', function () {
    $array = [];
    $separator = ', ';
    $expectedResult = '';
    expect(join($separator, $array))->toBe($expectedResult);
});

it('4) joins single-element array without separator', function () {
    $array = ['Hello'];
    $separator = ', ';
    $expectedResult = 'Hello';
    expect(join($separator, $array))->toBe($expectedResult);
});

it('5) joins empty array without separator', function () {
    $array = [];
    $separator = ', ';
    $expectedResult = '';
    expect(join($separator, $array))->toBe($expectedResult);
});

it('6) joins with empty string when only array is provided', function () {
    $array = ["a", "b", "c"];
    $expectedResult = 'abc';
    expect(join($array))->toBe($expectedResult);
});
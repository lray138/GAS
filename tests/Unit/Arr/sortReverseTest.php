<?php 

use function lray138\GAS\Arr\sortReverse;

it('sorts array in reverse with default flag', function () {
    $input = [3, 1, 2];
    $expected = [3, 2, 1];
    expect(sortReverse($input))->toBe($expected);
});

it('sorts array in reverse with SORT_NUMERIC flag', function () {
    $input = ['3', '1', '2'];
    $expected = ['3', '2', '1'];
    expect(sortReverse($input, SORT_NUMERIC))->toBe($expected);
});

it('sorts array in reverse with SORT_STRING flag', function () {
    $input = ['banana', 'apple', 'cherry'];
    $expected = ['cherry', 'banana', 'apple'];
    expect(sortReverse($input, SORT_STRING))->toBe($expected);
});

it('sorts also array in reverse with SORT_STRING flag', function () {
    $input = ['Banana', 'apple', 'cherry'];
    $expected = ['cherry', 'apple', 'Banana'];
    expect(sortReverse($input, SORT_STRING))->toBe($expected);
});

it('sorts array in reverse with SORT_FLAG_CASE flag', function () {
    $input = ['Banana', 'apple', 'cherry'];
    $expected = ['cherry', 'Banana', 'apple'];
    expect(sortReverse($input, SORT_FLAG_CASE | SORT_STRING))->toBe($expected);
});
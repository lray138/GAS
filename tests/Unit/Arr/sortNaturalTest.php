<?php 

use function lray138\GAS\Arr\sortNatural;

it('sorts an array of strings in natural order', function () {
    $array = ['item10', 'item2', 'item1'];
    $result = sortNatural($array);
   	expect(array_values($result))->toEqual(['item1', 'item2', 'item10']); // Natural order sorting
});

it('sorts an array with mixed-case strings in natural order', function () {
    $array = ['item10', 'Item2', 'item1'];
    $result = sortNatural($array);
    expect(array_values($result))->toEqual(['Item2', 'item1', 'item10']); // Natural order sorting, case-insensitive
});

it('sorts an array with numeric values and alphabetic characters', function () {
    $array = ['a10b', 'a2c', 'a1d'];
    $result = sortNatural($array);
    expect(array_values($result))->toEqual(['a1d', 'a2c', 'a10b']); // Natural order sorting
});

it('sorts an array with purely numeric strings in natural order', function () {
    $array = ['10', '2', '1'];
    $result = sortNatural($array);
    expect(array_values($result))->toBe(['1', '2', '10']); // Natural order sorting for numeric strings
});

it('sorts an array with only numeric parts but mixed types', function () {
    $array = ['10abc', '2abc', '1abc'];
    $result = sortNatural($array);
    expect(array_values($result))->toEqual(['1abc', '2abc', '10abc']); // Natural order sorting for strings with numeric prefixes
});

it('returns the same array when already sorted in natural order', function () {
    $array = ['a1', 'a2', 'a10'];
    $result = sortNatural($array);
    expect(array_values($result))->toEqual($array); // Array is already sorted in natural order
});

it('returns the same array for an empty array', function () {
    $array = [];
    $result = sortNatural($array);
    expect(array_values($result))->toEqual($array); // Empty array remains unchanged
});

it('returns the same array for an array with a single element', function () {
    $array = ['a'];
    $result = sortNatural($array);
    expect(array_values($result))->toEqual($array); // Single element array remains unchanged
});
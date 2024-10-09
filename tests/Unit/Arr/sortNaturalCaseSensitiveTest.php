<?php 

use function lray138\GAS\Arr\sortNaturalCaseSensitive;

it('sorts an array of strings in natural order, case-insensitive', function () {
    $array = ['item10', 'Item2', 'item1'];

    $result = sortNaturalCaseSensitive($array);

    expect(array_values($result))->toEqual(['item1', 'Item2', 'item10']); // Natural order sorting, case-insensitive
});

it('sorts an array of mixed-case strings in natural order, case-insensitive', function () {
    $array = ['a10', 'A2', 'a1'];

    $result = sortNaturalCaseSensitive($array);

    expect(array_values($result))->toEqual(['a1', 'A2', 'a10']); // Natural order sorting with case insensitivity
});

it('sorts an array with numeric values and alphabetic characters in natural order, case-insensitive', function () {
    $array = ['item10b', 'item2a', 'ITEM1c'];

    $result = sortNaturalCaseSensitive($array);

    expect(array_values($result))->toEqual(['ITEM1c', 'item2a', 'item10b']); // Natural order sorting with case insensitivity
});

it('sorts an array with purely numeric strings in natural order', function () {
    $array = ['10', '2', '1'];

    $result = sortNaturalCaseSensitive($array);

    expect(array_values($result))->toEqual(['1', '2', '10']); // Natural order sorting for numeric strings
});

it('sorts an array with mixed numeric and alphabetic strings in natural order, case-insensitive', function () {
    $array = ['10abc', '2abc', '1ABC'];

    $result = sortNaturalCaseSensitive($array);

    expect(array_values($result))->toEqual(['1ABC', '2abc', '10abc']); // Natural order sorting with case insensitivity
});

it('returns the same array when already sorted in natural order, case-insensitive', function () {
    $array = ['a1', 'a2', 'a10'];
    $result = sortNaturalCaseSensitive($array);
    expect(array_values($result))->toEqual($array); // Array should be sorted in natural order
});

it('returns the same array for an empty array', function () {
    $array = [];
    $result = sortNaturalCaseSensitive($array);
    expect(array_values($result))->toEqual($array); // Empty array remains unchanged
});

it('returns the same array for an array with a single element', function () {
    $array = ['a'];
    $result = sortNaturalCaseSensitive($array);
    expect(array_values($result))->toEqual($array); // Single element array remains unchanged
});
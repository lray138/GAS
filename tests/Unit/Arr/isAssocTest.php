<?php 

use function lray138\GAS\Arr\isAssoc;

it('returns true for an associative array', function () {
    $associativeArray = ['a' => 1, 'b' => 2, 'c' => 3];
    expect(isAssoc($associativeArray))->toBeTrue();
});

it('returns false for an indexed array', function () {
    $indexedArray = [1, 2, 3];
    expect(isAssoc($indexedArray))->toBeFalse();
});

it('returns false for an empty array', function () {
    $emptyArray = [];
    expect(isAssoc($emptyArray))->toBeFalse();
});

it('returns true for an array with mixed keys', function () {
    $mixedKeysArray = ['a' => 1, 1 => 'b', 'c' => 3];
    expect(isAssoc($mixedKeysArray))->toBeTrue();
});

it('returns false for an array with only numeric keys', function () {
    $numericKeysArray = [0 => 'a', 1 => 'b', 2 => 'c'];
    expect(isAssoc($numericKeysArray))->toBeFalse();
});
<?php 

use function lray138\GAS\Arr\isAssociative;

it('returns true for an associative array', function () {
    $associativeArray = ['a' => 1, 'b' => 2, 'c' => 3];
    expect(isAssociative($associativeArray))->toBeTrue();
});

it('returns false for an indexed array', function () {
    $indexedArray = [1, 2, 3];
    expect(isAssociative($indexedArray))->toBeFalse();
});

it('returns false for an empty array', function () {
    $emptyArray = [];
    expect(isAssociative($emptyArray))->toBeFalse();
});

it('returns true for an array with mixed keys', function () {
    $mixedKeysArray = ['a' => 1, 1 => 'b', 'c' => 3];
    expect(isAssociative($mixedKeysArray))->toBeTrue();
});

it('returns false for an array with only numeric keys', function () {
    $numericKeysArray = [0 => 'a', 1 => 'b', 2 => 'c'];
    expect(isAssociative($numericKeysArray))->toBeFalse();
});
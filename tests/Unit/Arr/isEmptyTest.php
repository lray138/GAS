<?php 

use function lray138\GAS\Arr\isEmpty;

it('returns true for an empty array', function () {
    $emptyArray = [];
    expect(isEmpty($emptyArray))->toBeTrue();
});

it('returns false for a non-empty array', function () {
    $nonEmptyArray = [1, 2, 3];
    expect(isEmpty($nonEmptyArray))->toBeFalse();
});

it('returns true for an array with only null values', function () {
    $nullArray = [null, null, null];
    expect(isEmpty($nullArray))->toBeFalse();
});

it('returns false for an associative array', function () {
    $associativeArray = ['key' => 'value'];
    expect(isEmpty($associativeArray))->toBeFalse();
});

it('returns false for an array with numeric keys', function () {
    $numericKeysArray = [0 => 'a', 1 => 'b'];
    expect(isEmpty($numericKeysArray))->toBeFalse();
});
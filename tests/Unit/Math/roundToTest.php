<?php

use function lray138\GAS\Math\roundTo;

test('roundTo function returns the correct rounded value for positive numbers', function () {
    expect(roundTo(2, 3.14159))->toBe(3.14);
    expect(roundTo(3, 1.987654))->toBe(1.988);
    expect(roundTo(0, 5.5))->toBe(6.0);
    expect(roundTo(1, 1.05))->toBe(1.1);
});

test('roundTo function returns the correct rounded value for negative numbers', function () {
    expect(roundTo(2, -3.14159))->toBe(-3.14);
    expect(roundTo(3, -1.987654))->toBe(-1.988);
    expect(roundTo(0, -5.5))->toBe(-6.0);
    expect(roundTo(1, -1.05))->toBe(-1.1);
});

test('roundTo function handles zero decimals', function () {
    expect(roundTo(0, 3.14159))->toBe(3.0);
    expect(roundTo(0, -3.14159))->toBe(-3.0);
});

test('roundTo function works with curried calls', function () {
    $roundToTwoDecimals = roundTo(2);
    expect($roundToTwoDecimals(3.14159))->toBe(3.14);
    expect($roundToTwoDecimals(-3.14159))->toBe(-3.14);

    $roundToZeroDecimals = roundTo(0);
    expect($roundToZeroDecimals(3.14159))->toBe(3.0);
    expect($roundToZeroDecimals(-3.14159))->toBe(-3.0);
});
<?php 

// $HOME/sites/GAS/src/Math/absolute;
use function lray138\GAS\Math\absolute;

test('absolute function returns correct absolute value for positive numbers', function () {
    // fixing a test fail, noting that at one point we were forcing everything to be float.
    expect(absolute(5))->toBe(5);
    expect(absolute(10.5))->toBe(10.5);
});

test('absolute function returns correct absolute value for negative numbers', function () {
    expect(absolute(-5))->toBe(5);
    expect(absolute(-10.5))->toBe(10.5);
});

test('absolute function returns 0.0 for zero', function () {
    expect(absolute(0))->toBe(0);
});

test('absolute function returns float for float input', function () {
    expect(absolute(5.25))->toBe(5.25);
    expect(absolute(-3.75))->toBe(3.75);
});

test('absolute function returns float for scientific notation input', function () {
    expect(absolute(1.2e3))->toBe(1200.0);
    expect(absolute(-1.2e-3))->toBe(0.0012);
});
<?php

use function lray138\GAS\Math\sine;

test('sine function returns the correct sine value for positive numbers', function () {
    expect(sine(0))->toBe(0.0);
    expect(sine(M_PI / 2))->toBeBetween(0.9999999999, 1.0000000001); // sin(π/2) is 1
    expect(sine(M_PI))->toBeBetween(-0.0000000001, 0.0000000001); // sin(π) is 0
});

test('sine function returns the correct sine value for negative numbers', function () {
    expect(sine(-M_PI / 2))->toBeBetween(-1.0000000001, -0.9999999999); // sin(-π/2) is -1
    expect(sine(-M_PI))->toBeBetween(-0.0000000001, 0.0000000001); // sin(-π) is 0
});

test('sine function returns the correct sine value for common angles', function () {
    expect(sine(M_PI / 4))->toBeBetween(0.7071067811, 0.7071067813); // sin(π/4) is √2/2 ≈ 0.7071067811865476
    expect(sine(3 * M_PI / 4))->toBeBetween(0.7071067811, 0.7071067813); // sin(3π/4) is √2/2 ≈ 0.7071067811865476
});

/**
 * @todo check this out
 */ 
// test('sine function returns the correct sine value for multiples of π', function () {
//     expect(sine(2 * M_PI))->toBe(0.0); // sin(2π) is 0
//     expect(sine(-2 * M_PI))->toBe(0.0); // sin(-2π) is 0
// });

test('sine function returns correct values for float numbers', function () {
    expect(sine(0.5))->toBeBetween(0.4794255386, 0.4794255388); // sin(0.5) ≈ 0.479425538604203
    expect(sine(-0.5))->toBeBetween(-0.4794255388, -0.4794255386); // sin(-0.5) ≈ -0.479425538604203
});
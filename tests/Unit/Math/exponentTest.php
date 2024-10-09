<?php

use function lray138\GAS\Math\exponent;

test('exponent function returns the correct exponential value for positive numbers', function () {
    expect(exponent(1))->toBeBetween(2.7182818284, 2.7182818286); // e^1 = e ≈ 2.718281828459045
    expect(exponent(2))->toBeBetween(7.3890560989, 7.3890560991); // e^2 ≈ 7.38905609893065
});

test('exponent function returns the correct exponential value for negative numbers', function () {
    expect(exponent(-1))->toBeBetween(0.3678794411, 0.3678794413); // e^-1 ≈ 0.36787944117144233
    expect(exponent(-2))->toBeBetween(0.1353352832, 0.1353352834); // e^-2 ≈ 0.1353352832366127
});

test('exponent function returns 1 for an input of 0', function () {
    expect(exponent(0))->toBe(1.0); // e^0 = 1
});

test('exponent function returns the correct exponential value for fractional numbers', function () {
    expect(exponent(0.5))->toBeBetween(1.6487212706, 1.6487212708); // e^0.5 ≈ 1.6487212707001282
    expect(exponent(-0.5))->toBeBetween(0.6065306596, 0.6065306598); // e^-0.5 ≈ 0.6065306597126334
});

test('exponent function returns the correct exponential value for large numbers', function () {
    expect(exponent(10))->toBeBetween(22026.46579, 22026.46581); // e^10 ≈ 22026.465794806718
    expect(exponent(-10))->toBeBetween(0.0000453999, 0.0000454001); // e^-10 ≈ 0.00004539992976248485
});
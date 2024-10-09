<?php 

use function lray138\GAS\Math\limit;

test('limit function returns the number itself when within the range', function () {
    expect(limit(1, 10, 5))->toBe(5);
    expect(limit(0, 10, 7.5))->toBe(7.5);
});

test('limit function returns the min value when the number is less than the min', function () {
    expect(limit(1, 10, 0))->toBe(1);
    expect(limit(-3, 3, -5))->toBe(-3);
});

test('limit function returns the max value when the number is greater than the max', function () {
    expect(limit(1, 10, 15))->toBe(10);
    expect(limit(0, 4, 5))->toBe(4);
});

test('limit function works with curried calls', function () {
    $limitRange = limit(1)(10)(5);
    expect($limitRange)->toBe(5);

    $limitMin = limit(1)(10)(0);
    expect($limitMin)->toBe(1);

    $limitMax = limit(1)(10)(15);
    expect($limitMax)->toBe(10);
});

test('limit function works with negative numbers', function () {
    expect(limit(-10, 0, -5))->toBe(-5);
    expect(limit(-10, 0, -15))->toBe(-10);
    expect(limit(-10, 0, 5))->toBe(0);
});
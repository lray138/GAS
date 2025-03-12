<?php 

use function lray138\GAS\Math\ceiling;

test('ceiling function returns the correct ceiling value for positive integers', function () {
    expect(ceiling(5))->toEqual(5); // ceil(5) is 5
    expect(ceiling(5.1))->toEqual(6); // ceil(5.1) is 6
    expect(ceiling(5.9))->toEqual(6); // ceil(5.9) is 6
    expect(ceiling(6.0))->toEqual(6); // ceil(6.0) is 6
});

test('ceiling function returns the correct ceiling value for negative integers', function () {
    expect(ceiling(-5))->toEqual(-5); // ceil(-5) is -5
    expect(ceiling(-5.1))->toEqual(-5); // ceil(-5.1) is -5
    expect(ceiling(-5.9))->toEqual(-5); // ceil(-5.9) is -5
    expect(ceiling(-6.0))->toEqual(-6); // ceil(-6.0) is -6
});

test('ceiling function returns the correct ceiling value for zero', function () {
    expect(ceiling(0))->toEqual(0); // ceil(0) is 0
});

test('ceiling function returns the correct ceiling value for large numbers', function () {
    expect(ceiling(1000000))->toEqual(1000000); // ceil(1000000) is 1000000
    expect(ceiling(1000000.1))->toEqual(1000001); // ceil(1000000.1) is 1000001
});

test('ceiling function returns the correct ceiling value for small fractional numbers', function () {
    expect(ceiling(0.1))->toEqual(1); // ceil(0.1) is 1
    expect(ceiling(0.9))->toEqual(1); // ceil(0.9) is 1
    expect(ceiling(-0.1))->toEqual(0); // ceil(-0.1) is 0
    expect(ceiling(-0.9))->toEqual(0); // ceil(-0.9) is 0
});
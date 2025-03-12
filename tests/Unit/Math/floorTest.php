<?php 

// $HOME/sites/GAS/src/Math/floor.php
use function lray138\GAS\Math\floor;

// good example of type wher floor is always returning a float

test('floor function returns the correct floor value for positive integers', function () {
    expect(floor(5))->toEqual(5); // floor(5) is 5
    expect(floor(5.1))->toEqual(5); // floor(5.1) is 5
    expect(floor(5.9))->toEqual(5); // floor(5.9) is 5
    expect(floor(6.0))->toEqual(6); // floor(6.0) is 6
});

test('floor function returns the correct floor value for negative integers', function () {
    expect(floor(-5))->toEqual(-5); // floor(-5) is -5
    expect(floor(-5.1))->toEqual(-6); // floor(-5.1) is -6
    expect(floor(-5.9))->toEqual(-6); // floor(-5.9) is -6
    expect(floor(-6.0))->toEqual(-6); // floor(-6.0) is -6
});

test('floor function returns the correct floor value for zero', function () {
    expect(floor(0))->toEqual(0); // floor(0) is 0
});

test('floor function returns the correct floor value for large numbers', function () {
    expect(floor(1000000))->toEqual(1000000); // floor(1000000) is 1000000
    expect(floor(1000000.1))->toEqual(1000000); // floor(1000000.1) is 1000000
});

test('floor function returns the correct floor value for small fractional numbers', function () {
    expect(floor(0.1))->toEqual(0); // floor(0.1) is 0
    expect(floor(0.9))->toEqual(0); // floor(0.9) is 0
    expect(floor(-0.1))->toEqual(-1); // floor(-0.1) is -1
    expect(floor(-0.9))->toEqual(-1); // floor(-0.9) is -1
});
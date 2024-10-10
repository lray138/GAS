<?php 

use function lray138\GAS\Math\add;

/**
 * Note: there is the floating point issue on adding floats that is normal
 */

it('adds two numbers correctly', function () {
    expect(add(1, 2))->toBe(3.0);
    expect(add(10, 15))->toBe(25.0);
});

it('adds float numbers correctly', function () {
    expect(add(1.5, 2.5))->toBe(4.0);
    expect(round(add(0.1, 0.2), 1))->toBe(0.3);
    //expect((float) number_format(add(0.1, 0.2), 1))->toBe(0.3);
});

it('supports curried addition', function () {
    $add5 = add(5);
    expect($add5(10))->toBe(15.0);
    expect($add5(20))->toBe(25.0);
});

it('handles negative numbers correctly', function () {
    expect(add(-1, -2))->toBe(-3.0);
    expect(add(-1, 2))->toBe(1.0);
});

test('test addition with zero', function () {
    expect(add(0, 0))->toBe(0.0);
    expect(add(5, 0))->toBe(5.0);
    expect(add(0, 5))->toBe(5.0);
});
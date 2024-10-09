<?php 

use function lray138\GAS\Math\arcCosine;

test('arcCosine function returns correct arccosine for valid input', function () {
    expect(arcCosine(1))->toBe(0.0); // acos(1) is 0
    expect(round(arcCosine(0), 13))->toBe(1.5707963267949); // acos(0) is pi/2 (approximately 1.5707963267949)
    expect(round(arcCosine(-1), 13))->toBe(3.1415926535898); // acos(-1) is pi (approximately 3.1415926535898)
    expect(round(arcCosine(0.5), 13))->toBe(1.0471975511966); // acos(0.5) is pi/3 (approximately 1.0471975511966)

    // above was originally ->toBeCloseTo(1.0471975511966, 10)
});

// test('arcCosine function throws an error for invalid input', function () {
//     expect(function () {
//         arcCosine(1.5); // acos() is not defined for numbers outside the range [-1, 1]
//     })->toThrow(ArgumentCountError::class);
// });
<?php 

use function lray138\GAS\Functional\compose;

it('composes functions correctly', function () {
    $add1 = function ($x) {
        return $x + 1;
    };

    $double = function ($x) {
        return $x * 2;
    };

    $square = function ($x) {
        return $x * $x;
    };

    $composed = compose($square, $double, $add1);

    $composed2 = compose($add1, $double, $square);

    expect($composed(2))->toBe(36); // (2 + 1) * 2 => 6 => 6 * 6 => 36
    expect($composed(3))->toBe(64); // (3 + 1) * 2 => 8 => 8 * 8 => 64
    
    expect($composed2(2))->toBe(9); // 2^2 = 4, 4 * 2 = 8, 8 + 1 = 9
    expect($composed2(3))->toBe(19); // 3^2 = 9, 9 * 2 = 18, 18 + 1 = 19
});
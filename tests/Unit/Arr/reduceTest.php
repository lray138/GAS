<?php 

use function lray138\GAS\Arr\reduce;

it('reduces an array to a single value using a callable', function () {
    $array = [1, 2, 3, 4];
    $callable = function ($carry, $item) {
        return $carry + $item;
    };
    $initial = 0;

    $result = reduce($callable, $initial, $array);

    expect($result)->toBe(10); // 1 + 2 + 3 + 4 = 10
});

it('reduces an array with a different initial value', function () {
    $array = [1, 2, 3, 4];
    $callable = function ($carry, $item) {
        return $carry * $item;
    };
    $initial = 1;

    $result = reduce($callable, $initial, $array);

    expect($result)->toBe(24); // 1 * 1 * 2 * 3 * 4 = 24
});

it('reduces an array with no initial value', function () {
    $array = [2, 4, 6];
    $callable = function ($carry, $item) {
        return $carry + $item;
    };

    $result = reduce($callable, null, $array);

    expect($result)->toBe(12); // 2 + 4 + 6 = 12
});

it('reduces an empty array', function () {
    $array = [];
    $callable = function ($carry, $item) {
        return $carry + $item;
    };
    $initial = 0;

    $result = reduce($callable, $initial, $array);

    expect($result)->toBe(0); // Initial value is returned
});

it('works with associative arrays', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $callable = function ($carry, $item) {
        return $carry + $item;
    };
    $initial = 10;

    $result = reduce($callable, $initial, $array);

    expect($result)->toBe(16); // 10 + 1 + 2 + 3 = 16
});

it('returns initial value if array is empty and no callable is provided', function () {
    $array = [];
    $initial = 'initial';

    $result = reduce(fn($carry, $item) => $carry, $initial, $array);

    expect($result)->toBe($initial); // Initial value is returned
});

it('it curries correctlly', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $callable = function ($carry, $item) {
        return $carry + $item;
    };
    $initial = 10;

    $reduce = reduce(fn($carry, $item) => $carry);
    $reduce = $reduce($initial);
    $result = $reduce($array);

    expect($result)->toBe($initial); // Initial value is returned
});
<?php 

use function lray138\GAS\Arr\pluckOrNull;

it('returns the null for a default value', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 3;

    $result = pluckOrNull($key, $array);

    expect($result)->toBe(null);
});

it('returns the null for a default value (curried)', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 3;

    $pluckOrNull = pluckOrNull($key);
    $result = $pluckOrNull($array);

    expect($result)->toBe(null);
});

it('returns the correct value when key is present', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 3;

    $pluckOrNull = pluckOrNull(0);
    $result = $pluckOrNull($array);

    expect($result)->toBe('first');
});

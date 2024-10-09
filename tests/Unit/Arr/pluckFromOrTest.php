<?php 

use function lray138\GAS\Arr\pluckFromOr;

it('returns the value for an existing key', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'name';
    $default = 'Unknown';

    $result = pluckFromOr($array, $default, $key);

    expect($result)->toBe('John');
});

it('returns the default value for a non-existing key', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'gender';
    $default = 'Unknown';

    $result = pluckFromOr($array, $default, $key);

    expect($result)->toBe('Unknown');
});

it('works with numeric keys', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 1;
    $default = 'default';

    $result = pluckFromOr($array, $default, $key);

    expect($result)->toBe('second');
});

it('returns the default value for an out-of-bounds key', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 3;
    $default = 'default';

    $result = pluckFromOr($array, $default, $key);

    expect($result)->toBe('default');
});
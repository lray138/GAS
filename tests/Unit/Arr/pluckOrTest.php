<?php 

use function lray138\GAS\Arr\pluckOr;

it('returns the value for an existing key', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'name';
    $default = 'Unknown';

    $result = pluckOr($key, $default, $array);

    expect($result)->toBe('John');
});

it('returns the default value for a non-existing key', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'gender';
    $default = 'Unknown';

    $result = pluckOr($key, $default, $array);

    expect($result)->toBe('Unknown');
});

it('executes and returns the result of the callable for a non-existing key', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'gender';
    $default = fn($arr) => 'Calculated Value';

    $result = pluckOr($key, $default, $array);

    expect($result)->toBe('Calculated Value');
});

it('works with numeric keys', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 1;
    $default = 'default';

    $result = pluckOr($key, $default, $array);

    expect($result)->toBe('second');
});

it('returns the default value for an out-of-bounds key', function () {
    $array = [0 => 'first', 1 => 'second', 2 => 'third'];
    $key = 3;
    $default = 'default';

    $result = pluckOr($key, $default, $array);

    expect($result)->toBe('default');
});
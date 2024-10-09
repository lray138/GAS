<?php 

use function lray138\GAS\Arr\pick;

it('picks a single existing key from the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $key = 'name';
    $result = pick($key, $array);
    expect($result)->toBe(['name' => 'John']);
});

it('picks multiple existing keys from the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $keys = ['name', 'city'];
    $result = pick($keys, $array);
    expect($result)->toBe(['name' => 'John', 'city' => 'New York']);
});

it('returns an empty array when none of the keys exist', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $keys = ['country', 'state'];
    $result = pick($keys, $array);
    expect($result)->toBe([]);
});

it('handles picking a mix of existing and non-existing keys', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $keys = ['name', 'country'];
    $result = pick($keys, $array);
    expect($result)->toBe(['name' => 'John']);
});

it('handles an empty array as input', function () {
    $array = [];
    $keys = ['name', 'age'];
    $result = pick($keys, $array);
    expect($result)->toBe([]);
});

it('handles an empty keys array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $keys = [];
    $result = pick($keys, $array);
    expect($result)->toBe([]);
});
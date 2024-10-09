<?php 

use function lray138\GAS\Arr\pluckFrom;

it('returns the value of an existing key in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $key = 'name';
    $result = pluckFrom($array, $key);
    expect($result)->toBe('John');
});

it('returns null for a non-existing key in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $key = 'country';
    $result = pluckFrom($array, $key);
    expect($result)->toBeNull();
});

it('returns null for an empty array', function () {
    $array = [];
    $key = 'name';
    $result = pluckFrom($array, $key);
    expect($result)->toBeNull();
});

it('handles mixed types in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'is_member' => true];
    $key1 = 'age';
    $key2 = 'is_member';
    $result1 = pluckFrom($array, $key1);
    $result2 = pluckFrom($array, $key2);
    expect($result1)->toBe(30);
    expect($result2)->toBeTrue();
});

it('returns the value of a key with a null value', function () {
    $array = ['name' => 'John', 'age' => null];
    $key = 'age';
    $result = pluckFrom($array, $key);
    expect($result)->toBeNull();
});

it('handles numeric keys in the array', function () {
    $array = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
    $key = 20;
    $result = pluckFrom($array, $key);
    expect($result)->toBe('twenty');
});
<?php 

use function lray138\GAS\Arr\pluck;

it('1) returns the value of an existing key in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $key = 'name';
    $result = pluck($key, $array);
    expect($result)->toBe('John');
});

it('2) returns null for a non-existing key in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    $key = 'country';
    $result = pluck($key, $array);
    expect($result)->toBeNull();
});

it('3) returns null for an empty array', function () {
    $array = [];
    $key = 'name';
    $result = pluck($key, $array);
    expect($result)->toBeNull();
});

it('4) handles mixed types in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'is_member' => true];
    $key1 = 'age';
    $key2 = 'is_member';
    $result1 = pluck($key1, $array);
    $result2 = pluck($key2, $array);
    expect($result1)->toBe(30);
    expect($result2)->toBeTrue();
});

it('5) returns the value of a key with a null value', function () {
    $array = ['name' => 'John', 'age' => null];
    $key = 'age';
    $result = pluck($key, $array);
    expect($result)->toBeNull();
});

it('6) handles numeric keys in the array', function () {
    $array = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
    $key = 20;
    $result = pluck($key, $array);
    expect($result)->toBe('twenty');
});


it('7) returns numeric keys correctly', function() {
	$array = [0,1,2,3,4,5];
	expect(pluck(0, $array))->toBe(0);
	expect(pluck(3, $array))->toBe(3);
});
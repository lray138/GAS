<?php 

use function lray138\GAS\Arr\pushKeyVal;

it('1) adds a new key-value pair to the array', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'city';
    $value = 'New York';
    $result = pushKeyVal($key, $value, $array);
    expect($result)->toBe(['name' => 'John', 'age' => 30, 'city' => 'New York']);
});

it('2) updates an existing key with a new value in the array', function () {
    $array = ['name' => 'John', 'age' => 30, 'city' => 'Boston'];
    $key = 'city';
    $value = 'New York';
    $result = pushKeyVal($key, $value, $array);
    expect($result)->toBe(['name' => 'John', 'age' => 30, 'city' => 'New York']);
});

it('3) handles adding a numeric key-value pair to the array', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 0;
    $value = 'First item';
    $result = pushKeyVal($key, $value, $array);
    expect($result)->toBe(['name' => 'John', 'age' => 30, 0 => 'First item']);
});

it('4) handles adding a null value for a key in the array', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = 'city';
    $value = null;
    $result = pushKeyVal($key, $value, $array);
    expect($result)->toBe(['name' => 'John', 'age' => 30, 'city' => null]);
});

it('5) returns the same array when key is empty', function () {
    $array = ['name' => 'John', 'age' => 30];
    $key = '';
    $value = 'Empty key test';
    $result = pushKeyVal($key, $value, $array);
    expect($result)->toBe(['name' => 'John', 'age' => 30]);
});

it('6) pushes 0 => 0 to the end since it\'s associative' , function () {
    $array = [1];
    $key = 0;
    $value = 0;
    $result = pushKeyVal($key, $value, $array);
    expect($result)->toBe([1, 0 => 0]);
});
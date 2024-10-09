<?php 

use function lray138\GAS\Arr\getOrElse;

it('returns the value if key exists and not null', function () {
    $array = ['name' => 'Alice', 'age' => 25];
    $result = getOrElse('name', 'Unknown', $array);
    expect($result)->toBe('Alice');
});

it('returns the default value if key does not exist', function () {
    $array = ['name' => 'Alice', 'age' => 25];
    $result = getOrElse('city', 'Unknown', $array);
    expect($result)->toBe('Unknown');
});

it('returns the default value if key exists but value is null', function () {
    $array = ['name' => 'Alice', 'age' => null];
    $result = getOrElse('age', 30, $array);
    expect($result)->toBe(30);
});

it('handles empty arrays by returning default value', function () {
    $array = [];
    $result = getOrElse('name', 'Unknown', $array);
    expect($result)->toBe('Unknown');
});

it('handles null values in array by returning default value', function () {
    $array = ['name' => null];
    $result = getOrElse('name', 'Unknown', $array);
    expect($result)->toBe('Unknown');
});
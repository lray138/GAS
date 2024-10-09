<?php 

use function lray138\GAS\Arr\values;


it('returns values from a simple numeric indexed array', function () {
    $array = [10, 20, 30];
    $result = values($array);
    expect($result)->toBe([10, 20, 30]);
});

it('returns values from a simple associative array', function () {
    $array = ['a' => 10, 'b' => 20, 'c' => 30];
    $result = values($array);
    expect($result)->toBe([10, 20, 30]);
});

it('returns an empty array when given an empty array', function () {
    $array = [];
    $result = values($array);
    expect($result)->toBe([]);
});

it('returns values preserving numeric keys', function () {
    $array = [1 => 'one', 2 => 'two', 3 => 'three'];
    $result = values($array);
    expect($result)->toBe(['one', 'two', 'three']);
});

it('returns values preserving string keys', function () {
    $array = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
    $result = values($array);
    expect($result)->toBe(['one', 'two', 'three']);
});
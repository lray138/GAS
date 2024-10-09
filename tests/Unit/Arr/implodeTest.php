<?php

use function lray138\GAS\Arr\implode;

it('implodes an array with a given separator', function () {
    $separator = ', ';
    $array = ['a', 'b', 'c'];
    
    $result = implode($separator, $array);
    
    expect($result)->toBe('a, b, c');
});

it('returns an empty string when array is empty', function () {
    $separator = ', ';
    $array = [];
    
    $result = implode($separator, $array);
    
    expect($result)->toBe('');
});

it('returns the same string when array has one element', function () {
    $separator = ', ';
    $array = ['a'];
    
    $result = implode($separator, $array);
    
    expect($result)->toBe('a');
});

it('works with empty string as separator', function () {
    $separator = '';
    $array = ['a', 'b', 'c'];
    
    $result = implode($separator, $array);
    
    expect($result)->toBe('abc');
});

it('works with numbers in the array', function () {
    $separator = '-';
    $array = [1, 2, 3];
    
    $result = implode($separator, $array);
    
    expect($result)->toBe('1-2-3');
});

it('works with the curried function', function () {
    $curriedImplode = implode(', ');
    $array = ['a', 'b', 'c'];
    
    $result = $curriedImplode($array);
    
    expect($result)->toBe('a, b, c');
});

it('returns empty string for curried function with empty array', function () {
    $curriedImplode = implode(', ');
    $array = [];
    
    $result = $curriedImplode($array);
    
    expect($result)->toBe('');
});
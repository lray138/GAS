<?php

use function lray138\GAS\Arr\contains;

it('returns true when needle is in haystack', function () {
    $needle = 1;
    $haystack = [1, 2, 3];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeTrue();
});

it('returns false when needle is not in haystack', function () {
    $needle = 4;
    $haystack = [1, 2, 3];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeFalse();
});

it('works with string needle and haystack', function () {
    $needle = 'a';
    $haystack = ['a', 'b', 'c'];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeTrue();
});

it('returns false for an empty haystack', function () {
    $needle = 1;
    $haystack = [];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeFalse();
});

it('returns true for needle at the start of haystack', function () {
    $needle = 1;
    $haystack = [1, 2, 3];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeTrue();
});

it('returns true for needle at the end of haystack', function () {
    $needle = 3;
    $haystack = [1, 2, 3];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeTrue();
});

it('returns true for needle in the middle of haystack', function () {
    $needle = 2;
    $haystack = [1, 2, 3];
    
    $result = contains($needle, $haystack);
    
    expect($result)->toBeTrue();
});

it('returns true for curried function with needle and haystack', function () {
    $curriedContains = contains(1);
    $haystack = [1, 2, 3];
    
    $result = $curriedContains($haystack);
    
    expect($result)->toBeTrue();
});

it('returns false for curried function with needle not in haystack', function () {
    $curriedContains = contains(4);
    $haystack = [1, 2, 3];
    
    $result = $curriedContains($haystack);
    
    expect($result)->toBeFalse();
});

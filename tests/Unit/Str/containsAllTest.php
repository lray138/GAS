<?php

use function lray138\GAS\Str\containsAll;

test('containsAll with single needle found in haystack', function () {
    $result = containsAll('needle', 'this is a needle in the haystack');
    expect($result)->toBeTrue();
});

test('containsAll with single needle not found in haystack', function () {
    $result = containsAll('needle', 'this is a haystack without a ndle');
    expect($result)->toBeFalse();
});

test('containsAll with multiple needles all found in haystack', function () {
    $result = containsAll(['needle', 'haystack'], 'this is a needle in the haystack');
    expect($result)->toBeTrue();
});

test('containsAll with multiple needles not all found in haystack', function () {
    $result = containsAll(['needle', 'straw'], 'this is a needle in the haystack');
    expect($result)->toBeFalse();
});

test('containsAll with empty needle array', function () {
    $result = containsAll([], 'this is a needle in the haystack');
    expect($result)->toBeTrue();
});

test('containsAll with needle not as array and not found in haystack', function () {
    $result = containsAll('straw', 'this is a needle in the haystack');
    expect($result)->toBeFalse();
});

test('containsAll with empty haystack', function () {
    $result = containsAll('needle', '');
    expect($result)->toBeFalse();
});

test('containsAll with empty needle and empty haystack', function () {
    $result = containsAll('', '');
    expect($result)->toBeTrue();
});
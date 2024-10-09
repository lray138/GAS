<?php

use function lray138\GAS\Str\containsNone;

test('containsNone with single needle not in haystack', function () {
    expect(containsNone('foo', 'bar'))->toBeTrue();
});

test('containsNone with single needle in haystack', function () {
    expect(containsNone('foo', 'foobar'))->toBeFalse();
});

test('containsNone with multiple needles none in haystack', function () {
    expect(containsNone(['foo', 'baz'], 'bar'))->toBeTrue();
});

test('containsNone with multiple needles one in haystack', function () {
    expect(containsNone(['foo', 'bar'], 'barbaz'))->toBeFalse();
});

test('containsNone with empty needle and haystack', function () {
    expect(containsNone('', ''))->toBeTrue();
});

test('containsNone with empty needle and non-empty haystack', function () {
    expect(containsNone('', 'foobar'))->toBeTrue();
});

test('containsNone with non-empty needle and empty haystack', function () {
    expect(containsNone('foo', ''))->toBeTrue();
});
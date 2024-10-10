<?php

use function lray138\GAS\Str\isRegex;

test('returns true for regex', function () {
    expect(isRegex("/regex/"))->toBeTrue();
});

// added check for first and last character to match
test('returns false for non-regex', function () {
    expect(isRegex("string"))->toBeFalse();
});

// adding check for first last character matching but it's string
test('returns false for non-regex with first and last char the same', function () {
    expect(isRegex("strings"))->toBeFalse();
});
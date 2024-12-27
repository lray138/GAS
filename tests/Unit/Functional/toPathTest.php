<?php 

use function lray138\GAS\Functional\toPath;

it('returns the same array when an array is passed', function () {
    $input = ['user', 'profile', 'name'];
    expect(toPath($input))->toBe($input);
});

it('parses a dot-notation string into a path array', function () {
    $input = 'user.profile.name';
    expect(toPath($input))->toBe(['user', 'profile', 'name']);
});

it('parses a string with array notation into a path array', function () {
    $input = 'user[\'profile\'][0][\'name\']';
    expect(toPath($input))->toBe(['user', 'profile', '0', 'name']);
});

it('parses a mixed string with dots and array notation', function () {
    $input = 'user.profile[0].name';
    expect(toPath($input))->toBe(['user', 'profile', '0', 'name']);
});

it('handles numeric string values by casting them to an array of strings', function () {
    $input = 123;
    expect(toPath($input))->toBe(['123']);
});

it('returns an array containing a single string for a simple string input', function () {
    $input = 'username';
    expect(toPath($input))->toBe(['username']);
});

it('handles empty string input by returning an empty array', function () {
    $input = '';
    expect(toPath($input))->toBe([]);
});
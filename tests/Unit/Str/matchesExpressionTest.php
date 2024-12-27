<?php 

use function lray138\GAS\Str\matchesExpression;

it('matches a substring in the middle of the string using a regular expression', function() {
    expect(matchesExpression("/is/", "This is wonderful"))->toBeTrue();
});

it('matches a digit in a string', function() {
    expect(matchesExpression("/\d+/", "Room 123"))->toBeTrue();  // Matches digits
});

it('matches a repeating letter pattern', function() {
    expect(matchesExpression("/e{2,}/", "I seeeeeee you"))->toBeTrue();  // Matches 2 or more 'e's in a row
});

it('does not match a string with incorrect case', function() {
    expect(matchesExpression("/hello/", "HELLO WORLD"))->toBeFalse();  // Regex is case-sensitive
});

it('matches the start of a string', function() {
    expect(matchesExpression("/^Begin/", "Begin here"))->toBeTrue();  // Matches the start of the string
});

it('does not match when no pattern is found', function() {
    expect(matchesExpression("/\d+/", "No digits here"))->toBeFalse();  // No digits to match
});
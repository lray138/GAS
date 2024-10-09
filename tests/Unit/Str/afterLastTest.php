<?php

use function lray138\GAS\Str\afterLast;

it('returns the substring after the last comma delimiter', function () {
    $string = "one,two,three,four";
    $delimiter = ",";
    $expected = "four";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the substring after the last hyphen delimiter', function () {
    $string = "one-two-three-four";
    $delimiter = "-";
    $expected = "four";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the substring after the last space delimiter', function () {
    $string = "one two three four";
    $delimiter = " ";
    $expected = "four";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns an empty string when the delimiter is not found', function () {
    $string = "one_two_three_four";
    $delimiter = "/";
    $expected = "";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles empty string correctly', function () {
    $string = "";
    $delimiter = ":";
    $expected = "";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles string with no delimiter correctly', function () {
    $string = "one_two_three_four";
    $delimiter = ":";
    $expected = "";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles string where delimiter is at the start', function () {
    $string = ":one:two:three:four";
    $delimiter = ":";
    $expected = "four";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles string where delimiter is at the end', function () {
    $string = "one:two:three:four:";
    $delimiter = ":";
    $expected = "";
    
    $result = afterLast($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('includes the last delimiter when include_delimiter is true', function () {
    $string = "one,two,three,four";
    $delimiter = ",";
    $expected = "four,";
    
    $result = afterLast($delimiter, $string, true);
    
    expect($result)->toBe($expected);
});

it('does not include the last delimiter when include_delimiter is false', function () {
    $string = "one,two,three,four";
    $delimiter = ",";
    $expected = "four";
    
    $result = afterLast($delimiter, $string, false);
    
    expect($result)->toBe($expected);
});

<?php

use function lray138\GAS\Str\afterFirst;

it('returns the substring after the first comma delimiter', function () {
    $string = "one,two,three,four";
    $delimiter = ",";
    $expected = "two,three,four";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the substring after the first hyphen delimiter', function () {
    $string = "one-two-three-four";
    $delimiter = "-";
    $expected = "two-three-four";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the substring after the first space delimiter', function () {
    $string = "one two three four";
    $delimiter = " ";
    $expected = "two three four";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns an empty string when the delimiter is not found', function () {
    $string = "one_two_three_four";
    $delimiter = "/";
    $expected = "";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles empty string correctly', function () {
    $string = "";
    $delimiter = ":";
    $expected = "";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles string with no delimiter correctly', function () {
    $string = "one_two_three_four";
    $delimiter = ":";
    $expected = "";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles string where delimiter is at the start', function () {
    $string = ":one:two:three:four";
    $delimiter = ":";
    $expected = "one:two:three:four";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles string where delimiter is at the end', function () {
    $string = "one:two:three:four:";
    $delimiter = ":";
    $expected = "two:three:four:";
    
    $result = afterFirst($delimiter, $string);
    
    expect($result)->toBe($expected);
});

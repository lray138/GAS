<?php

use function lray138\GAS\Str\afterNth;

it('returns the substring after the first comma delimiter', function () {
    $string = "one,two,three,four";
    $delimiter = ",";
    $n = 1;
    $expected = "two,three,four";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the substring after the second hyphen delimiter', function () {
    $string = "one-two-three-four";
    $delimiter = "-";
    $n = 2;
    $expected = "three-four";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the substring after the third space delimiter', function () {
    $string = "one two three four";
    $delimiter = " ";
    $n = 3;
    $expected = "four";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns an empty string when n exceeds the number of segments with pipe delimiter', function () {
    $string = "one|two|three|four";
    $delimiter = "|";
    $n = 5;
    $expected = "";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns the whole string when n is 0 with semicolon delimiter', function () {
    $string = "one;two;three;four";
    $delimiter = ";";
    $n = 0;
    $expected = "one;two;three;four";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles negative n values correctly with dot delimiter', function () {
    $string = "one.two.three.four";
    $delimiter = ".";
    $n = -1;
    $expected = "four";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('returns an empty string when the delimiter is not found with slash delimiter', function () {
    $string = "one_two_three_four";
    $delimiter = "/";
    $n = 1;
    $expected = "";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles empty string correctly with colon delimiter', function () {
    $string = "";
    $delimiter = ":";
    $n = 1;
    $expected = "";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

it('handles strings with multiple different delimiters correctly', function () {
    $string = "one,two;three-four";
    $delimiter = ";";
    $n = 1;
    $expected = "three-four";
    
    $result = afterNth($n, $delimiter, $string);
    
    expect($result)->toBe($expected);
});

<?php 

use function lray138\GAS\Arr\exclude;
use function lray138\GAS\Arr\values;

it('excludes elements from the array based on the exclude array', function () {
    $array = [1, 2, 3, 4, 5];
    $exclude = [2, 4];
    $expected = [1, 3, 5]; // Expected result after excluding elements [2, 4]
    $result = exclude($exclude, $array);
    expect(values($result))->toBe($expected);
});

it('PHP Docs Example #1', function() {
	$array = array("a" => "green", "red", "blue", "red");
	$exclude = array("b" => "green", "yellow", "red");
	$expected = ["blue"];
	$result = exclude($exclude, $array);
	expect(values($result))->toBe($expected);
});

it('returns the original array when exclude array is empty', function () {
    $array = [1, 2, 3];
    $exclude = [];

    $result = exclude($exclude, $array);

    expect($result)->toBe($array);
});

it('returns an empty array when array to exclude from is empty', function () {
    $array = [];
    $exclude = [1, 2, 3];

    $result = exclude($exclude, $array);

    expect($result)->toBe([]);
});

it('returns an empty array when both arrays are empty', function () {
    $array = [];
    $exclude = [];

    $result = exclude($exclude, $array);

    expect($result)->toBe([]);
});

it('handles edge case with duplicate elements in the array', function () {
    $array = [1, 2, 2, 3, 4, 4, 5];
    $exclude = [2, 4];
    $expected = [1, 3, 5]; // Expected result after excluding elements [2, 4] (ignoring duplicates)
    $result = exclude($exclude, $array);
    expect(values($result))->toBe($expected);
});
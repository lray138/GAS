<?php 

use function lray138\GAS\Arr\flatMap;

it('flattens a multidimensional array', function () {
    $array = [[1, 2], [3, 4], [5, 6]];
    $result = flatMap(function($arr) {
        return $arr;
    }, $array);
    expect($result)->toBe([1, 2, 3, 4, 5, 6]);
});

it('handles empty arrays', function () {
    $array = [];
    $result = flatMap(function($arr) {
        return $arr;
    }, $array);
    expect($result)->toBe([]);
});

it('flattens arrays with different depths', function () {
    $array = [[1], [2, [3]], [[4]]];
    $result = flatMap(function($arr) {
        return $arr;
    }, $array);
    expect($result)->toBe([1, 2, [3], [4]]);
});

it('flattens associative arrays', function () {
    $array = [['a' => 1, 'b' => 2], ['c' => 3]];
    $result = flatMap(function($arr) {
        return $arr;
    }, $array);
    expect($result)->toBe(['a' => 1, 'b' => 2, 'c' => 3]);
});

it('applies a transformation function before flattening', function () {
    $array = [[1, 2], [3, 4], [5, 6]];
    $result = flatMap(function($arr) {
        return array_map(function($num) {
            return $num * 2;
        }, $arr);
    }, $array);

    expect($result)->toBe([2, 4, 6, 8, 10, 12]);
});

it('extracts all answers into a flat array', function() {
	// Example nested survey responses
	$responses = [
	    ['section' => 'Demographics', 'questions' => ['age' => 25, 'gender' => 'Male']],
	    ['section' => 'Preferences', 'questions' => ['color' => 'Blue', 'food' => 'Pizza']],
	    ['section' => 'Feedback', 'questions' => ['rating' => 4, 'comments' => 'Great experience']],
	];

	// Using flatMap to extract all answers into a flat array
	$result = flatMap(function($section) {
    	return array_values($section['questions']); // Extract only answers from each section
	}, $responses);

	expect($result)->toBe([25, 'Male', 'Blue', 'Pizza', 4, 'Great experience']);
});
<?php 

use function lray138\GAS\Arr\merge;

it('merges two indexed arrays', function () {
    // Test case 1: Merge two indexed arrays
    $array1 = [1, 2, 3];
    $array2 = [4, 5, 6];
    $result1 = merge($array1, $array2);
    expect($result1)->toBe([4, 5, 6, 1, 2, 3]);
});

it('merges an indexed array with an associative array', function () {
    // Test case 2: Merge an indexed array with an associative array
    $indexedArray = [1, 2, 3];
    $assocArray = ['name' => 'John', 'age' => 30];
    $result2 = merge($indexedArray, $assocArray);
    expect($result2)->toBe(['name' => 'John', 'age' => 30, 1, 2, 3]);
});

it('handles merging with an empty array', function () {
    // Test case 3: Merge with an empty array
    $array3 = [1, 2, 3];
    $result3 = merge($array3, []);
    expect($result3)->toBe([1, 2, 3]);
});

// omitting since this shouldn't work
// it('handles merging with null as second argument', function () {
//     // Test case 4: Merge with null as second argument
//     $array4 = [1, 2, 3];
//     $result4 = merge($array4, null);
//     expect($result4)->toBe([1, 2, 3]);
// });

it('merges two associative arrays', function () {
    // Test case 5: Merge two associative arrays
    $assocArray1 = ['name' => 'John', 'age' => 30];
    $assocArray2 = ['city' => 'New York', 'country' => 'USA'];
    $result5 = merge($assocArray1, $assocArray2);
    expect($result5)->toBe(['city' => 'New York', 'country' => 'USA', 'name' => 'John', 'age' => 30]);
});
<?php 

use function lray138\GAS\Arr\shuffle;

it('1) shuffles a numeric indexed array', function () {
    $array = [1, 2, 3, 4, 5];
    $result = shuffle($array);
    expect($result)->not->toBe([1, 2, 3, 4, 5]);
    expect($result)->toHaveCount(5); // Ensures all elements are still present
});

it('2) shuffles an associative array', function () {
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $result = shuffle($array);
    expect($result)->toHaveCount(3); // Ensures all elements are still present
});

it('3) shuffles an empty array', function () {
    $array = [];
    $result = shuffle($array);
    expect($result)->toBe([]);
});

/* come back to this */
// it('4) shuffles an array of objects', function () {
//     $obj1 = (object) ['name' => 'John'];
//     $obj2 = (object) ['name' => 'Jane'];
//     $array = [$obj1, $obj2];
//     $result = shuffle($array);
//     expect($result)->not->toBe([$obj1, $obj2]); // Objects should be shuffled
// });

/* come back to this */
// it('5) shuffles an array preserving numeric keys', function () {
//     $array = [1 => 'one', 2 => 'two', 3 => 'three'];
//     $result = shuffle($array);
//     expect(array_values($result))->not->toBe(['one', 'two', 'three']);
// });
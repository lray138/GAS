<?php 

use function lray138\GAS\Arr\end;

it('1) returns the last element of a non-empty array', function () {
    // Test case 1: Basic non-empty array
    $array1 = [10, 20, 30, 40, 50];
    expect(end($array1))->toBe(50);

    // Test case 2: Array with strings
    $array2 = ['apple', 'banana', 'cherry'];
    expect(end($array2))->toBe('cherry');

    // Test case 3: Array with mixed types (numeric and string)
    $array3 = [1, 'two', 3.5, 'four'];
    expect(end($array3))->toBe('four');
});

it('2) returns null for an empty array', function () {
    // Test case 4: Empty array
    $emptyArray = [];
    expect(end($emptyArray))->toBe(null);
});

it('3) returns the last element when the array pointer is moved', function () {
    // Test case 5: Array with the pointer moved
    $array5 = ['a', 'b', 'c'];
    next($array5); // Move the pointer to the second element
    expect(end($array5))->toBe('c');
});

it('4) handles associative arrays correctly', function () {
    // Test case 6: Associative array
    $assocArray = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
    expect(end($assocArray))->toBe("New York");
});
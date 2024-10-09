<?php 

use function lray138\GAS\Arr\keyExists;


it('checks if key exists in array', function () {
    // Test case 1: Key exists in the array
    $array1 = ['name' => 'John', 'age' => 30];
    $key1 = 'name';
    expect(keyExists($key1, $array1))->toBeTrue();

    // Test case 2: Key does not exist in the array
    $array2 = ['name' => 'John', 'age' => 30];
    $key2 = 'email';
    expect(keyExists($key2, $array2))->toBeFalse();
});

it('handles empty arrays correctly', function () {
    // Test case 3: Empty array
    $array3 = [];
    $key3 = 'name';
    expect(keyExists($key3, $array3))->toBeFalse();
});

it('handles special characters in keys', function () {
    // Test case 4: Special characters in key
    $array4 = ['user$name' => 'John', 'age' => 30];
    $key4 = 'user$name';
    expect(keyExists($key4, $array4))->toBeTrue();
});

it('handles null values in arrays', function () {
    // Test case 5: Null value in array
    $array5 = ['name' => null, 'age' => 30];
    $key5 = 'name';
    expect(keyExists($key5, $array5))->toBeTrue();
});

it('handles numeric keys in arrays', function () {
    // Test case 6: Numeric key in array
    $array6 = [0 => 'John', 'age' => 30];
    $key6 = 0;
    expect(keyExists($key6, $array6))->toBeTrue();
});
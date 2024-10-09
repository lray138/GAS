<?php 

use function lray138\GAS\Arr\joinKeyVal;

it('correctly joins key-value pairs with = delimiter', function () {
    $params = ['key1' => 'value1', 'key2' => 'value2'];
    $delimiter = '=';
    $expectedResult = ["key1=value1", "key2=value2"];
    $result = joinKeyVal($delimiter, $params);
    expect($result)->toBe($expectedResult);
});

// it('correctly joins key-value pairs with ; delimiter', function () {
//     $params = ['name' => 'John Doe', 'age' => 30];
//     $delimiter = ';';
//     $expectedResult = 'name=John Doe;age=30';
//     $result = joinKeyVal($delimiter, $params);
//     expect($result)->toBe($expectedResult);
// });

// it('handles an empty array by returning an empty string', function () {
//     $params = [];
//     $delimiter = '&';
//     $expectedResult = '';
//     $result = joinKeyVal($delimiter, $params);
//     expect($result)->toBe($expectedResult);
// });

// it('includes keys with empty values', function () {
//     $params = ['key' => ''];
//     $delimiter = '&';
//     $expectedResult = 'key=';
//     $result = joinKeyVal($delimiter, $params);
//     expect($result)->toBe($expectedResult);
// });

// it('preserves special characters in values', function () {
//     $params = ['special' => 'This & That'];
//     $delimiter = '&';
//     $expectedResult = 'special=This & That';
//     $result = joinKeyVal($delimiter, $params);
//     expect($result)->toBe($expectedResult);
// });
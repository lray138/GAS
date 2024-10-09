<?php 

use function lray138\GAS\Arr\of;
use lray138\GAS\Types\ArrType;

it('creates an instance of ArrType with the provided array', function () {
    $array = [1, 2, 3];

    $result = of($array);

    expect($result)->toBeInstanceOf(ArrType::class);
    expect($result->extract())->toBe($array);
});

it('handles an empty array', function () {
    $array = [];

    $result = of($array);

    expect($result)->toBeInstanceOf(ArrType::class);
    expect($result->extract())->toBe($array);
});

it('creates an instance with a complex array', function () {
    $array = [
        ['name' => 'Alice', 'age' => 25],
        ['name' => 'Bob', 'age' => 30],
    ];

    $result = of($array);

    expect($result)->toBeInstanceOf(ArrType::class);
    expect($result->extract())->toBe($array);
});

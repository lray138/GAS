<?php 

use function lray138\GAS\Arr\some;

it('returns true if at least one element matches the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $callable = fn($n) => $n > 3;

    $result = some($callable, $array);

    expect($result)->toBeTrue();
});

it('returns false if no elements match the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $callable = fn($n) => $n > 5;

    $result = some($callable, $array);

    expect($result)->toBeFalse();
});

it('returns false for an empty array', function () {
    $array = [];
    $callable = fn($n) => $n > 0;

    $result = some($callable, $array);

    expect($result)->toBeFalse();
});

it('works with non-numeric conditions', function () {
    $array = ['apple', 'banana', 'cherry'];
    $callable = fn($fruit) => $fruit === 'banana';

    $result = some($callable, $array);

    expect($result)->toBeTrue();
});

it('works with complex conditions', function () {
    $array = [
        ['name' => 'Alice', 'age' => 25],
        ['name' => 'Bob', 'age' => 30],
        ['name' => 'Charlie', 'age' => 35]
    ];
    $callable = fn($person) => $person['age'] > 30;

    $result = some($callable, $array);

    expect($result)->toBeTrue();
});

it('returns true if the first element matches the condition', function () {
    $array = [5, 1, 2, 3, 4];
    $callable = fn($n) => $n > 4;

    $result = some($callable, $array);

    expect($result)->toBeTrue();
});

it('returns true if the last element matches the condition', function () {
    $array = [1, 2, 3, 4, 5];
    $callable = fn($n) => $n === 5;

    $result = some($callable, $array);

    expect($result)->toBeTrue();
});

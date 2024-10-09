<?php 

use function lray138\GAS\Arr\chunk;

// chat gpt tests

it('chunks an array into equal parts', function () {
    $array = [1, 2, 3, 4, 5, 6];
    $size = 2;

    $result = chunk($size, $array);

    expect($result)->toBe([[1, 2], [3, 4], [5, 6]]);
});

it('chunks an array with uneven last chunk', function () {
    $array = [1, 2, 3, 4, 5];
    $size = 2;

    $result = chunk($size, $array);

    expect($result)->toBe([[1, 2], [3, 4], [5]]);
});

it('chunks an empty array', function () {
    $array = [];
    $size = 3;

    $result = chunk($size, $array);

    expect($result)->toBe([]);
});

it('returns the original array when chunk size is 1', function () {
    $array = ['a', 'b', 'c'];
    $size = 1;

    $result = chunk($size, $array);

    expect($result)->toBe([['a'], ['b'], ['c']]);
});

it('chunks a large array into smaller parts', function () {
    $array = range(1, 100);
    $size = 10;

    $result = chunk($size, $array);

    expect($result)->toHaveLength(10);
    foreach ($result as $chunk) {
        expect($chunk)->toHaveLength(10);
    }
});
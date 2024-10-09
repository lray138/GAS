<?php 

use function lray138\GAS\Arr\toObj;

it('converts an associative array to an object', function () {
    $array = ['a' => 'apple', 'b' => 'banana'];

    $result = toObj($array);

    expect($result)->toBeInstanceOf(\StdClass::class);
    expect($result->a)->toBe('apple');
    expect($result->b)->toBe('banana');
});

it('converts an empty array to an empty object', function () {
    $array = [];

    $result = toObj($array);

    expect($result)->toBeInstanceOf(\StdClass::class);
    expect((array)$result)->toBeEmpty();
});

it('handles nested arrays', function () {
    $array = [
        'a' => 'apple',
        'b' => ['banana', 'berry'],
        'c' => ['d' => 'date', 'e' => 'elderberry'],
        'e' => [1, 2],
        'f' => 99
    ];

    $result = toObj($array);

    expect($result)->toBeInstanceOf(\StdClass::class);
    expect($result->a)->toBe('apple');
    expect($result->b)->toBe(['banana', 'berry']);
    expect($result->c)->toBeInstanceOf(\StdClass::class);
    expect($result->c->d)->toBe('date');
    expect($result->c->e)->toBe('elderberry');
    expect($result->e)->toBe([1,2]);
    expect($result->f)->toBe(99);
});

it('handles arrays with non-string keys', function () {
    $array = [1 => 'one', 2 => 'two'];

    $result = toObj($array);

    expect($result)->toBeInstanceOf(\StdClass::class);
    expect($result->{1})->toBe('one');
    expect($result->{2})->toBe('two');
});

it('handles mixed keys', function () {
    $array = ['a' => 'apple', 1 => 'one', 'b' => 'banana', 2 => 'two'];

    $result = toObj($array);

    expect($result)->toBeInstanceOf(\StdClass::class);
    expect($result->a)->toBe('apple');
    expect($result->{1})->toBe('one');
    expect($result->b)->toBe('banana');
    expect($result->{2})->toBe('two');
});
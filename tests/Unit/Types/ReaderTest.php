<?php

use lray138\GAS\Types\Reader;

it('can lift a value into the Reader context using ::of', function () {
    $reader = Reader::of(42);
    expect($reader->run('env'))->toBe(42); // env ignored
});

it('can access the environment using ::ask', function () {
    $reader = Reader::ask();
    expect($reader->run('my-env'))->toBe('my-env');
});

it('can map a function over the Reader', function () {
    $reader = Reader::of(3)->map(fn($x) => $x + 2);
    expect($reader->run('env'))->toBe(5);
});

it('can chain computations in the Reader monad', function () {
    $reader = Reader::of(10)->bind(function ($x) {
        return Reader::of($x * 2);
    });

    expect($reader->run('env'))->toBe(20);
});

it('can apply one Reader to another using ap', function () {
    $add = Reader::of(fn($x) => $x + 100);
    $value = Reader::of(50);
    $applied = $add->ap($value);

    expect($applied->run('env'))->toBe(150);
});

it('preserves the environment through chained operations', function () {
    $reader = Reader::ask()
        ->map(fn($env) => $env['foo'])
        ->map(fn($foo) => strtoupper($foo));

    $env = ['foo' => 'bar'];
    expect($reader->run($env))->toBe('BAR');
});

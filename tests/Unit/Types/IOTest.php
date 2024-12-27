<?php

use lray138\GAS\Types\IO;

it('can wrap a value using IO::of', function () {
    $io = IO::of(42);
    expect($io)->toBeInstanceOf(IO::class);
    expect($io->run())->toBe(42);
});

it('can map over a value in IO', function () {
    $io = IO::of(5);
    $mappedIO = $io->map(fn($x) => $x * 2);
    
    expect($mappedIO->run())->toBe(10);
});

it('can chain IO actions', function () {
    $io = IO::of(10);
    
    $chainedIO = $io->bind(function ($x) {
        return IO::of($x + 5);
    });

    expect($chainedIO->run())->toBe(15);
});

it('can apply one IO to another using ap', function () {
    $ioFunction = IO::of(fn($x) => $x + 10);
    $ioValue = IO::of(5);

    $appliedIO = $ioFunction->ap($ioValue);

    expect($appliedIO->run())->toBe(15);
});

it('can perform unsafe actions', function () {
    $io = new IO(function () {
        return 'unsafe action';
    });

    expect($io->run())->toBe('unsafe action');
});

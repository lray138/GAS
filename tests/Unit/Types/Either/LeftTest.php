<?php 

use lray138\GAS\Types\Either;
use lray138\GAS\Types\Either\Left;
use const lray138\GAS\Functional\noOp;

it('correctly wraps a value in Left using of', function () {
    $left = Left::of(10);
    expect($left->extract())->toBe(10);
});

it('returns the same value in ap', function () {
    $left = Left::of(10);
    $result = $left->ap(Left::of(20));
    expect($result->extract())->toBe(20);  // As ap returns the same value.
});

it('transforms only the Left side using bimap', function () {
    $left = Left::of(10);
    $result = $left->bimap(fn($x) => $x + 5, fn($x) => $x * 2);
    expect($result->extract())->toBe(15);  // Only Left is transformed.
});

it('returns the same Left instance in chain', function () {
    $left = Left::of(10);
    $result = $left->chain(fn($x) => Either::right($x + 10));
    expect($result)->toBeInstanceOf(Left::class);
    expect($result->extract())->toBe(10);  // Left doesn't chain further.
});

it('returns the same Left instance in map', function () {
    $left = Left::of(10);
    $result = $left->map(fn($x) => $x + 10);
    expect($result)->toBeInstanceOf(Left::class);
    expect($result->extract())->toBe(10);  // Map does not affect Left.
});

it('correctly applies either on the Left value', function () {
    $left = Left::of(10);
    $result = $left->either(fn($x) => $x + 5, fn($x) => $x * 2);
    expect($result)->toBe(15);  // Left value is transformed.
});

it('correctly folds over the Left value', function () {
    $left = Left::of(10);
    $result = $left->fold(fn($x) => $x + 5, fn($x) => $x * 2);
    expect($result)->toBe(15);  // Left value is folded.
});

it('correctly identifies as Left', function () {
    $left = Left::of(10);
    expect($left->isLeft())->toBeTrue();
    expect($left->isRight())->toBeFalse();
});

it('returns false for isNothing and isString', function () {
    $left = Left::of(10);
    expect($left->isNothing())->toBeFalse();
    expect($left->isString())->toBeFalse();
});

it('returns the same instance when __call is used', function () {
    $left = Left::of(10);
    $result = $left->someNonExistentMethod();
    expect($result)->toBe($left);  // __call returns the same Left instance.
});

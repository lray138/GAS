<?php 

use lray138\GAS\Types\Either;
use lray138\GAS\Types\Either\Right;
use const lray138\GAS\Functional\noOp;

it('constructs', function() {
	$either = Either::right("ok");
	expect($either)->toBeInstanceOf(Either::class);

	$right = Right::of("ok");
	expect($right)->toBeInstanceOf(Either::class);
});

it('applies the function from the right Either', function () {
    $either = Right::of(function ($x) {
        return $x * 2;
    });

    $applied = $either->ap(Right::of(5));

    expect($applied->fold(fn($x) => "", fn($x) => $x))->toBe(10);
});

it('bimaps the right side only', function () {
    $either = Right::of(10);
    $bimapped = $either->bimap(
        fn($left) => $left - 2, // Left transformation (ignored)
        fn($right) => $right + 5 // Right transformation (applied)
    );

    expect($bimapped->fold(fn($x) => $x, fn($x) => $x))->toBe(15);
});

it('chains the right value', function () {
    $either = Right::of(10);
    $chained = $either->chain(fn($x) => Right::of($x + 20));

    expect($chained->fold(noOp, fn($x) => $x))->toBe(30);
});

it('maps over the right value', function () {
    $either = Right::of(5);
    $mapped = $either->map(fn($x) => $x * 3);

    expect($mapped->fold(noOp, fn($x) => $x))->toBe(15);
});

it('correctly handles either', function () {
    $either = Either::right(42);
    $result = $either->either(
        fn($left) => "Left: $left", // Left handler (ignored)
        fn($right) => "Right: $right" // Right handler (used)
    );

    expect($result)->toBe("Right: 42");
});

it('folds over the right value', function () {
    $either = Right::of("folded");
    $result = $either->fold(
        fn($left) => "Left: $left",  // Left fold (ignored)
        fn($right) => strtoupper($right) // Right fold (used)
    );

    expect($result)->toBe("FOLDED");
});

it('identifies itself as right', function () {
    $either = Either::right(100);
    expect($either->isRight())->toBeTrue();
});

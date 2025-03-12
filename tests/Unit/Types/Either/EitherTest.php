<?php 

use lray138\GAS\Types\Either\Left;
use lray138\GAS\Types\Either\Right;
use lray138\GAS\Types\Either;

class TestObject
{
    private $name;

    public function __construct(string $name = "Default Name")
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

it('correctly puts it in the right subtype using Either::of', function() {
    $either = Either::of(null);
    expect($either)->toBeInstanceOf(Left::class);
    expect($either->extract())->toBe(null);

    $either = Either::of("test");
    expect($either)->toBeInstanceOf(Right::class);
    expect($either->extract())->toBe("test");
});

it('puts the message in correctly', function() {
    $testObject = new TestObject("My Test Name");
    $either = Either::of($testObject);
    expect($either)->toBeInstanceOf(Right::class);
    $either->map(function($x) {

    });
});

it('correctly wraps a value in Right using of', function () {
    $right = Right::of(10);
    expect($right->extract())->toBe(10);
});

it('correctly wraps a value in Left using of', function () {
    $left = Left::of('Error');
    expect($left->extract())->toBe('Error');
});

it('applies a function to Right via map', function () {
    $right = Right::of(10);
    $result = $right->map(fn($x) => $x + 20);
    expect($result)->toBeInstanceOf(Right::class);
    expect($result->extract())->toBe(30);  // Right value is transformed.
});

it('does nothing to Left via map', function () {
    $left = Left::of('Error');
    $result = $left->map(fn($x) => $x + 20);
    expect($result)->toBeInstanceOf(Left::class);
    expect($result->extract())->toBe('Error');  // Left remains unchanged.
});

it('chains a Right with a new Right in chain', function () {
    $right = Right::of(10);
    $result = $right->chain(fn($x) => Right::of($x + 20));
    expect($result)->toBeInstanceOf(Right::class);
    expect($result->extract())->toBe(30);  // Right value is chained.
});

it('does nothing to Left in chain', function () {
    $left = Left::of('Error');
    $result = $left->chain(fn($x) => Right::of($x + 20));
    expect($result)->toBeInstanceOf(Left::class);
    expect($result->extract())->toBe('Error');  // Left does not chain further.
});

it('applies the left function in bimap to Left', function () {
    $left = Left::of('Error');
    $result = $left->bimap(fn($x) => "Fixed: $x", fn($x) => $x + 20);
    expect($result->extract())->toBe('Fixed: Error');  // Left is transformed.
});

it('applies the right function in bimap to Right', function () {
    $right = Right::of(10);
    $result = $right->bimap(fn($x) => "Error", fn($x) => $x + 20);
    expect($result->extract())->toBe(30);  // Right is transformed.
});

it('applies the fold function correctly for Left', function () {
    $left = Left::of('Error');
    $result = $left->fold(fn($x) => "Fixed: $x", fn($x) => $x + 20);
    expect($result)->toBe('Fixed: Error');  // Left value is folded with the left function.
});

it('applies the fold function correctly for Right', function () {
    $right = Right::of(10);
    $result = $right->fold(fn($x) => "Error", fn($x) => $x + 20);
    expect($result)->toBe(30);  // Right value is folded with the right function.
});

it('identifies Left and Right correctly', function () {
    $left = Left::of('Error');
    $right = Right::of(10);

    expect($left->isLeft())->toBeTrue();
    expect($left->isRight())->toBeFalse();

    expect($right->isRight())->toBeTrue();
    expect($right->isLeft())->toBeFalse();
});

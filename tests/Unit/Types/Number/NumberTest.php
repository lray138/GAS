<?php 

use lray138\GAS\Types\Number;

it('returns a Number instance with a static::of()', function () {
    $n = Number::of(10);

    expect($n)->toBeInstanceOf(Number::class)
                ->and($n->extract())->toBe(10);
});

it('constructs with a numeric value', function () {
    $number = new Number(42);
    expect($number->extract())->toBe(42); // Assuming extract() returns the float value
});

it('throws an exception when constructed with a non-numeric value', function () {
    expect(fn () => new Number("not a number"))
        ->toThrow(InvalidArgumentException::class);
});

it('adds numbers correctly', function () {
    $number = new Number(10);
    $result = $number->add(5);
    expect($result->extract())->toBe(15);
});


it('divides numbers correctly', function () {
    $number = new Number(10);
    $result = $number->divide(2);
    expect($result->extract())->toBe(5);
    $result = $number->divideBy(2);
    expect($result->extract())->toBe(5);
    $result = $number->div(2);
    expect($result->extract())->toBe(5);
});

it('multiplies numbers correctly', function () {
    $number = new Number(10);
    $result = $number->multiply(5);
    expect($result->extract())->toBe(50);
});

it('rounds numbers correctly', function () {
    $number = new Number(10.555);
    $result = $number->roundTo(2);
    expect($result->extract())->toBe(10.56);
});

it('formats numbers correctly', function () {
    $number = new Number(1234.5678);
    $result = $number->format(2);
    expect($result->extract())->toBe('1,234.57'); // Assuming Str() returns a string representation
});

it('checks equality correctly', function () {
    $number = new Number(10);
    expect($number->equals(10))->toBeTrue();
    expect($number->equals(5))->toBeFalse();
});

it('checks greater than correctly', function () {
    $number1 = new Number(10);
    $number2 = new Number(5);
    expect($number1->isGreaterThan($number2)->isTrue())->toBeTrue();
    expect($number1->isGreaterThan(15)->isTrue())->toBeFalse();
});

it('concats correctly using mempty and adding by default', function() {
    $result = Number::mempty()   
        ->concat(Number::of(5))
        ->concat(Number::of(6))
        ->get();

    expect($result)->toBe(11);
});

it('concats correctly using mempty and multilly by specification', function() {
    $result = Number::mempty("mul")   
        ->concat(Number::of(5))
        ->concat(Number::of(6))
        ->get();

    expect($result)->toBe(30);
});

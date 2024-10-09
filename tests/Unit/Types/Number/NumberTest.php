<?php 

use lray138\GAS\Types\Number;

it('returns a Number instance with a static::of()', function () {
    $n = Number::of(10);

    expect($n)->toBeInstanceOf(Number::class)
                ->and($n->extract())->toBe(10.0);
});

it('constructs with a numeric value', function () {
    $number = new Number(42);
    expect($number->extract())->toBe(42.0); // Assuming extract() returns the float value
});

it('constructs with a non-numeric value', function () {
    $number = new Number("not a number");
    expect($number->extract())->toBe(0);
});

it('adds numbers correctly', function () {
    $number = new Number(10);
    $result = $number->add(5);
    expect($result->extract())->toBe(15.0);
});

it('divides numbers correctly', function () {
    $number = new Number(10);
    $result = $number->divide(2);
    expect($result->extract())->toBe(5.0);
    $result = $number->divideBy(2);
    expect($result->extract())->toBe(5.0);
    $result = $number->div(2);
    expect($result->extract())->toBe(5.0);
});

it('multiplies numbers correctly', function () {
    $number = new Number(10);
    $result = $number->multiply(5);
    expect($result->extract())->toBe(50.0);
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
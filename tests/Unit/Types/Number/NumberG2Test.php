<?php 

use lray138\GAS\Types\NumberG2 as Number;
use lray138\GAS\Types\StrTypeG2 as StrType;

it('returns a Number instance with a static::of()', function () {
    $n = Number::of(10);

    expect($n)->toBeInstanceOf(Number::class)
                ->and($n->extract())->toBe(10);
});

it('adds correctly', function() {
    $n = Number::of(10)->add(Number::of(10));
    expect($n->extract())->toBe(20);
});

it('compares correctly', function() {
    $n = Number::of(10)->equals(Number::of(10));
    expect($n->isTrue())->toBeTrue();
    $n = Number::of(10)->equals(Number::of(9));
    expect($n->isFalse())->toBeTrue();
});

it('multiplies correctly', function() {
    $ten = Number::of(10);
    $n = $ten->multiply($ten);
    expect($n->extract())->toBe(100);
    $n = $ten->mult($ten);
    expect($n->extract())->toBe(100);
});

it('concats with mempty - add', function() {
    $number = new Number(7);
    $mempty = Number::mempty(); // This should be 0
    
    // Use the concat method with mempty
    $result = $number->concat($mempty);

    // Assert that the result is as expected
    expect($result->extract())->toBe(7);
});

it('concats with numbers - add', function() {
    $number1 = new Number(5);
    $number2 = new Number(10);
    
    // Use the concat method
    $result = $number1->concat($number2);

    expect($result->extract())->toBe(15);
});

it('concats with mempty - mul', function() {
    $mul = StrType::of("mul");

    $number = new Number(7, $mul);
    $mempty = Number::mempty($mul); // This should be 1
    
    // Use the concat method with mempty
    $result = $number->concat($mempty);

    // Assert that the result is as expected
    expect($result->extract())->toBe(7);


    $n2 = Number::of(7)->setOperation($mul);
    $mempty = Number::mempty($mul);

    $result = $number->concat($mempty);
    expect($result->extract())->toBe(7);
});

it('concats with numbers - mul', function() {
    $mul = StrType::of("mul");

    $number1 = new Number(5, $mul);
    $number2 = new Number(10, $mul);
    
    // Use the concat method
    $result = $number1->concat($number2);

    expect($result->extract())->toBe(50);
});

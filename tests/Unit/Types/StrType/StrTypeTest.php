<?php 

use lray138\GAS\Types\StrType;

it('returns a StrType instance with a string value when calling static::of()', function () {
    $str = StrType::of(10);

    expect($str)->toBeInstanceOf(StrType::class)
                ->and($str->extract())->toBe('10'); // Assuming getValue() returns the encapsulated value
});

it('casts an int and float to a string instance when calling static::of()', function () {
    $str = StrType::of(10);
    expect($str->extract())->toEqual("10");

    $str = StrType::of(10.1);
    expect($str->extract())->toEqual("10.1");
});

it('map works', function() {
	$value = StrType::of("test")->map(fn($x) => strtoupper($x))->extract();
	expect($value)->toEqual("TEST");
});
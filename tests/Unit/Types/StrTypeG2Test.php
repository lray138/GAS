<?php

use lray138\GAS\Types\StrTypeG2 as StrType;
use lray138\GAS\Types\ArrTypeG2 as ArrType;
use lray138\GAS\Types\NumberG2 as Number;

it('concats with mempty', function() {
    $str = new StrType("It's a");
    $mempty = StrType::mempty(); // This should be ""
    
    // Use the concat method with mempty
    $result = $str->concat($mempty);

    // Assert that the result is as expected
    expect($result->extract())->toBe("It's a");
});

it('concats with strings', function() {
    $str1 = new StrType("It's a");
    $str2 = new StrType(" Wonderful Life");
    
    // Use the concat method
    $result = $str1->concat($str2);

    expect($result->extract())->toBe("It's a Wonderful Life");
});

it('is pointed', function() {
    $str = StrType::of("Test");
    expect($str)->toBeInstanceOf(StrType::class);
});

it('is a functor', function() {
    $str = StrType::of("test")->map("strtoupper")->extract();
    expect($str)->toBe("TEST");
});

it('explodes on a delemiter', function() {
    $arr = StrType::of("perhaps/a/path")->explode(StrType::of("/"));
    expect($arr)->toBeInstanceOf(ArrType::class);
    expect($arr->count()->eq(Number::of(3))->isTrue())->toBeTrue();
});

<?php

use lray138\GAS\Types\StrTypeG2 as StrType;
use lray138\GAS\Types\ArrTypeG2 as ArrType;
use lray138\GAS\Types\NumberG2 as Number;

it('concats with mempty', function() {
    $arr = new ArrType(["a"]);
    $mempty = ArrType::mempty(); // This should be ""
    
    // Use the concat method with mempty
    $result = $arr->concat($mempty);

    // Assert that the result is as expected
    expect($result->extract())->toBe(["a"]);
});

it('concats with ArrType', function() {
    $a1 = new ArrType(["a", "b", "c"]);
    $a2 = new ArrType(["d", "e", "f"]);
    
    // Use the concat method
    $result = $a1->concat($a2);

    expect($result->extract())->toBe(["a", "b", "c", "d" , "e", "f"]);
});

// it('is pointed', function() {
//     $str = StrType::of("Test");
//     expect($str)->toBeInstanceOf(StrType::class);
// });

// it('is a functor', function() {
//     $str = StrType::of("test")->map("strtoupper")->extract();
//     expect($str)->toBe("TEST");
// });

// it('explodes on a delemiter', function() {
//     $arr = StrType::of("perhaps/a/path")->explode(StrType::of("/"));
//     expect($arr)->toBeInstanceOf(ArrType::class);
//     expect($arr->count()->eq(Number::of(3))->isTrue())->toBeTrue();
// });
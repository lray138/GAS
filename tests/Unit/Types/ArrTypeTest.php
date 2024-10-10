<?php

use lray138\GAS\Types\StrType as StrType;
use lray138\GAS\Types\ArrType as A;
use lray138\GAS\Types\Number as Number;

// it('concats with mempty', function() {
//     $arr = new ArrType(["a"]);
//     $mempty = ArrType::mempty(); // This should be ""
    
//     // Use the concat method with mempty
//     $result = $arr->concat($mempty);

//     // Assert that the result is as expected
//     expect($result->extract())->toBe(["a"]);
// });

// it('concats with ArrType', function() {
//     $a1 = new ArrType(["a", "b", "c"]);
//     $a2 = new ArrType(["d", "e", "f"]);
    
//     // Use the concat method
//     $result = $a1->concat($a2);

//     expect($result->extract())->toBe(["a", "b", "c", "d" , "e", "f"]);
// });

it('is pointed', function() {
    $a = A::of([]);
    expect($a)->toBeInstanceOf(A::class);
});

it('can push a new value and not modify original array (immutability)', function() {
    $a = A::of([]);
    $b = $a->push("test");

    expect($a->extract())->toBe([]);
    expect($b->extract())->toBe(["test"]);
});

it('can sum the contents of an array', function() {
    $a = A::of([1,2,3])->sum();
    expect($a)->toBeInstanceOf(Number::class);
    expect($a->extract())->toBe(6);
});

it('can merge', function() {
    $a = A::of(["a", "b", "c"]);
    $b = $a->merge(["d", "e", "f"]);

    $expected = ["a", "b", "c", "d", "e", "f"];

    expect($a->extract())->toBe(["a", "b", "c"]);
    expect($b->extract())->toBe($expected);

    $c = $a->merge(A::of(["d", "e", "f"]));
    expect($c->extract())->toBe($expected);
});
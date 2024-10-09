<?php

use lray138\GAS\Types\Type;

describe('Pointed', function () {
    
    it('lifts a value into a Type instance', function () {
        // Lift the value into the Type context
        $t = Type::of(10);

        // Assert that the result is an instance of Type
        expect($t)->toBeInstanceOf(Type::class);
    });

    // You could add more tests related to Pointed functionality
});

describe('Comonad', function () {

    it('allows extraction of the value', function () {
        // Lift the value into the Type context
        $t = Type::of(10);

        // Extract the value and check that it is correctly set
        expect($t->extract())->toEqual(10); // Assuming extract() exists
    });

    it('allows extending functionality', function () {
        // Lift the value into the Type context
        $t = Type::of(10);

        // Assuming extend() exists and modifies the context
        $result = $t->extend(function ($context) {
            return $context->extract() + 5; // Example modification
        });

        // Check that the result is correct based on the extended function
        expect($result->extract())->toEqual(15); // Adjust based on your logic
    });

    it('allows duplication of the comonad', function () {
        // Lift the value into the Type context
        $t = Type::of(10);

        // Create a duplicate of the comonad
        $duplicate = $t->duplicate(); // Assuming duplicate() exists

        // Assert that the duplicate is an instance of Type
        expect($duplicate)->toBeInstanceOf(Type::class);

        // Check that the original and duplicate are distinct instances
        expect($duplicate->extract())->not->toBe($t); // They should not be the same instance

        // Optionally, check that the extraction from the duplicate still works
        expect($duplicate->extract()->extract())->toEqual($t->extract()); // Should have the same value
    });

});

describe('Applicative', function () {
    it('follows identity law', function () {
        $wrappedValue = Type::of(10);
        $identityFunc = Type::of(function ($x) {
            return $x; // Identity function
        });

        // Apply the identity function to the wrapped value
        $result = $identityFunc->ap($wrappedValue);

        // Assert that the result is equal to the original value
        expect($result->extract())->toBe(10);
    });

    it('follows homomorphism law', function () {
        $value = 10;
        $wrappedFunc = Type::of(function ($x) {
            return $x * 2; // A function that doubles its input
        });

        // Apply the function to the value directly
        $directResult = $wrappedFunc->extract()($value);

        // Wrap both the function and value and apply
        $wrappedValue = Type::of($value);
        $apResult = $wrappedFunc->ap($wrappedValue);

        // Assert both results are equal
        expect($directResult)->toBe($apResult->extract());
    });

    it('follows interchange law', function () {
        $value = 5;

        // Create a wrapped function that doubles its input
        $wrappedFunc = Type::of(function ($x) {
            return $x * 2; // A function that doubles its input
        });

        // Apply the wrapped function to the wrapped value
        $result1 = $wrappedFunc->ap(Type::of($value));

        // Apply the wrapped value to the wrapped function using map
        $result2 = Type::of($value)->map(function ($v) use ($wrappedFunc) {
            return $wrappedFunc->extract()($v);
        });

        // Assert both results are equal
        expect($result1->extract())->toBe($result2->extract());
    });
});

describe('Chain', function () {
    it('follows left identity law', function () {
        $value = 10;
        $wrappedValue = new Type($value);

        // Define a function that wraps a value
        $wrapFn = function ($x) {
            return new Type($x * 2); // Wrap and double the input
        };

        // Use chain to apply the function
        $result = $wrappedValue->chain($wrapFn);

        // Assert the result is as expected
        expect($result->extract())->toBe(20); // 10 * 2
    });

    it('follows associativity law', function () {
        $value = 10;
        $wrappedValue = new Type($value);

        // Define two functions that wrap a value
        $firstFn = function ($x) {
            return new Type($x + 5); // Add 5
        };

        $secondFn = function ($x) {
            return new Type($x * 2); // Multiply by 2
        };

        // Chain using the first function, then the second
        $result1 = $wrappedValue->chain($firstFn)->chain($secondFn);

        // Chain using the second function, then the first
        $result2 = $wrappedValue->chain(function ($x) use ($firstFn, $secondFn) {
            return $secondFn($firstFn($x)->extract());
        });

        // Assert both results are equal
        expect($result1->extract())->toBe($result2->extract()); // Should be equal
    });
});

<?php

use lray138\GAS\Types\Functor\IdentityFunctor;

it('can create an IdentityFunctor using the constructor', function () {
    $identity = new IdentityFunctor(42);
    expect($identity->extract())->toBe(42);
});

it('can create an IdentityFunctor using the of method', function () {
    $identity = IdentityFunctor::of(100);
    expect($identity->extract())->toBe(100);
});

it('can map a function over an IdentityFunctor', function () {
    $identity = new IdentityFunctor(5);
    $result = $identity->map(function ($x) {
        return $x * 2;
    });
    expect($result->extract())->toBe(10);
});

it('can extract the value from an IdentityFunctor', function () {
    $identity = new IdentityFunctor('Hello World');
    expect($identity->extract())->toBe('Hello World');
});

it('can duplicate an IdentityFunctor', function () {
    $identity = new IdentityFunctor(42);
    $result = $identity->duplicate();
    
    expect($result->extract()->extract())->toBe($identity->extract());
});
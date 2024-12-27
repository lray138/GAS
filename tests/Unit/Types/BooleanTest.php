<?php

use lray138\GAS\Types\Boolean;

it('creates a Boolean with true value and "and" operation', function () {
    $bool = new Boolean(true, "and");
    expect($bool->extract())->toBe(true);
    expect($bool->isTrue())->toBeTrue();
    expect($bool->isFalse())->toBeFalse();
});

it('creates a Boolean with false value and "and" operation', function () {
    $bool = new Boolean(false, "and");
    expect($bool->extract())->toBe(false);
    expect($bool->isTrue())->toBeFalse();
    expect($bool->isFalse())->toBeTrue();
});

it('creates a Boolean with true value and "or" operation', function () {
    $bool = new Boolean(true, "or");
    expect($bool->extract())->toBe(true);
    expect($bool->isTrue())->toBeTrue();
    expect($bool->isFalse())->toBeFalse();
});

it('creates a Boolean with false value and "or" operation', function () {
    $bool = new Boolean(false, "or");
    expect($bool->extract())->toBe(false);
    expect($bool->isTrue())->toBeFalse();
    expect($bool->isFalse())->toBeTrue();
});

it('returns the correct mempty for "and" operation', function () {
    $mempty = Boolean::mempty("and");
    expect($mempty->extract())->toBe(true); // Identity for "and" is true
});

it('returns the correct mempty for "or" operation', function () {
    $mempty = Boolean::mempty("or");
    expect($mempty->extract())->toBe(false); // Identity for "or" is false
});

it('combines two Booleans using "and" operation', function () {
    $bool1 = new Boolean(true, "and");
    $bool2 = new Boolean(false, "and");

    $combined = $bool1->concat($bool2);
    expect($combined->extract())->toBe(false); // true && false = false
});

it('combines two Booleans using "or" operation', function () {
    $bool1 = new Boolean(true, "or");
    $bool2 = new Boolean(false, "or");

    $combined = $bool1->concat($bool2);
    expect($combined->extract())->toBe(true); // true || false = true
});

it('combines Boolean with mempty using "and" operation', function () {
    $bool = new Boolean(true, "and");
    $identity = Boolean::mempty("and");

    $combined = $bool->concat($identity);
    expect($combined->extract())->toBe(true); // true && true (identity) = true
});

it('combines Boolean with mempty using "or" operation', function () {
    $bool = new Boolean(false, "or");
    $identity = Boolean::mempty("or");

    $combined = $bool->concat($identity);
    expect($combined->extract())->toBe(false); // false || false (identity) = false
});

it('throws an exception when combining with non-Boolean', function () {
    $bool = new Boolean(true, "and");
    expect(fn() => $bool->concat(10))->toThrow(\TypeError::class);
});

it('throws an exception for invalid operation in combine', function () {
    $bool1 = new Boolean(true, "invalid_operation");
    $bool2 = new Boolean(false, "invalid_operation");

    expect(fn() => $bool1->concat($bool2))->toThrow(\LogicException::class);
});

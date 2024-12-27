<?php 

use lray138\GAS\Types\Many;
use lray138\GAS\Types\Maybe;

it('can construct elements correctly', function() {
	$many = new Many([]);
	expect($many)->toBeInstanceOf(Many::class);
});

it('throws an exception for non-iterable values', function() {
    new Many(''); // Passing a non-iterable value
})->throws(\InvalidArgumentException::class, 'Expected an iterable or traversable value');

it('can create an instance using static create', function() {
	$many = Many::create([]);
	expect($many)->toBeInstanceOf(Many::class);
});

it('can create an instance using static of', function() {
	$many = Many::create([]);
	expect($many)->toBeInstanceOf(Many::class);
});

it('can "extend" to another type', function() {
	$maybe = Many::create([])->extend(Maybe::of);

	expect($maybe)->toBeInstanceOf(Maybe::class);
});

it('will fail if I try to "extend" to a non-Comonad', function() {
	$try = Many::create([])->extend(function($x) {
		return "string";
	});
})->throws(\TypeError::class);

it('maps correctly', function() {
	$result = Many::of(["a", "b", "c"])
		->map("strtoupper")
		->extract();

	expect($result)->toBe(["A", "B", "C"]);

	$result = Many::of(["a", "b", "c"])
		->map(function($x) {
			return Maybe::of(strtoupper($x));
		})
		->extract();

	expect($result[0])->toBeInstanceOf(Maybe::class);
	expect($result[1])->toBeInstanceOf(Maybe::class);
	expect($result[2])->toBeInstanceOf(Maybe::class);
});

it('binds correctly', function() {
	$result = Many::of(["a", "b", "c"])
		->bind(function($x) {
			return Maybe::of(strtoupper($x));
		})
		->extract();

	expect($result)->toBe(["A", "B", "C"]);
});
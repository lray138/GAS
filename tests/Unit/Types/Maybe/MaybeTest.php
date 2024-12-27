<?php 

class Demo
{
    public string $name;
    public int $count;

    public function __construct(string $name = '', int $count = 0)
    {
        $this->name = $name;
        $this->count = $count;
    }

    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public function subtract(int $a, int $b): int
    {
        return $a - $b;
    }

    public function incrementCount(): void
    {
        $this->count += 1;
    }
}

use lray138\GAS\Types\Maybe;
use lray138\GAS\Types\Maybe\Just;

it("constructs a new maybe object", function() {
	$maybe = (new Maybe());
	expect($maybe)->toBeInstanceOf(Maybe::class);
});

// I updated this on Dec 10, 2024 because I was previously allowing 
// it to be called without a value, but I changed the code and didn't test.
it("is a pointed functor", function() {
	$maybe = Maybe::of('string');
	expect($maybe)->toBeInstanceOf(Maybe::class);
	//expect($maybe)->toBeInstanceOf(Just::class);
});
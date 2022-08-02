<?php namespace lray138\GAS\Types\Functor;

class IdentityFunctor implements PointedFunctor 
{
	private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public static function of($value): Functor {
    	return new static($value);
    }

    public function map(callable $fn): Functor {
        return new static($fn($this->value));
    }

    public function extract() {
        return $this->value;
    }

}
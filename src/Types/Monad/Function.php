<?php namespace lray138\GAS\Types\Monad;

// seems like it's probably PacktPHP code

use FunctionalPHP\FantasyLand\{
	Monoid
	, Semigroup 
};

class Function implements Monoid
{
    private $value;
    
    public function __construct($s) {
        $this->value = $s;
    }

    public static function mempty() {
        return '';
    }

    public function get() {
        return $this->value;
    }

    public function concat(Semigroup $value): Semigroup {
        return new static($this->get() . $value->get());
    }
}
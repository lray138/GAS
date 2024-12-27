<?php 

namespace lray138\GAS\Types;

use lray138\GAS\Numbers;
use lray138\GAS\Types as T;
use function lray138\GAS\dump;

use FunctionalPHP\FantasyLand\{
	Functor,
	Monoid,
	Semigroup
};

use lray138\GAS\Traits\{ExtractValueTrait, MapTrait, ChainTrait};
use function lray138\GAS\Functional\extract;

// the reason for using the "Numbers" function is that it 
// will handle type unwrapping which I suppose... 
// I'm on the fence a little but... it's suppose to be a 
// system in that regard, i.e. they should work together
// the idea is if you interact via a "GAS" Type you get a type back
// if you interact via a "Native" type you get that back.

class Number extends Type implements Monoid {

	const of = __CLASS__ . '::of';

	protected $value;
	protected $operation;

	// originally casted this to float based on Chris Pitt, but now will
	// do what I'm doing with G2 version and force a number... 
	public function __construct($value, $operation = "add") {
		if(!is_numeric($value)) {
			throw new \InvalidArgumentException('Expected an iterable or traversable value');
		}
		
		$this->value = $value;
		$this->operation = $operation;
	}

	use MapTrait;
	use ExtractValueTrait;
	use ChainTrait;

	public static function mempty($operation = null) {
		$operation = is_null($operation) ? "add" : $operation;
		$value = $operation === "add" ? 0 : 1;
        return new self($value, $operation);
    }

    public function concat(Semigroup $n): Number {
        if ($this->operation === 'add') {
            return new self($this->extract() + $n->extract(), $this->operation);
        } else if ($this->operation === 'mul') {
            return new self($this->extract() * $n->extract(), $this->operation);
        }

        throw new \Exception("Unknown operation"); // chatGPT
    }

	public function __toString() {
		return (string) $this->value;
	}

	public function add(float|int|Number $n): Number {
		return $n instanceof Number 
			? new self($this->extract() + $n->extract())
			: new self($this->extract() + $n);
	}

	// @note this should be equals
	// this is dumb and should be ... yeah equals below would make sense... 
	public function is($number) {
		return $this->value == $number;
	}

	// keeping the relaxed "==" here 
	public function equals($number) {
		return $this->extract() == $number;
	}

	public function eq($number) {
		return $this->equals($number);
	}

	public function divide($number) {
		return new self($this->value / $number);
	}

	public function divideBy($number) {
		return $this->divide($number);
	}

	public function div($number) {
		return $this->divide($number);
	}

	public function multiply($x) {
		return new self($this->extract() * $x);
	}

	public function roundTo($decimals) {
		return new self(\round($this->extract(), $decimals));
	}

	public function format($decimals) {
		return T\Str(\number_format($this->extract(), $decimals));
	}

	public function isGreaterThan($number) {
		return $number instanceof self
			? T\Boolean($this->extract() > $number->extract())
			: T\Boolean($this->extract() > $number);
	}

	public function gt($number) {
		return $this->isGreaterThan($number);
	}

	public function isLessThan($number) {
		return $number instanceof self
			? T\Boolean($this->extract() > $number->extract())
			: T\Boolean($this->extract() > $number);
	}

	public function lt($number) {
		return $this->isLessThan($number);
	}

	public function bind($callable) {
		return $callable($this->extract());
	}

	// don't like this voodoo (2024-10-08 )
	public function __call($method, $args) {
		if(function_exists("\lray138\GAS\Numbers\\$method")) {
			$func = "\lray138\GAS\Numbers\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		} 
	}

}
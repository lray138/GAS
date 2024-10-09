<?php namespace lray138\GAS\Types;

use lray138\GAS\Numbers;
use lray138\GAS\Types as T;
use function lray138\GAS\dump;

use FunctionalPHP\FantasyLand\{Semigroup, Monoid};
use lray138\GAS\Traits\MapTrait;

use lray138\GAS\Types\NumberG2 as Num;
use lray138\GAS\Types\StrTypeG2 as StrType;
use lray138\GAS\Types\Boolean;

// the reason for using the "Numbers" function is that it 
// will handle type unwrapping which I suppose... 
// I'm on the fence a little but... it's suppose to be a 
// system in that regard, i.e. they should work together
// the idea is if you interact via a "GAS" Type you get a type back
// if you interact via a "Native" type you get that back.

class NumberG2 extends Type implements Monoid {

	const of = __CLASS__ . '::of';

	protected $value;
	protected $operation;

	public function __construct($value, StrType $operation = null) {
		if(!is_numeric($value)) {
			die("pass a number");
		}

		$this->value = $value;
		$this->operation = is_null($operation) ? "add" : $operation->extract();
	}

	public static function of($value, StrType $operation = null) {
        return new self($value, $operation);
    }

	use MapTrait;

	public static function mempty(StrType $operation = null) {
		$operation = is_null($operation) ? StrType::of("add") : $operation;
        return new self($operation->extract() === "add" ? 0 : 1, $operation);
    }

	public function concat(Semigroup $n): Num {
        if ($this->operation === 'add') {
            return new self($this->extract() + $n->extract(), StrType::of($this->operation));
        } else if ($this->operation === 'mul') {
            return new self($this->extract() * $n->extract(), StrType::of($this->operation));
        }

        throw new \Exception("Unknown operation"); // chatGPT
    }

    public function getOperation() {
    	return StrType::of($this->operation);
    }

    public function setOperation(StrType $s) {
    	$this->operation = $s->extract();
    }

	public function __toString() {
		return (string) $this->value;
	}

	public function add(Num $number) {
		return new self($this->extract() + $number->extract());
	}

	// keeping the relaxed "==" here 
	// but I did that because of Num being cast to float... but... hermmm.....
	// this is all Oct 8 2024 it's 22:36
	public function equals(Num $number) {
		return Boolean::of($this->extract() == $number->extract());
	}

	public function eq(Num $number) {
		return $this->equals($number);
	}

	public function divide(Num $number) {
		return new self($this->value / $number);
	}

	public function divideBy(Num $number) {
		return $this->divide($number);
	}

	public function div(Num $number) {
		return $this->divide($number);
	}

	public function multiply(Num $x) {
		return new self($this->extract() * $x->extract());
	}

	public function mult(Num $x) {
		return $this->multiply($x);
	}

	public function roundTo(Num $decimals) {
		return new self(\round($this->extract(), $decimals));
	}

	public function round(Num $demicals) {
		return $this->roundTo($decimals);
	}

	public function format($decimals) {
		return T\Str(\number_format($this->extract(), $decimals));
	}

	public function isGreaterThan($number) {
		return $number instanceof self
			? T\Boolean($this->extract() > $number->extract())
			: T\Boolean($this->extract() > $number);
	}

	// don't like this voodoo (2024-10-08 )
	public function __call($method, $args) {
		if(function_exists("\lray138\GAS\Numbers\\$method")) {
			$func = "\lray138\GAS\Numbers\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		} 
	}

}
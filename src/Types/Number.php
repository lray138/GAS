<?php 

namespace lray138\GAS\Types;

use lray138\GAS\Numbers;
use lray138\GAS\Types as T;
use function lray138\GAS\dump;

// the reason for using the "Numbers" function is that it 
// will handle type unwrapping which I suppose... 
// I'm on the fence a little but... it's suppose to be a 
// system in that regard, i.e. they should work together
// the idea is if you interact via a "GAS" Type you get a type back
// if you interact via a "Native" type you get that back.

class Number extends Type {

	const of = __CLASS__ . '::of';

	protected $value;

	public function __construct($value) {
		$this->value = is_numeric($value) 
			? (float) $value 
			: 0;
	}

	public function extract() {
		return $this->value;
	}

	public function __toString() {
		return (string) $this->value;
	}

	public function add($number) {
		return new self(Numbers\add($this->value, $number));
	}

	public function is($number) {
		return $this->value == $number;
	}

	public function divide($number) {
		return new self(Numbers\divide($number, $this->value));
	}

	public function divideBy($number) {
		return new self(Numbers\divide($this->value, $number));
	}

	public function getOr($other) {
		return $this->value;
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

	public function __call($method, $args) {
		if(function_exists("\lray138\GAS\Numbers\\$method")) {
			$func = "\lray138\GAS\Numbers\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		} 
	}

}
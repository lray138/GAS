<?php 

namespace lray138\GAS\Types;

use lray138\GAS\Numbers;
use function lray138\GAS\dump;

// the reason for using the "Numbers" function is that it 
// will handle type unwrapping which I suppose... 
// I'm on the fence a little but... it's suppose to be a 
// system in that regard, i.e. they should work together
// the idea is if you interact via a "GAS" Type you get a type back
// if you interact via a "Native" type you get that back.

class Number extends Type {

	protected $value;
	
	// public static function of($value) {
	// 	return new self($value);
	// }

	public function __construct($value) {
		$this->value = $value;
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
		return new self(Numbers\divide($this->value, $number));
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
		return new self(\number_format($this->extract(), $decimals));
	}

}
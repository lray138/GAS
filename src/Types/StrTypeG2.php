<?php

namespace lray138\GAS\Types;

use FunctionalPHP\FantasyLand\Functor;
use lray138\GAS\Traits\MapTrait;

use FunctionalPHP\FantasyLand\{Semigroup, Monoid};

use lray138\GAS\Types\StrTypeG2 as StrType;
use lray138\GAS\Types\ArrTypeG2 as ArrType;

use lray138\GAS\{
	Str as S
	, Functional as FP
};

use function lray138\GAS\IO\dump;

class StrTypeG2 extends Type implements Monoid, Semigroup {

	const of = __CLASS__ . '::of';

	// cast it to string if it isn't
	public function __construct($value) {
		if(!is_string($value)) {
			$this->value = (string) $value;
		} else {
			$this->value = $value;
		}
	}

	public function explode(StrType $delimeter): ArrType {
		return ArrType::of(S\explode($delimeter, rtrim($this->value, $delimeter)));
	}

	public static function mempty() {
		return new self("");
	}

	// this is the function that leads towards going with types in general I'd say
	public function concat(Semigroup $x): StrType {
		return new self($this->extract() . $x);
	}

	// this is where we were doing some cross whatever Voodoo
	// and you can get away with a lot using "map"
	public function __call($method, $args) {
		if(function_exists("\lray138\GAS\Str\\$method")) {
			$func = "\lray138\GAS\Str\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		} 
	}

	public function __toString() {
		return $this->value;
	}

	use MapTrait;

	public function append($x) {
		//return new self(S\concatN(count(func_get_args()), $this->value, ...func_get_args()));
		$value = $this->value . $x;
		return new self($value);
	}

	public function prepend($value) {
		return new self(S\prepend($value, $this->value));
	}

	public function value() {
		return $this->value;
	}

	public function out() {
		return $this->value;
	}

	public function wrap($a, $b) {
		$val = $a . $b;
		return new self($a . $b);
	}

	public function length() {
		return Number::of(S\length($this->value));
	}

	public function isEmpty() {
		return empty($this->value);
	}

	public function isNotEmpty() {
		return !empty($this->value);
	}

	// not sure why this is here and the next couple .
	public function isLeft() {
		return false;
	}

	public function isString() {
		return true;
	}

	public function toNothingIfEmpty() {
		return empty($this->extract()) ? Nothing::of() : $this;
	}

}
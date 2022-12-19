<?php

namespace lray138\GAS\Types;

use lray138\GAS\{
	Str as S
	, Functional as FP
};

use function lray138\GAS\IO\dump;

class StrType extends Type {

	const of = __CLASS__ . '::of';

	public function explode(string $delimeter) {
		return ArrType::of(S\explode($delimeter, rtrim($this->value, $delimeter)));
	}

	public function __construct($value) {
		if(!is_string($value)) {
			$this->value = "";
		} else {
			$this->value = $value;
		}
	}

	public function concat($x) {
		return new self($this->extract() . $x);
	}

	public function __call($method, $args) {
		if(function_exists("\lray138\GAS\Str\\$method")) {
			$func = "\lray138\GAS\Str\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		} 
	}

	public function __toString() {
		return $this->value;
	}

	public function map(callable $f) {
		return new self($f($this->value));
	}

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
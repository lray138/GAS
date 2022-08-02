<?php

namespace lray138\GAS\Types;

use lray138\GAS\{Str as S, Functional as FP};
use function lray138\GAS\IO\dump;

class StrType extends Type {
	// weird early version of this I suppose... 
	// public function explode(string $delimeter) {
	// 	return ArrType::of(S\explode($delimeter, rtrim($this->value, $delimeter)))->map("\\lray138\\GAS\\Types\\StrType::of");
	// }

	public function explode(string $delimeter) {
		return ArrType::of(S\explode($delimeter, rtrim($this->value, $delimeter)));
	}

	// public static function of($value) {
	// 	return new self($value);
	// }

//	const of = __NAMESPACE__ . '\Str::of'; was this here because of copy and paste.

	public function __construct($value) {
		if($value instanceof self) {
			$value = $value->extract();
		}

		if(is_array($value)) {
			$value = implode($value);
		}

		if(!is_string($value)) {
			$value = (string) $value;
		}

		$this->value = $value;
	}

	public function concat($str) {
		return new self($this->value . $str);
	}

	public function trim($str) {
		return new self(trim($this->value, $str));
	}

	public function __toString() {
		return $this->value;
	}

	public function replace($find, $replace) {
		return new self(S\replace($find, $replace, $this->value));
	}

	public function map(callable $f) {
		//return new self($f($this->value));
		return wrap($f($this->value));
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
		//return new self(FP\compose(S\prepend($a), S\append($b))($this->value));
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

	public function rtrim($delimeter = "") {
		return new self(rtrim($this->value, "/"));
	}

	public function isString() {
		return true;
	}

	public function toNothingIfEmpty() {
		return empty($this->extract()) ? Nothing::of() : $this;
	}

}
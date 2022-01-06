<?php

namespace lray138\GAS\Types;

use lray138\GAS\{Str as S, Functional as FP};
use function lray138\GAS\IO\dump;

class StrType extends Type {
	
	public function explode(string $delimeter) {
		return Arr::of(S\explode($delimeter, rtrim($this->value, $delimeter)))->map("\\GAS\\Types\\Str::of");
	}

	public static function of($value) {
		return new self($value);
	}

	const of = __NAMESPACE__ . '\Str::of';

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

	public function __toString() {
		return $this->value;
	}

	public function replace($find, $replace) {
		return new self(S\replace($find, $replace, $this->value));
	}

	public function map(callable $f) {
		return new self($f($this->value));
	}

	public function append($x) {
		//return new self(S\concatN(count(func_get_args()), $this->value, ...func_get_args()));
		$value = $x . $this->value;
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

	public function extract() {
		return $this->value;
	}

	public function length() {
		return Number::of(S\length($this->value));
	}

	public function isEmpty() {
		return empty($this->value);
	}

	public function rtrim($delimeter = "") {
		return new self(rtrim($this->value, "/"));
	}

}
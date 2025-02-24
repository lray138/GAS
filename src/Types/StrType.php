<?php

namespace lray138\GAS\Types;

use function lray138\GAS\IO\dump;

use FunctionalPHP\FantasyLand\{Monoid, Functor, Semigroup, Monad};
use lray138\GAS\Traits\{ExtractValueTrait, MapTrait};

use lray138\GAS\{
	Str as S
	, Functional as FP
};

class StrType extends Type implements Functor, Monoid {

	const of = __CLASS__ . '::of';

	public function explode(string $delimeter) {
		return ArrType::of(S\explode($delimeter, rtrim($this->value, $delimeter)));
	}

	public static function mempty() {
		return new static("");
	}

	public function concat(Semigroup $m): StrType {
		return new static($this->extract() . $m->extract());
	}

	public function trim() {
		return new static(trim($this->extract()));
	}

	// cast it to string if it isn't
	public function __construct($value) {
		if(!is_string($value)) {
			$this->value = (string) $value;
		} else {
			$this->value = $value;
		}
	}

	public function charAt($index) {
		return new static(mb_substr($this->extract(), $index, 1, "UTF-8"));
	}

	public function substr($from, $length = null) {
		return new static(substr($this->extract(), $from, $length));
	}

	public function mbSubstr($from, $length = null) {
		return new static(mb_substr($this->extract(), $from, $length, "UTF-8"));
	}

	// public function concat($x) {
	// 	return new self($this->extract() . $x);
	// }

	// this was already in place, nice... Jan 27 2015 wow 
	// Jan 27 2025 
	public function getOrElse($val) {
		$stored = $this->extract();
		if(is_null($stored) || empty($stored)) {
			return $val;
		}
		return $stored;
	}

	public function goe($val) {
		return $this->getOrElse($val);
	}

	// ok, this is borderline and I don't really like it, but I'm here because I needed 
	// an either function... and ... since I wasn't returning anything on fail
	// it took me a minute to realize what was going on.
	public function __call($method, $args) {
		if(function_exists("\lray138\GAS\Str\\$method")) {
			$func = "\lray138\GAS\Str\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		} else if(function_exists($method)) {
			return new self(call_user_func_array($method, [...$args, $this->extract()]));
		} else {
			return \lray138\GAS\Types\Either::left("method '$method' not found");
		}
	}

	public function __toString() {
		return $this->value;
	}

	use MapTrait;
	use ExtractValueTrait;

	public function append($x) {
		//return new self(S\concatN(count(func_get_args()), $this->value, ...func_get_args()));
		$value = $this->value . $x;
		return new self($value);
	}

	public function contains($x) {
		return \lray138\GAS\Types\Boolean(str_contains($this->extract(), $x));
	}

	// this is dum Jan 16, 2024 - 11:30
	public function add($x) {
		return $this->append($x);
	}

	public function padZero() {
		return new self(sprintf('%02d', $this->extract()));
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
		return new self($a . $this->extract() . $b);
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

	public function isLeft() {
		return false;
	}

	public function isString() {
		return true;
	}

	public function toNothingIfEmpty() {
		return empty($this->extract()) ? Nothing::of() : $this;
	}

	// cool Jan 24, 2024
	public function either($_, callable $f) {
		return $f($this->extract());
	}

}
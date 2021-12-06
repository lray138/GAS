<?php 

namespace GAS\Monads;

use GAS\Functions\Arr as A;

class Arr {
	private $value;

	public function __construct($value = null) {
		// if(is_object($value) && $value instanceof static) {
		// 	$value = $value->value();
		// }

		$this->value = $value;
	}

	public function within(callable $func) {
        return $this->then(function($value) use ($func) {
            return static::new($func($value));
        });
    }

	public static function new(...$args) {
		return new static(...$args);
	}

	public function out() {
		return $this->value;
	}

	public static function of($x) {
		return new self($x);
		//return new static($x);
	}

	function implode() {
		return $this->then(A\implode(""));
	}

	public function map(callable $f) {
		return $this->then(A\map($f));
	}

	public function __call($method, $parameters) {
		return $this->then(function($value) use ($method) {
			if(is_array($value)) {
				return isset($value[$method]) ? $value[$method] : null;
			} elseif(is_object($value)) {
				return isset($value->$method) ? $value->$method : null;
				// above was commented out at one point but
				// not sure why
				//return $value->$method;
			} 
		});
	}

	private function isNothing() {
		return is_null($this->value);
	}

	public function getOrElse($default_value) {
		return $this->isNothing() ? $default_value : $this->value;
	}

	// public function map($fn) {
	// 	return $this->then($fn);
	// }

	public function bind($fn) {
		return $this->then($fn);
	}

	public function join() {
		return $this->extract();
	}

	public function __get($property) {
		return $this->$property();
	}

	public function chain($fn) {
		return $this->map($fn)->join();
		//$this->value->map($fn)->flatten();
		//return $this->map($fn)->join();
	}

	public function index($index) {
		$value = isset($this->value[$index]) 
					? $this->value[$index]
					: null;

		return new self($value);
	}

	public function then(callable $func) {

		// this fails for empty arrays before with
		// just ($this->value)
		if(is_null($this->value)) {
			return static::new();
		}

		return static::new($func($this->value));
	}

	public function toMany() {
		return Many::of($this->value);
	}

	public function flatMap($fn) {
		if($this->value) {
			return $this->flatten()->map($fn);
			//return new Maybe($fn($this->value->value));
		}
		return new Maybe();
	}

	public function flatten() {
		return $this->value;
	}

	public function extract() {
		return $this->value;
	}

	public function value() {
		return $this->value;
	}

	private function getProperty($property) {
		$prop = $this->$property();
		return $prop instanceof self ? $prop->extract() : $prop;
	}

	public function toArr() {
		return !$this->isNothing() ? \GAS\Types\Arr::of($this->value) : null;
	}

	public function get($property = null) {
		return !is_null($property) 
					? $this->getProperty($property)
					: $this->value;
	}
}
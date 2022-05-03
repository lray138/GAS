<?php

namespace lray138\GAS\Types;

use function lray138\GAS\dump;

class Type {

	protected $value;

	// constructors
	public function __construct($value = null) {
		$this->value = $value;
	}

	public static function of($value) {
		// return new self($value) returns Type, whereas we want the subclass
		return new static($value);
	}

	// extract methods
	public function extract() {
		return $this->value;
	}

	public function out() {
		return $this->extract();
	}

	public function toArr($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->value)
					: $this->value;

		if(!is_array($this->value)) {
			$value = [$value];
		}

		return ArrType::of($value);
	}

	public function toNumber($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->value)
					: $this->value;

		// for now return the value, maybe in future return 
		// error or something
		if(!isNumber($value)) {
			echo "Nah $value";
			return $this;
		}

		return Number::of($value);
	}

	public function toMaybe($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->extract())
					: $this->extract();

		return Maybe::of($value);
	}

	// probably should return null??? dunno
	public function if($bool_or_callable, $callable_or_value) {
		
		$out = function() use ($bool_or_callable, $callable_or_value) {
			return is_callable($callable_or_value)
				? $callable_or_value($this)
				: $callable_or_value;
		};

		if(is_callable($bool_or_callable)) {
			if($bool_or_callable($this)) {
				return $out();
			}
			
			return $this;
		} else if($bool_or_callable) {
			return $out();
		}	

		return $this;
	}

	public function toDateTime() {
		return new \DateTime($this->value);
	}

	public function bind($callable) {
		return new self($callable($this->value));
	}


	public function chain($callable) {
		return (new self($callable($this->value)))->extract();
	}

	public function toStr($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->extract())
					: $this->extract();

		return StrType::of($value);
	}

	public function isNothing() {
		return false;
	}

}
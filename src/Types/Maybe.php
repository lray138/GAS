<?php 

namespace lray138\GAS\Types;

class Maybe extends Functor {

	public function within(callable $func) {
        return $this->then(function($value) use ($func) {
            return static::new($func($value));
        });
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

	public function join() {
		return $this->extract();
	}

	// public function runClosure() {
	// 	return new self(call_user_func_array($this->value, func_get_args()));
	// }

	// I was calling this wrong anyway, would be interesting case for NoMethod type though since
	// I was trying to call "runCallback", but decided it was mayne not technically a "callback"

	public function exec() {
		if(is_callable($this->value)) {
			return new self(call_user_func_array($this->value, func_get_args()));
		}

		return None::of();
	}

	// or "run"?
	public function run() {
		if(is_callable($this->value)) {
			return new self(call_user_func_array($this->value, func_get_args()));
		}

		return None::of();
	}

	public function apply($f) {
		// I suppose if you use the extract function
		// the variable can be whatever, but I would 
		// lean toward just doing $this->value
        return $f->map($this->extract());
    }

    public function applyM($applicative) {
    	return $this->map($applicative->extract());
    	//return $applicative->apply($this);
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

	public function map($func) {
		return $this->then($func);
	}

	public function bind($func) {
		return $this->then($func);
	}

	// need to allow null to be passed in the case of a 
	// apply where the file is not located
	public function then($func) {

		// this fails for empty arrays before with
		// just ($this->value)

		// if(is_null($this->value)) {
		// 	return static::new();
		// }

		// return static::new($func($this->value));

		if(is_null($this->value)) {
			return new self();
		} elseif(is_null($func)) {
			return new self();
		}

		return new self($func($this->value));

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

	public function __construct($value = null) {
		// this is where the auto-unwrapping seems not correct???
		// if(is_object($value) && $value instanceof static) {
		// 	$value = $value->value();
		// }

		if(is_object($value) && $value instanceof \GAS\Types\None) {
			$value = $value->value();
		}

		$this->value = $value;
	}

	public static function of($x) {
		return new self($x);
	}

	public static function unit($x) {
		return new self($x);
	}

	public function extract() {
		return $this->value;
	}

	public function out() {
		return $this->value;
	}
}
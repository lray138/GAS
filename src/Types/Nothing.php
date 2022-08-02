<?php 

namespace lray138\GAS\Types;

class Nothing extends Maybe {
	
	protected $value = null;

	public function value() { }

	public static function of($value = null): Maybe {
		return new self();
	}

	// flagged for its use in \lray138\GAS\HTML generation 
	public function __toString() {
		return "";
	}

	public function __call($method, $args) {
		return $this;
	}

	public function __get($property) {
		return $this;
	}

	// wonder if I created this before the "call" method
	public function map(callable $f): Maybe {
		return $this;
	}

	public function apply($f): Maybe {
		return $this;
	}

	public function extract() {
		return $this->value;
	}

	public function isNothing() {
		return true;
	}

	public function is() {
		return false;
	}

	public function isNot() {
		return true;
	}

	public function isStr() {
		return false;
	}

}
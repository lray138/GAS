<?php 

namespace lray138\GAS\Types;

// bad extension
class Nothing {
	
	protected $value = null;

	public function value() { }

	public static function of($value = null) {
		return new self();
	}

	// for use in HTML generation
	public function __toString() {
		return "";
	}

	public function __call($method, $args) {
		return $this;
	}

	public function __get($property) {
		return $this;
	}

	public function map() {
		return $this;
	}

	public function extract() {
		return $this->value;
	}

	public function isNothing() {
		return true;
	}

}
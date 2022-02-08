<?php 

namespace lray138\GAS\Types;

class None extends Type {
	
	protected $value = null;

	public function extract() {
		return $this->value;
	}

	public function value() {
		return $this->value;
	}

	public static function of($value = null) {
		return new self();
	}

	// for use in HTML generation
	public function __toString() {
		return "";
	}

	public function __call($method, $args) {
		return $this->value;
	}

}
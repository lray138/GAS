<?php 

namespace lray138\GAS\Types;

class None {
	
	private $value = null;

	public function extract() {
		return $this->value;
	}

	public function value() {
		return $this->value;
	}

	public static function of() {
		return new self();
	}

	public function __get($val) {
		echo "val";	
	}

	public function __call($method, $args) {
		return new self();
	}

	// for use in HTML generation
	public function __toString() {
		return "";
	}

}
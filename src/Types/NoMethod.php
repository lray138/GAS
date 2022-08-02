<?php 

namespace lray138\GAS\Types;

/* 
	Wondering if this is me experimenting or code from Typed PHP
*/

class NoMethod extends Type {
	
	protected $value;

	// public static function of($value) {
	// 	return new self($value);
	// }

	public function extract() {
		return $this->value;
	}

	public function value() {
		return $this->value;
	}

	public function __call($method, $args) {
		return $this;
	}

	public function __get($property) {
		return $this;
	}
	
	public function __construct($value) {
		$this->value = $value;
	}

}
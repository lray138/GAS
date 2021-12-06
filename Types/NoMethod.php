<?php 

namespace lray138\GAS\Types;

class NoMethod {
	
	private $value;

	public static function of($value) {
		return new self($value);
	}

	public function extract() {
		return $this->value;
	}

	public function value() {
		return $this->value;
	}

	public function __call($method, $args) {
		
	}
	
	public function __construct($value) {
		$this->value = $value;
	}

}
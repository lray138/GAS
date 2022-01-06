<?php 

namespace lray138\GAS\Types;

class Number extends Type {

	private $value;
	
	public static function of($value) {
		return new self($value);
	}

	public function __construct($value) {
		$this->value = $value;
	}

	public function extract() {
		return $this->value;
	}

}
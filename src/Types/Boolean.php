<?php

namespace lray138\GAS\Types;

class Boolean extends Type {

	protected $value;

	public function __construct($value) {
		$this->value = $value;
	}

	public static function of($value = null) {
		return new self($value);
	}

	public function is() {
		return $this->value === true;
	}

	public function isNot() {
		return $this->value === false;
	}

	/**
	 * 
	 */ 
	public function isTrue() {
		return $this->is();
	}

}
<?php

namespace lray138\GAS\Types;

class Boolean {

	private $value;

	public function __construct($value) {
		$this->value = $value;
	}

	public static function of($value) {
		return new self($value);
	}

	public function is() {
		return $this->value === true;
	}

	public function isNot() {
		return $this->value === false;
	}

}
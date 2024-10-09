<?php

namespace lray138\GAS\Types;

class Boolean extends Type {

	protected $value;

	public function __construct($value) {
		$this->value = $value;
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


	public function isFalse() {
		return $this->extract() === false;
	}

}
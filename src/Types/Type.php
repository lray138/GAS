<?php

namespace lray138\GAS\Types;

class Type {

	protected $value;

	// constructors
	public function __construct($value) {
		$this->value = $value;
	}

	public static function of($value) {
		// return new self($value) returns Type, whereas we want the subclass
		return new static($value);
	}

	// extract methods
	public function extract() {
		return $this->value;
	}

	public function out() {
		return $this->extract();
	}



}
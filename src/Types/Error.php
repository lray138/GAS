<?php 

namespace lray138\GAS\Types;

class Error {
	
	protected $value;

	public static function of($value) {
		return new self($value);
	}

	public function __construct($value) {
		$this->value = $value;
	}

	public function map() {
		return  $this;
	}

	public function __call($method, $args) {
		return $this;
	}

	public function bind() {
		return $this;
	}

	public function __toString() {
		return $this->value;
	}

}
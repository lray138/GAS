<?php 

namespace lray138\GAS\Types;

class Left {
	
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

	public function getOrElse($value) {
		return $value;
	}
	
	public function goe($value) {
		return $this->getOrElse($value);
	}

}
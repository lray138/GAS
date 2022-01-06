<?php 

namespace lray138\GAS\Types;

use function lray138\GAS\dump;

class Functor extends Type {

	public function bind($fn) {
		return new static($fn($this->value));
	}

	public function map($fn) {
		return $this->bind($fn);
	}

}
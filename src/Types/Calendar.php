<?php

namespace lray138\GAS\Types;

use lray138\GAS\{
	Arr 
	, Str as S
	, Functional as FP
	, Calendar as Cal
};

use function lray138\GAS\IO\dump;

// something about array too, right?
// and implements for the map
// as yes,,, extends ArrType ?
class Calendar extends Type {

	public function mapDay($callable) {
		return Arr\map($callable);
	}

	public function __construct() {
		$this->value = Cal\create();
	}

	public function map($callable) {
		return Arr\map($callable, $this->value);
	}

}
<?php namespace lray138\GAS\Types\Maybe;

use lray138\GAS\Types\Maybe;

class Just extends Maybe {

	public static function of($value): Just {
		return new static($value);
	}

}
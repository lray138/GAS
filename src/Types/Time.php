<?php 

namespace lray138\GAS\Types;

use function lray138\GAS\dump;
use lray138\GAS\Types as T;

// https://www.php.net/manual/en/datetime.format.php

class Time extends Type {

	public function getD() {
		return $this->value->format("j");
	}

	public function getDD() {
		return T\Str($this->value->format("d"));
	}

	public function getDDD() {
		return $this->value->format("D");
	}

	public function getDDDD() {
		return $this->value->format("l");
	}

	public function getYear() {
		return $this->value->format("Y");
	}

	public function getYY() {
		return T\Str($this->value->format("y"));
	}

	public function getYYYY() {
		return T\Str($this->getYear());
	}

	// get full month 
	public function getMMMM() {
		return $this->value->format("F");
	}

	public function getMonth() {
		return $this->value->getMMMM();
	}

	// get month three digits
	public function getMMM() {
		return StrType::of($this->value->format("M"));
	}

	// get month num with leading zero
	public function getMM() {
		return T\wrap($this->value->format("m"));
	}

	// return month num no leading zero
	public function getM() {
		return T\wrap($this->value->format("n"));
	}

	public function isLeapYear() {
		return T\wrap($this->value->format("L") === 1);
	}

	public function getHH($format = 12) {
		
	}

	public function getH($format = 12) {
		
	}

	public function getLastDayOfMonth() {
		$clone = clone $this->value;
		return (new self($clone->modify('last day of')))->setTime(23, 59, 59, 59);
	}

	public function getFirstDayOfMonth() {
		$clone = clone $this->value;
		return new self($clone->modify('first day of'));
	}

	public function formatMySQL() {
		return $this->value->format('Y-m-d H:i:s');
	}

	public function __construct($datetime = null) {
		// if($datetime instanceof \Moment\Moment || $datetime instanceof \Moment\MomentFromVo) {
		// 	$m = $datetime;
		// } else {
		// 	if(is_null($datetime)) {
		// 		$datetime = new \DateTime();
		// 	} else if(is_string($datetime)) {
		// 		$datetime = new \DateTime($datetime);
		// 	} else if(is_int($datetime)) {
		// 		$datetime = (new \DateTime())->setTimestamp($datetime);
		// 	}
		// 	$m = new \Moment\Moment($datetime->format("Y-m-d H:i:s"));
		// }

		if(is_null($datetime)) {
			$datetime = new \DateTime();
		} else if(is_string($datetime)) {
			$datetime = new \DateTime($datetime);
		} else if(is_int($datetime)) {
			$datetime = (new \DateTime())->setTimestamp($datetime);
		}

		$this->value = $datetime;
	}

	public function format($format) {
		return $this->value->format($format);
	}

	public function __call($method, $args) {
		if(method_exists($this->value, $method)) {
			return T\wrapType($this->value->$method(...$args));
		}
	}

}
<?php 
namespace lray138\GAS\Monads;

use lray138\GAS\Arr;
use lray138\GAS\Monads\Maybe;

use function lray138\GAS\IO\dump;

class Many {
	private $values;

	public function __construct($values = null) {
		// here they auto unwrap
		// and this was throwing me off when I tried to use chain

		// if(is_object($values) && $values instanceof static) {
		// 	$values = $values->value();
		// }
	
		$this->values = $values;
	}

	public function within(callable $func) {
        return $this->then(function($value) use ($func) {
            return static::create($func($value));
        });
    }

	public static function create($args) {
		// return new static did not work
		return new Many($args);
	}

	public static function of($args) {
		// return new static did not work
		return new Many($args);
	}

	public function __get($prop) {
		return $this->map(function($x) use ($prop) {
			return isset($x[$prop]) ? $x[$prop] : null;
		});
	}

	public function then(callable $mapper) {
		return static::create(flatMap($this->values, $mapper));
	}

	public function map(callable $mapper) {
		$out = [];
		foreach($this->values as $value) {
			$out[] = $mapper($value);
		}

		return static::create($out);

	}

	public function bind($func) {
		$out = [];
		foreach($this->values as $value) {
			$out[] = $func($value);
		}

		return static::create($out);
	}

	public function flatten() {
		return $this->values;
	}

	public function chain(callable $function) {
		return $this->map($function)->flatten();
	}

	function toMaybe() {
		$tmp = Maybe::of($this->values);
		return $tmp;
	}

	function toArr() {
		return Arr::of($this->values);
	}

	public function value() {
		return $this->values;
	}

	public function extract() {
		return $this->values;
	}
}
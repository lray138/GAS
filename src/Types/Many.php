<?php 

namespace lray138\GAS\Types;
use lray138\GAS\Types\Maybe;
use function lray138\GAS\IO\dump;
use FunctionalPHP\FantasyLand\Functor;

class Many extends Type {

	public const of  = __CLASS__ . '::of';
	
	private $values;

	public function __construct($values) {
		// here they auto unwrap
		// and this was throwing me off when I tried to use chain

		// if(is_object($values) && $values instanceof static) {
		// 	$values = $values->value();
		// }

		if (!is_iterable($values) && !$values instanceof \Traversable) {
        	throw new \InvalidArgumentException('Expected an iterable or traversable value');
    	}

    	if (!is_array($values)) {
        	$values = iterator_to_array($values);
    	}
	
		$this->values = $values;
	}

	public function within(callable $func) {
        return $this->then(function($value) use ($func) {
            return static::create($func($value));
        });
    }

	public static function create($args) {
		// return new static did not work
		// Oct 11 2024 - I'm not sure why I thought that.
		return new static($args);
		//return new Many($args);
	}

	// this was commented out, wonder why.
	public static function of($args) {
		// return new static did not work
		return new Many($args);
	}

	public function __get($prop) {
		return $this->map(function($x) use ($prop) {
			return isset($x[$prop]) ? $x[$prop] : null;
		});
	}

	// this was before I learned about Comonad and "extend"
	// obviously not even working
	public function to($type) {
		return $this->value;
		return $type($this->value);
	}

	public function then(callable $mapper) {
		return static::create(flatMap($this->values, $mapper));
	}

	public function map(callable $f): Many {
		$out = [];
		foreach($this->values as $value) {
			$out[] = $f($value);
		}

		return static::create($out);
	}

	public function bind($func): Many {
		$out = [];
		foreach($this->values as $value) {
			$result = $func($value);
			$out[] = $result->extract();
		}

		return static::create($out);
	}

	public function flatten() {
		return $this->values;
	}

	public function chain($function) {
		return $this->map($function)->flatten();
	}

	public function value() {
		return $this->values;
	}

	// dunno why this just came to me as a way to handle the type conversion
	// but it did... May 2, 2023 @ 16:22
	// just smirked after running it... hmm....
	// ---
	// and so OCT 10 2024 - we discovered extend...
	public function extract($callable = null) {
		return is_null($callable) ? $this->values : $callable($this->values);
	}

	// looking at above and that's not great be... well, it could be but is more like "clear vs clever"
}
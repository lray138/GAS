<?php namespace lray138\GAS\Types;

use \FunctionalPHP\FantasyLand\Monad;
use lray138\GAS\Traits\ApplyTrait;
use lray138\GAS\Types\Maybe\{Just, Nothing};
use function lray138\GAS\Types\{getType, wrapType};

class Maybe implements Functor\PointedFunctor, Comonad, Monad {

	public const of  = __CLASS__ . '::of';

	protected $value;

	public function within(callable $func) {
        return $this->then(function($value) use ($func) {
            return static::new($func($value));
        });
    }

    public function __toString() {
    	return (string) $this->extract();
    }

    public function extend(callable $f): Comonad {
    	return $f($this);
    }

    public function duplicate(): Comonad {
    	return new static(clone $this);
    }

    // note from Dec 3, 2024 because I was going do do "fromNullable"
    // but really the pointed functor returning 
    public static function of($value): Maybe {
    	return is_null($value) ? Maybe::nothing() : Maybe::just($value);
    }

    /* don't like this at all (obviously) this is where using Map is best... */
    /* copying this over and not really sure what it's for */
    private function pluck($key, $source) {
        if(is_array($source)) {
            return isset($source[$key]) ? $source[$key] : null;
        }

        if(is_object($source)) {
            return isset($source->$key) ? $source->$key : null;
        }
    }

    public static function fromNullable($value) {
    	// funny how now I like UNIT
    	return is_null($value)
    		? Nothing::of()
    		: Just::of($value);
    }

	public function __call($method, $parameters) {

		return $this->then(function($value) use ($method, $parameters) {

			// in this case we're trying to call something that is a property
			// this is the "back and forth" - wish I documented this better.
			if(is_array($value)) {
				return isset($value[$method]) ? $value[$method] : null;
			} else if($value instanceof ArrType) {
			 	return $value->$method;
			} else if(is_object($value)) {
				// "find" for ProcessWire exists but was not being found
				// && method_exists($value, $method)

				try {
					return $value->$method(...$parameters);
				} catch(\Exception $e) {
					// should really be Left
					return null;
				} catch(\Error $e) {
					// perhaps a "prop"
					if(count($parameters) == 0) {
						return $this->pluck($method, $value);
						//return $value->$method;
					}

					return null;
				}
				
				// above was commented out at one point but
				// not sure why

				// leaving this for a minute, but I can see now where the issue was
				// and wondering if since it was sort of a demo/academic thing that got
				// me here that there were some use cases not considered?
				//return $value->$method;
			}
		});

	}

	public function isNothing() {
		return is_null($this->value);
	}

	public function getOrElse($default_value) {
		//return $this->isNothing() ? $default_value : $this->value;
		// will be funny when this is the issue.
		return $this->isNothing() ? $default_value : $this->extract();
	}

	// adding this alias on Apr 9, 2022 because I tried to use this
	// but see the above... 
	public function getOr($default_value) {
		return $this->getOrElse($default_value);
	}

	public function join() {
		return $this->extract();
	}

	public static function just($value) {
		return Just::of($value);
	}

	public static function nothing() {
		return Nothing::of();
	}

	// public function runClosure() {
	// 	return new self(call_user_func_array($this->value, func_get_args()));
	// }

	// I was calling this wrong anyway, would be interesting case for NoMethod type though since
	// I was trying to call "runCallback", but decided it was mayne not technically a "callback"

	public function exec() {
		if(is_callable($this->value)) {
			return new self(call_user_func_array($this->value, func_get_args()));
		}

		return None::of();
	}

	// or "run"?
	public function run() {
		if(is_callable($this->value)) {
			return new self(call_user_func_array($this->value, func_get_args()));
		}

		return None::of();
	}

	use ApplyTrait;

	// public function apply($f) {
	// 	// I suppose if you use the extract function
	// 	// the variable can be whatever, but I would 
	// 	// lean toward just doing $this->value
    //     return $f->map($this->extract());
    // }

    // public function ap($f) {
    // 	return $this->apply($f);
    // }

    public function applyM($applicative) {
    	return $this->map($applicative->extract());
    	//return $applicative->apply($this);
    }

	public function __get($property) {
		$value = $this->extract();
		$attempt_method = true;

		// reviewing code and have no idea what this would be for
		// June 9, 2023 15:34
		if(is_array($property)) {
			$property = $property["tryProp"];
			$attempt_method = false;
		}

		$out = null;
		if(is_array($value) && isset($value[$property])) {
			$out = $value[$property];
		} else if (is_object($value) && isset($value->$property)) {
			$out = $value->$property;
		}

		if(is_null($out)) {
			return $attempt_method
				? $this->$property()
				: null;
		}

		$type = \lray138\GAS\Types\getType($out);

		if(in_array($type, ["number", "string", "array"])) {
			return wrapType($out);
		}
		
		return Just::of($out);
	}

	public function chain($fn) {
		// need extra check in... this is why there needs to be ..
		// not sure what the pattern is.

		return $this->map($fn)->join();
		//$this->value->map($fn)->flatten();
		//return $this->map($fn)->join();
	}

	public function index($index) {
		$value = isset($this->value[$index]) 
					? $this->value[$index]
					: null;

		return new self($value);
	}

	public function map(callable $f): Maybe {
		return $this->then($f);
	}

	// ok, i don't have return type specified here so that's why
	// hadn't ran into this.
	public function bind($func) {
		return $this->then($func)->extract();
	}

	// need to allow null to be passed in the case of a 
	// apply where the file is not located
	public function then($func) {

		// this fails for empty arrays before with
		// just ($this->value)

		// if(is_null($this->value)) {
		// 	return static::new();
		// }

		// return static::new($func($this->value));

		if(is_null($this->value)) {
			return new self();
		} elseif(is_null($func)) {
			// Dec 3 2024 this is wrong and would be Nothing
			//return new self();
			return new self();
		} elseif(isNothing($func) || isError($func)) {
			return $func;
		}

		$value = $func($this->value);

		if(is_null($value)) {
			return Nothing::of();
		}

		return Some::of($value);
	}

	public function toMany() {
		return Many::of($this->value);
	}

	public function flatMap($fn) {
		if($this->value) {
			return $this->flatten()->map($fn);
			//return new Maybe($fn($this->value->value));
		}
		return new Maybe();
	}

	private function getProperty($property) {
		$prop = $this->$property();
		return $prop instanceof self ? $prop->extract() : $prop;
	}

	// public function toArr() {
	// 	return !$this->isNothing() ? \GAS\Types\Arr::of($this->value) : null;
	// }

	// public function get($property = null) {
	// 	return !is_null($property) 
	// 				? $this->getProperty($property)
	// 				: $this->value;
	// }

	public function __construct($value = null) {
		// this is where the auto-unwrapping seems not correct???

		// not sure when I wrote the above, but this is a case where
		// if I'm trying to use chain and I have this, then chain 
		// is pointless.
		// if(is_object($value) && $value instanceof static) {
		// 	$value = $value->extract();
		// }

		// so the above was commented out, but below is a more specific instance of 
		// the above...
		// if(is_object($value) && $value instanceof \GAS\Types\None) {
		// 	$value = $value->value();
		// }
		$this->value = $value;
	}

	// public static function of($x) {
	// 	return new self($x);
	// }

	// Jan 7th - Coming back to unit from Mayb... 
	public static function unit($x) {
		// return new self($x); - wonder when that would have ever been valid...
		return is_null($x) ? Maybe::nothing() : Maybe::just($x);
	}

	public function extract() {
		return $this->value;
	}

	public function out() {
		return $this->value;
	}

	public function get() {
		return $this->value;
	}
}
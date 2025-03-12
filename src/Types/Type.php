<?php namespace lray138\GAS\Types;

use lray138\GAS\Traits\{ChainTrait, PointedTrait, MapTrait, ApplyTrait, ExtendTrait};

use FunctionalPHP\FantasyLand\Monad;
use lray138\GAS\Types\Comonad;

use function lray138\GAS\dump;

class Type implements Monad, Comonad {

	protected $value;

	// constructors
	public function __construct($value = null) {
		$this->value = $value;
	}

	use PointedTrait;
	use ChainTrait;
	use ApplyTrait;
	use MapTrait;

	// public static function of($value = null) {
	// 	// return new self($value) returns Type, whereas we want the subclass
	// 	return new static($value);
	// }

	// extract methods
	public function extract() {
		return $this->value;
	}

    public function tap(callable $callback) {
        $callback($this->value);
        return $this;
    }

	// public function extend(callable $f) {
	// 	return new static($f($this));
	// }
	// I see this done two ways and wondering WTF - 2024-12-15 12:29

	/// no clue about the above, but the need for this comes from
	// trying to map on a whole collection/array vs the bind/map on each item
	public function extend(callable $f): Comonad {
		return $f($this);
	}

	public function duplicate(): Comonad {
		return new static(clone $this);
	}

	public function out() {
		return $this->extract();
	}

	// Feb 6 2025 - 10:51 - can't believe it took me this long to put this in...
	// or think to ... or whatever...
	public function dump() {
		dump($this);
		return $this;
	}

	// feb 25 - 13:00 - 
	public function type() {
		return Str(\lray138\GAS\Types\getType($this->extract()));
	}

	public function die($message = "") {
		die($message);
	}

	public function toArr($option = null) {

		if(is_string($option)) {
			return ArrType::of([$option => $this->value]);
		}

		$value = !is_null($option) 
					? $option($this->value)
					: $this->value;

		if(!is_array($this->value)) {
			$value = [$value];
		}

		return ArrType::of($value);
	}

	public function toNumber($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->value)
					: $this->value;

		// for now return the value, maybe in future return 
		// error or something
		if(!isNumber($value)) {
			echo "Nah $value";
			return $this;
		}

		return Number::of($value);
	}

	public function echo() {
		echo $this->extract();
		return $this;
	}

	public function toMaybe($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->extract())
					: $this->extract();

		return Maybe::of($value);
	}

	// probably should return null??? dunno
	// this looks like a bad implementation (Wed Jul 19, 2023)
	public function if($bool_or_callable, $callable_or_value = null) {
		$out = function() use ($bool_or_callable, $callable_or_value) {
			return is_callable($callable_or_value)
				? $callable_or_value($this)
				: $callable_or_value;
		};

		if(is_callable($bool_or_callable)) {
			if($bool_or_callable($this)) {
				return $out();
			}
			
			return $this;
		} else if($bool_or_callable) {
			return $out();
		}	

		return $this;
	}

	public function toDateTime() {
		return new \DateTime($this->value);
	}

	// ughhh... 
	// had this and the trait -- 2024-12-15 12:26
	// public function bind($callable) {
	// 	return (new self($callable($this->value)))->extract();
	// 	//return new self($callable($this->value)->extract());
	// }

	// public function chain($callable) {
	// 	return (new self($callable($this->value)))->extract();
	// }

	public function toStr($callable = null) {
		$value = !is_null($callable) 
					? $callable($this->extract())
					: $this->extract();

		return StrType::of($value);
	}

	// no clue what this is supposed to be
	public function toString($callable = null) {
		return $this->toStr($callable);
	}
	
	public function isNothing() {
		return false;
	}

	// adding this... also noting the "todateTime" and all that... 
	// not sure I ever used the "if" much and would prefer the monadic functions and
	// run that in there...  keep interace tight
	// Jan 6 15:36 
	public function either(callable $left, callable $right) {
		$value = $this->extract();
		return is_null($value) 
			? $left($value) 
			: $right($value);
	}

}
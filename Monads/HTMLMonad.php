<?php 

namespace GAS\Monads;

use function GAS\Functions\IO\dump;

use GAS\Functions\Arr;

class HTMLMonad {
	private $value;

	public function __construct($value = null) {
		// if(is_object($value) && $value instanceof static) {
		// 	$value = $value->value();
		// }

		$this->value = $value;
	}

	public function within(callable $func) {
        return $this->then(function($value) use ($func) {
            return static::new($func($value));
        });
    }

	public static function new(...$args) {
		return new static(...$args);
	}

	public static function of($x) {
		return new self($x);
		//return new static($x);
	}

	public function out() {
		return $this->value;
	}

	private function include() {
		return $this->then(function($value) {
			$partial = include($value["pathname"]);

			if(is_callable($partial)) {
				$partial = $partial("");
			}

			$dom = new \IvoPetkov\HTML5DOMDocument();
			$dom->loadHTML($partial);
			$element = $dom->querySelector("body")->firstElementChild;

			return $element;
		});
	}

	function nodeValue() {
		return $this->include()
					->then(function($value) {
						return $value->nodeValue;
						// need element type?
			
		});
	}

	function innerHTML() {
		return $this->include()
					->then(function($value) {
						return $value->innerHTML;			
		});
	}

	function attributes($name = "") {
		$out =  $this->include()
					 ->then(function($value) {
						return $value->getAttributes();
					});

		return empty($name) 
			? $out
			: $out->bind(function($x) {
				return isset($x[$name]) ? $x["name"] : null;
			});
	}

	public function __call($method, $parameters) {
		return $this->then(function($value) use ($method, $parameters) {
			
			if(is_array($value)) {
				// kind of weird now either it's the node, or a value in that node...
				if($value["element"] === $method) {
					return $value;
				} else if(isset($value[$method])) {
					return $value[$method];
				} else if(isset($value["children"])) {
					if($method === "children") {
						return $value["children"];
					} else {

						$filtered = Arr\filter(function($x) use ($method) {
							return $x["element"] === $method;
						})($value["children"]);

						
						if(count($parameters) === 1 && is_int($parameters[0])) {
							return $filtered[$parameters[0]-1];
						} if(count($parameters) === 1 && is_string($parameters[0])) {
							
							return Arr\find(function($x) use ($parameters) {
								$bits = explode("=", $parameters[0]);
								return HTMLMonad::of($x)
													->attributes
													->bind(function($x) use ($bits) {
														return isset($x[$bits[0]]) && $x[$bits[0]] === $bits[1];
													})
													->out();
							})($filtered);

							
						} else {
							return $filtered[0];
						}

						// foreach($value["children"] as $child) {
						// 	if($child["element"] === $method) {
						// 		return $child;
						// 	}
						// }

					}
				} 

				return null;
			} else {
				return isset($value->$method) ? $value->$method : null; 
			}

			return null;
		});
	}

	private function isNothing() {
		return is_null($this->value);
	}

	public function getOrElse($default_value) {
		return $this->isNothing() ? $default_value : $this->value;
	}

	public function map($fn) {
		return $this->then($fn);
	}

	public function bind($fn) {
		return $this->then($fn);
	}

	public function join() {
		return $this->extract();
	}

	public function __get($property) {
		return $this->$property();
	}

	public function chain($fn) {
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

	public function then(callable $func) {

		// this fails for empty arrays before with
		// just ($this->value)
		if(is_null($this->value)) {
			return static::new();
		}

		return static::new($func($this->value));
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

	public function flatten() {
		return $this->value;
	}

	public function extract() {
		return $this->value;
	}

	public function value() {
		return $this->value;
	}

	private function getProperty($property) {
		$prop = $this->$property();
		return $prop instanceof self ? $prop->extract() : $prop;
	}

	public function toArr() {
		return !$this->isNothing() ? \GAS\Types\Arr::of($this->value) : null;
	}

	public function get($property = null) {
		return !is_null($property) 
					? $this->getProperty($property)
					: $this->value;
	}
}
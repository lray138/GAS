<?php 

namespace lray138\GAS\Types;

use lray138\GAS\{
	Arr, 
	Functional as FP, 
	Str as S,
	HTML
	, Types as T
};

use function lray138\GAS\IO\dump;

class ArrType extends Type {

	public function push($value) {
		return ArrType::of(Arr\push($value, $this->value));
	}

	public function bind($callable) {
		return ArrType::of($callable($this->value));
	}

	public function pushKeyVal($key, $val) {
		return ArrType::of(Arr\pushKeyVal($key, $val, $this->value));
	}

	public function unshift($value) {
		$arr = $this->value;
		array_unshift($arr, $value);
		return ArrType::of($arr);
	}

	function removeLast() {
    	$arr = $this->value;
    	array_pop($arr);
    	return T\Arr($arr);
	}

	public function lastItem() {
		return $this->pop();
	}

	function pop() {
		$arr = $this->value;
		$arr = array_pop($arr);
		return T\wrap($arr);
	}

	// https://www.php.net/manual/en/array.sorting.php
	public function sort($arg = null, $options = null) {

		if(is_null($arg)) {
			$arr = $this->value;
			sort($arr);
			return new static($arr);
		}

		if(count($this->value) < 2) {
			return $this;
		}

		// check for field first, since, for example "date" would be true
		// for callable

		if(is_array($this->value) && is_array($this->value[0])) {
			
		} elseif(is_array($this->value) && T\isArr($this->value[0])) {

		}

		if(is_callable($arg)) {
			$arr = $this->value; 
			usort($arr, $arg);
			return ArrType::of($arr);
		}

	}

	public function set($key, $val) {
		// unwrap if type
		if($key instanceof \GAS\Types\Type) {
			$key = $key->extract();
		}
		return ArrType::of(Arr\set($key, $val, $this->value));
	}


	function filter($value = null) {
		if(is_null($value)) {
			$value = function($x) {
				return $x;
			};
		}
		return ArrType::of(Arr\filter($value, $this->value));
	}

	function fillKeys($value = null) {
		return ArrType::of(array_fill_keys($this->value, $value));
	}

	function combine($array = null) {
		$array = is_null($array) ? $this->value : $array;
		return ArrType::of(array_combine($this->value, $array));
	}

	function get($key) {
		// incase it is a StrType (i suppose)
		if(is_object($key) && method_exists($key, "extract")) {
			$key = $key->extract();
		}

		// probably need to dertimine, I think pluck is more
		// approprpiate
		$value = Arr\get($key, $this->value);
		
		// wrap type if not an object
		if(!is_object($value)) {
       		$value = T\wrapType($value);
       	}

		return is_null($value) || T\isNothing($value)
			? T\Nothing()
			: $value;
	}

	public function implode($delimeter = "") {

		// there may be cases... ha.  maybe cases where a value needs to be unwrapped?
		// added Mon Apr 4 @ 16:30
		return StrType::of(Arr\implode($delimeter, Arr\map(FP\extract, $this->value)));
	}

	public function isEmpty() {
		return count($this->value) === 0;
	}

	public function isLeft() {
		return false;
	}

	function apply($just) {
		//$f->map($this->extract());
		return $just($this);
	}

	function count() {
		return Number::of(count($this->value));
	}

	function flatten() {
		return new self(Arr\flatten($this->value));
	}

	function flatMap($callable) {
		return $this->flatten();
	}

	function isString() {
		return false;
	}

	function size() {
		return $this->count();
	}

	function first($callable) {

		foreach($this->value as $key => $val) {
			if($callable($val, $key)) {
				return $val;
			}
		}

		return false;
	}

	function tail() {
		return new self(Arr\tail($this->value));
	}

	function map(callable $func) {
		//return ArrType::of(Arr\map($func, $this->value));
		return new static(Arr\map($func, $this->value));
	}

	function max() {
		return T\wrap(\max($this->value));
	}

	// I flipped the Arr\merge order since we want
	// additional items to be last (i.e head_merge)
	function merge($arr) {
		return is_null($arr) || $arr instanceof None
			? $this
			: ArrType::of(Arr\merge($arr, $this->value));
	}

	function join($delimeter = "") {
		return StrType::of(Arr\join($delimeter, $this->value));
	}

	function toUl($attributes = []): StrType {

		if(count($this->value) === 0) {
			return StrType::of("");
		}

		$fn = FP\compose(
			S\wrap("<ul>", "</ul>"),
			Arr\join(""),
			Arr\map(S\wrap("<li>", "</li>"))
		);

		$fn = FP\compose(
			Arr\join("")
			, Arr\map(HTML\li)
		);

		return StrType::of(HTML\ul($fn($this->value), $attributes));
	}

	function toMaybe($callable = null) {
		return Maybe::of($this);
	}

	function walk(callable $func) {
		Arr\walk($func, $this->value);
		return $this;
	}

	// in the Arr functional part, $initial would come first, here we don't need it to be first
	function reduce($callable, $initial = null) {
		$test = array_reduce($this->value, $callable, $initial);

		if(isType($test)) {
			return $test;
		}

		return T\wrap($test);
	}

	public function reverse() {
		return T\Arr(array_reverse($this->value));
	}

	public function head() {
		return $this->get(0);
	}

	public function rsort() {
		$arr = $this->value;
		rsort($arr);
		return new static($arr);
	}

	public static function of($data = []) {
		//return new self($data);
		return new static($data);
	}

	const of = __NAMESPACE__ . '\of';

	public function __construct($data = []) {
		// if($data instanceof self) {
		// 	$data = $data->extract();
		// } elseif(!is_array($data)) {
		// 	$data = [$data];
		// }

		if(is_null($data)) {
			$data = [];
		}

		$this->value = $data;
	}

	public function __get($key) {
		return $this->get($key);
	}

	public function __set($property, $value) {
		$this->value[$property] = $value;
	}

	public function __call($name, $args) {
		if(isset($this->value[$name])) {
			return $this->value[$name](...$args);
		}

		return NoMethod::of($name . " method doesn't exists in " . $this->value);
	}

	public function toJust() {
		return Some::of($this);
	}

}
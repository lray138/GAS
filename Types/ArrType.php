<?php 

namespace lray138\GAS\Types;
use lray138\GAS\{Arr as A, Functional as FP, Str as S};
use function lray138\GAS\IO\dump;

class ArrType extends Type {

	public function push($value) {
		return Arr::of(A\push($value, $this->value));
	}

	public function pushKeyVal($key, $val) {
		return Arr::of(A\pushKeyVal($key, $val, $this->value));
	}

	public function set($key, $val) {
		// unwrap if type
		if($key instanceof \GAS\Types\Type) {
			$key = $key->extract();
		}
		return Arr::of(A\set($key, $val, $this->value));
	}

	function filter($value = null) {
		if(is_null($value)) {
			$value = function($x) {
				return $x;
			};
		}
		return Arr::of(A\filter($value, $this->value));
	}

	function fillKeys($value = null) {
		return Arr::of(array_fill_keys($this->value, $value));
	}

	function combine($array = null) {
		$array = is_null($array) ? $this->value : $array;
		return Arr::of(array_combine($this->value, $array));
	}

	function get($key) {
		if(is_object($key) && method_exists($key, "extract")) {
			$key = $key->extract();
		}
		$value = A\get($key, $this->value);
		return $value ?: None::of();
	}

	function implode($delimeter) {
		return Str::of(A\implode($delimeter, $this->value));
	}

	function isEmpty() {
		return count($this->value) === 0;
	}

	function count() {
		return Number::of(count($this->value));
	}

	function flatten() {
		return new self(A\flatten($this->value));
	}

	function size() {
		return $this->count();
	}

	function first() {
		return A\head($this->value);
	}

	function tail() {
		return new self(A\tail($this->value));
	}

	function extract() {
		return $this->value;
	}

	function map(callable $func) {
		return Arr::of(A\map($func, $this->value));
	}

	function merge($arr) {
		return is_null($arr)
			? $this
			: Arr::of(array_merge($this->value, $arr));
	}

	function join($delimeter = "") {
		return Str::of(A\join($delimeter, $this->value));
	}

	function toUl(): Str {
		$fn = FP\compose(
			S\wrap("<ul>", "</ul>"),
			A\join(""),
			A\map(S\wrap("<li>", "</li>"))
		);
		return Str::of($fn($this->value));
	}

	function walk(callable $func) {
		A\walk($func, $this->value);
	}

	public static function of($data = []) {
		return new self($data);
	}

	const of = __NAMESPACE__ . '\of';

	public function __construct($data = []) {
		if($data instanceof self) {
			$data = $data->extract();
		} elseif(!is_array($data)) {
			$data = [$data];
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
		return NoMethod::of($name . " method doesn't exists in ");
	}

}
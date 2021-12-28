<?php 

namespace lray138\GAS\Types;
use lray138\GAS\{Arr as A, Functional as FP, Str as S};

class Arr {

	private $data;

	public function push($value) {
		return Arr::of(A\push($value, $this->data));
	}

	public function pushKeyVal($key, $val) {
		return Arr::of(A\pushKeyVal($key, $val, $this->data));
	}

	public function set($key, $val) {
		// unwrap if type
		if($key instanceof \GAS\Types\Type) {
			$key = $key->extract();
		}
		return Arr::of(A\set($key, $val, $this->data));
	}

	public static function of(array $data = []) {
		return new self($data);
	}

	const of = __NAMESPACE__ . '\of';

	public function __construct(array $data) {
		$this->data = $data;
	}

	function filter($value = null) {
		if(is_null($value)) {
			$value = function($x) {
				return $x;
			};
		}
		return Arr::of(A\filter($value, $this->data));
	}

	function get($key) {
		if(is_object($key) && method_exists($key, "extract")) {
			$key = $key->extract();
		}
		$value = A\get($key, $this->data);
		return $value ?: None::of();
	}

	function implode($delimeter) {
		return Str::of(A\implode($delimeter, $this->data));
	}

	function isEmpty() {
		return count($this->data) === 0;
	}

	function count() {
		return Number::of(count($this->data));
	}

	function size() {
		return $this->count();
	}

	function first() {
		return A\head($this->data);
	}

	function tail() {
		return new self(A\tail($this->data));
	}

	function extract() {
		return $this->data;
	}

	function map(callable $func) {
		return Arr::of(A\map($func, $this->data));
	}

	function join($delimeter): Str {
		$fn = FP\compose(
			A\join($delimeter),
			A\map(S\extract)
		);
		return Str::of($fn($this->data));
	}

	function toUl(): Str {
		$fn = FP\compose(
			S\wrap("<ul>", "</ul>"),
			A\join(""),
			A\map(S\wrap("<li>", "</li>"))
		);
		return Str::of($fn($this->data));
	}

	function walk(callable $func) {
		A\walk($func, $this->data);
	}

	public function __get($key) {
		return $this->get($key);
	}

	public function __call($name, $args) {
		return NoMethod::of($name . " method doesn't exists in ");
	}

}
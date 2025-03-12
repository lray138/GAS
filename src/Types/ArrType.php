<?php 

namespace lray138\GAS\Types;

use lray138\GAS\{
	Arr, 
	Functional as FP, 
	Str as S,
	HTML
	, Types as T
};

use lray138\GAS\Types\Either;

use FunctionalPHP\FantasyLand\{
	Monoid, // memty,
	Semigroup
};

use lray138\GAS\Traits\ExtractValueTrait;

use function lray138\GAS\Functional\extract;
use lray138\GAS\Traits\MapTrait;
use lray138\GAS\Types\Number;
use function lray138\GAS\Types\wrapType;

use function lray138\GAS\IO\dump;
use lray138\GAS\Types\Comonad;

class ArrType extends Type implements Monoid {

	public const of  = __CLASS__ . '::of';
	
	protected int $position = 0;

	public function push($value) {
		return ArrType::of(Arr\push($value, $this->value));
	}

	public static function mempty() {
		return new static([]);
	}

	public function concat(Semigroup $x): ArrType {
		return new static(array_merge($this->extract(), $x->extract()));
	}

	public function sum() {
		return Number::of(array_sum($this->value));
	}

	// I am likley doing "bind" here because I didn't know
	// what extend is - Oct 10 2024 

	// ok, this isn't right anyway Dec 15 2024... not sure what is 
	// and I also don't quite have the grasp on "extend" bind should definately be
	// returning the function call but expecting the monad... 
	public function bind($callable) {
		//return $callable($this->value);
		// this had been wrong and updated Dec 28 2k24, 11:38 PM
			
		$out = [];
		foreach($this->value as $val) {
			$out[] = $callable($val)->extract();
		}

		// it's late but this is what I would have expected it to behave like
		// and now it does
		// Dec 28 11:47 ...

		return new static($out);
	}

	public function diff($array) {
		return ArrType::of(array_diff($this->extract(), $array));
	}

	// I don't really dig this... although push above 2nd argument being
	// the key would make more sense... 
	public function pushKeyVal($key, $val) {
		return ArrType::of(Arr\pushKeyVal($key, $val, $this->value));
	}

	public function unshift($value) {
		$arr = $this->value;
		array_unshift($arr, $value);
		return ArrType::of($arr);
	}

	public function unique($flags = SORT_STRING) {
		$unique = array_unique($this->extract());
		return ArrType::of($unique, $flags);
	}

	public function uniqueRegular() {
		return $this->unique(SORT_REGULAR);
	}

	public function values() {
		return new static(array_values($this->extract()));
	}

	function removeLast() {
    	$arr = $this->value;
    	array_pop($arr);
    	return T\Arr($arr);
	}

	public function lastItem() {
		return $this->pop();
	}

	public function last() {
		return $this->pop();
	}

	function pop() {
		$arr = $this->value;
		$arr = array_pop($arr);
	
		$out = T\wrap($arr);

		if($out instanceof \lray138\GAS\Types\Error) {
			return $arr;
		}
		
		return $out;
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

	use ExtractValueTrait;

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

	function toJson() {
		return \lray138\GAS\Types\StrType::of(json_encode($this->extractRecursive()));
	}

	function jsonEncode() {
		return $this->toJSON();
	}

	// wonder why this was commented out Jan 24, 16:37
	function getOrElse($value) {
		return $this->extract();
	}

	function goe($value) {
		return $this->getOrElse();
	}

	// note Oct 17 2024 02:54 obviously should have tried to go to sleep but...
	// get (prop) will conflict with get (extract)

	// note Oct 21 2024 18:00 
	// exactly, so let's change "get" to "prop"

	// this would be a good example of lesson for updating the code
	// so it uses a Either vs Maybe
	public function prop($key) {
		// incase it is a StrType (i suppose)
		if(is_object($key) && method_exists($key, "extract")) {
			$key = $key->extract();
		}

		// probably need to dertimine, I think pluck is more
		// approprpiate
		$value = Arr\get($key, $this->value);
		
		// wrap type if not an object
		// if(!is_object($value)) {
       	// 	$value = T\wrapType($value);
       	// }

       	$value = T\wrapType($value);

		return is_null($value) || T\isNothing($value)
			? Either::left("prop '$key' not found")
			: $value;
	}

	public function p($key) {
		return $this->prop($key);
	}



	public function getPath($path) {
		return \Idles\hasPath($path, $this->extract())
			? wrapType(\Idles\path($path, $this->extract()))
			: Nothing::of();
	}

	public function chunk(int $length, bool $preserve_keys = false) {
		return new self(array_chunk($this->extract(), $length, $preserve_keys));
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

	public function slice($offset, $length = null, $preserve_keys = false) {
		return ArrType::of(array_slice($this->extract(), $offset, $length, $preserve_keys));
	}

	// function apply($just) {
	// 	//$f->map($this->extract());
	// 	return $just($this);
	// }

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

	function map(callable $func): ArrType {
		return new static(Arr\map($func, $this->value));
	}

	function max() {
		return \lray138\GAS\Types\Number::of(\max($this->value));
	}

	// I flipped the Arr\merge order since we want
	// additional items to be last (i.e head_merge)
	function merge($arr) {
		if(is_object($arr) && method_exists($arr, "extract")) {
			$arr = $arr->extract();
		}

		return is_null($arr) || $arr instanceof None || $arr instanceof Nothing
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

	function toOl($attributes = []) {

		if(count($this->value) === 0) {
			return StrType::of("");
		}

		$fn = FP\compose(
			S\wrap("<ol>", "</ol>"),
			Arr\join(""),
			Arr\map(S\wrap("<li>", "</li>"))
		);

		$fn = FP\compose(
			Arr\join("")
			, Arr\map(HTML\li)
		);

		return StrType::of(HTML\ol($fn($this->value), $attributes));

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

	public function toTable($attrs = []) {
		$out = "";
    	$rows = $this->extract();
	
    	if (empty($rows)) {
    	    $e->return = $out;
    	    return;
    	}

    	$table_class = "table";

    	if(isset($attrs["class_append"])) {
    		$table_class = "table " . $attrs["class_append"];
    	}
	
    	// Start table
    	$out .= "<table class=\"$table_class\">";
	
    	// Use the first row's keys as headers if the row is associative
    	$firstRow = $rows[0];
	
    	if (is_array($firstRow)) {
    	    $out .= "<thead><tr>";
    	    $out .= implode(array_map(function($key) {
    	        return "<th>" . htmlspecialchars($key) . "</th>";
    	    }, array_keys($firstRow)));
    	    $out .= "</tr></thead>";
    	}
	
    	// Generate table rows
    	$out .= "<tbody>";
    	foreach ($rows as $row) {
    	    $out .= "<tr>";
    	    $out .= implode(array_map(function($x) use (&$out) {
    	        $out .= "<td>" . $x . "</td>";
    	    }, $row));
	
    	    $out .= "</tr>";
    	}
    	$out .= "</tbody>";
	
    	// Close table
    	$out .= "</table>";
	
    	return $out;
	}

	public function reverse() {
		return T\Arr(array_reverse($this->value));
	}

	public function head() {
		$items = $this->extract();

		if(count($items) === 0) {
			// return new self([]);
			// Jan 2 13:56 - This is the correct annswer, and maybe even
			// Just::Nothing...
			return Either::left("No items in Array (head fail)");
		}

		// honestly think this implementation is wrong 
		// and should really be acting like an extract/get
		// @todo discuss

		// ok, I can see why this is wrong... 
		// it's that it should be wrapping the type and if the type 
		// is array that's OK. but forcing it to be an array is not

		// ok... Dec 31, 17:26 ... been up since fucking 5... hahaha let's FUCKING GOOOOO!!!!
		// anyway this is actually the last thing for the demo buildout and also 
		// was a last flag I know. so, poetic... let's do this!
		foreach($this->extract() as $item) {

			return wrapType($item);

			// if(!is_array($item)) {
			// 	$item = wrapType($item);
			// 	//$item = [$item];
			// }
			// return new self($item);
		}
	}

	public function rsort() {
		$arr = $this->value;
		rsort($arr);
		return new static($arr);
	}

	public static function of($data = []): ArrType {
		//return new self($data);
		return new static($data);
	}

	public function __construct($data = []) {
		// if($data instanceof self) {
		// 	$data = $data->extract();
		// } elseif(!is_array($data)) {
		// 	$data = [$data];
		// }

		if(!is_array($data) && is_iterable($data)) {
			$data = iterator_to_array($data);
		} else if(!is_array($data)) {
			$data = [$data];
		}

		// this wouldn't even be true...
		if(is_null($data)) {
			$data = [];
		}

		$this->value = $data;
	}

	public function __get($key) {
		return $this->prop($key);
	}

	// we wouldn't do it like this anyway cause 
	// it's not "Point Free"
	public function __set($property, $value) {
		$this->value[$property] = $value;
	}

	public function hasKey($key) {
		return Boolean::of(array_key_exists($key, $this->extract()));
	}

	// so, I needed either here because ... well the other thing is 
	// would we allow this "magic" on Str/Array/etc...
	public function __call($method, $args) {
		// this is where we get a little "hacky/geeky" 
		// perhaps, note on Sept 10, 2022 as I'm updating this stuff
		if(isset($this->value[$method])) {
			return $this->value[$method](...$args);
		} else if(function_exists("\lray138\GAS\Arr\\$method")) {
			$func = "\lray138\GAS\Arr\\$method";
			return new self(call_user_func_array($func, [...$args, $this->extract()]));
		}

		return NoMethod::of($method . " method doesn't exists in stored value");
	}

	// if you started with an either then I think this is fair 
	// considering the mentality is to return the type expected 
	// so you would either have that type or the either class type
	public function either(callable $_, callable $right) {
		return $right($this->extract());
	}

	public function toJust() {
		return Some::of($this);
	}
	
	#[\ReturnTypeWillChange]
	public function rewind() {
        $this->position = 0;
    }
 
 	#[\ReturnTypeWillChange]
    public function current() {
        return $this->extract()[$this->position];
    }
 
 	// I never used this but I guess I'll call it index...
 	// ok, coming back to reclaim... not really sure what Interface I was implementing
 	// but have never used it for that purpose so moving on.
    public function key($key, $transform = true) {
        return $this->index($key, $transform);
    }

    // I guess this was if I wanted to not transform and keep it as an array?
    // not sure why I would do that or ... I asdflkjas who knows, some of this 
    // is academic
    public function index($key, $transform = true) {
    	if(isset($this->extract()[$key])) {

    		if(!$transform) {
    			return new static([$this->extract()[$key]]);
    		}

    		if(getType($this->extract()[$key]) == "object") {
    			return \lray138\GAS\Types\Either::right($this->extract()[$key]);
    		}

    		return wrapType($this->extract()[$key]);
    	}

    	return \lray138\GAS\Types\Either::left("Index $key not found");
    	//return \lray138\GAS\Types\Maybe::nothing();
    }

	private function extractR($items) {
	    return array_map(function ($item) {
	        if (is_array($item)) {
	            return $this->extractR($item); // Use $this->extractR for recursion
	        }
	        if (is_object($item) && method_exists($item, 'extract')) {
	            return $item->extract();
	        }
	        return $item;
	    }, $items);
	}

	public function extractRecursive(): array {
	    return $this->extractR($this->extract());
	}
 
 	#[\ReturnTypeWillChange]
    public function next(): int {
        return ++$this->position;
    }
 
 	#[\ReturnTypeWillChange]
    public function valid() {
        return isset($this->extract()[$this->position]);
    }

    public function __toString() {
    	return "ArrType: array needs to be converted to string";
    }
}
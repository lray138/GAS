<?php namespace lray138\GAS\Traits;

use function lray138\GAS\Arr\get;
use lray138\GAS\Types as T;
use lray138\GAS\Types\Either;
use function lray138\GAS\dump;

trait PropTrait {

    public function prop($key) {
		// incase it is a StrType (i suppose)
		if(is_object($key) && method_exists($key, "extract")) {
			$key = $key->extract();
		}

		// probably need to dertimine, I think pluck is more
		// approprpiate 
		$value = get($key, $this->extract());

       	$value = T\wrapType($value);

		return is_null($value) || T\isNothing($value)
			? Either::left("prop '$key' not found")
			: $value;
	}

	public function p($key) {
		return $this->prop($key);
	}

}
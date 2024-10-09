<?php namespace lray138\GAS\Arr;

use lray138\GAS\Types\ArrType;

const of = __NAMESPACE__ . '\of';

/**
 * @todo remove this more than likely? cause why not just Str() yea even TString() 
 * doesn't make much sense
 */ 
function of(array $arr) {
    return ArrType::of($arr);
}
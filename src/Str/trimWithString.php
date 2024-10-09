<?php namespace lray138\GAS\Str;

const trimWithString = __NAMESPACE__ . '/trimWithString';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 * 
 *  this code was from Chris Pitt typed PHP book, but was not in 
 *  what I consider "functional order"
 *  ok, here's the prob then I switched it up there and not everywhere... 
 */
function trimWithString($characters, $string) {
    return is_null($characters) ? \trim($string) : \trim($string, $characters);
}
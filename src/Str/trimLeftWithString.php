<?php namespace lray138\GAS\Str;

const trimLeftWithString = __NAMESPACE__ . '/trimLeftWithString';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string 
 * I think this is Chris Pitt code.
 */
function trimLeftWithString($haystack, $needle) {
    
    return \ltrim($haystack, $needle);
}
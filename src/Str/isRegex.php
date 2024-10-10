<?php namespace lray138\GAS\Str;

const isRegex = __NAMESPACE__ . '\isRegex';

/**
 * 
 */
function isRegex($s) {
    return \lray138\GAS\Types\isExpression($s);
}
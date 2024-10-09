<?php namespace lray138\GAS\Str;

const isRegex = __NAMESPACE__ . '\isRegex';

/**
 * 
 * 
 */
function isRegex($variable) {
    return Types\isExpression($variable);
}
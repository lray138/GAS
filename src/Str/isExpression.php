<?php namespace lray138\GAS\Str;

const isExpression = __NAMESPACE__ . '\isExpression';

/**
 * 
 * 
 * @param mixed $variable
 * @return bool
 */
function isExpression($variable) {
    return isRegex($variable);
}
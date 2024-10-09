<?php namespace lray138\GAS\Arr;

const length = __NAMESPACE__ . '\length';

/**
 * @param array $array
 * @todo not sure why I included this, would be interesting to cross reference the PHP books
 * @return int
 */
function length(array $array) {
    return count($array);
}
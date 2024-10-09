<?php namespace lray138\GAS\Arr;

const hasKey = __NAMESPACE__ . '\hasKey';

/**
 * this is an alias of "has", but thinking "hasProperty" or "hasProp" could also 
 * be viable
 */
function hasKey() {
    return has(...func_get_args());
}
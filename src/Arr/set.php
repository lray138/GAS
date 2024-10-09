<?php namespace lray138\GAS\Arr;

/**
 * since push key val overwrites, this is sort of moot 
 */

const set = __NAMESPACE__ . '\set';

function set() {
    return pushKeyVal(...func_get_args());
}
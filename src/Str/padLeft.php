<?php namespace lray138\GAS\Str;

const padLeft = __NAMESPACE__ . '\padLeft';

/**
 * 
 */
function padLeft() {
    return call_user_func_array(padLeftN(1), func_get_args());
}
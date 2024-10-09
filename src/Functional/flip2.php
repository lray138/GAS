<?php namespace lray138\GAS\Functional;

const flip2 = __NAMESPACE__ . '\flip2';

/**
 * Function description.
 */
// adding this now, because I tried to call it flip2, forgetting that I 
// used flip as a default flip 2
function flip2() {
    return call_user_func_array(flipN(2), func_get_args());
}

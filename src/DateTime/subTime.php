<?php namespace lray138\GAS\DateTime;

use function lray138\GAS\Functional\curry2 as curry;

const subTime = __NAMESPACE__ . '\subTime';

/**
 * Function description.
 */
function subTime($time_string, \DateTime $dt = null) {
    $f = function($time_string, \DateTime $dt) {
        return modify("-" . $time_string, $dt);
    };
    
    return curry($f)(...func_get_args());
}
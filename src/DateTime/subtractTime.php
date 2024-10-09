<?php namespace lray138\GAS\DateTime;

use function lray138\GAS\Functional\curry2 as curry;

const subtractTime = __NAMESPACE__ . '\subtractTime';

/**
 * Function description.
 */
function subtractTime($time_string, \DateTime $dt = null) {
    $f = function($time_string, \DateTime $dt) {
        return modify("-" . $time_string, $dt);
    };

    return curry($f)(...func_get_args());
}
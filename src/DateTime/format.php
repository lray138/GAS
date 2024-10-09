<?php namespace lray138\GAS\DateTime;

use function lray138\GAS\Functional\curry2 as curry;

const format = __NAMESPACE__ . '\format';

/**
 * Function description.
 */
function format() {
    $format = function($format, \DateTime $dt) {
        $formats = [
            "mysql" => "Y-m-d H:i:s",
            "shell" => "YmdHi"
        ];

        if(array_key_exists($format, $formats)) {
            return $dt->format($formats[$format]);
        }

        return $dt->format($format);
    };

    return curry($format)(...func_get_args());
}
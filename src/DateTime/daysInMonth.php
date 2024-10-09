<?php namespace lray138\GAS\DateTime;

const daysInMonth = __NAMESPACE__ . '\daysInMonth';

/**
 * Function description.
 */
function daysInMonth() {    
    $daysInMonth = function($year, $month) {
        return date('t',strtotime($year.'-'.$month.'-01'));
    };

    return call_user_func_array(FP\curry2($daysInMonth), func_get_args());
}
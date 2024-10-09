<?php namespace lray138\GAS\DateTime;

const firstDayOfWeek = __NAMESPACE__ . '\firstDayOfWeek';

/**
 * Function description.
 */
function firstDayOfWeek() {
    $firstDayOfTheWeek = function($year, $month) {
        return date('N', strtotime($year . '-' . $month . '-01'));
    };

    return call_user_func_array(FP\curry2($firstDayOfTheWeek), func_get_args());
}
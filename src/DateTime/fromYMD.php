<?php namespace lray138\GAS\DateTime;

const fromYMD = __NAMESPACE__ . '\fromYMD';

/**
 * Function description.
 */
function fromYMD() {
    return call_user_func_array(fromYearMonthDay, func_get_args());
}


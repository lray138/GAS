<?php namespace lray138\GAS\DateTime;

const getMonthNumberShort = __NAMESPACE__ . '\getMonthNumberShort';

/**
 * Function description.
 */
function getMonthNumberShort(\DateTime $dt) {
    return getMonthNoLeadingZero($dt);
}
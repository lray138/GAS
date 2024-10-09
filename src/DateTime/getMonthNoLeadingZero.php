<?php namespace lray138\GAS\DateTime;

const getMonthNoLeadingZero = __NAMESPACE__ . '\getMonthNoLeadingZero';

/**
 * Function description.
 */
function getMonthNoLeadingZero(\DateTime $dt) {
    return format("n", $dt);
}
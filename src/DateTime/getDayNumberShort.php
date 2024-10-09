<?php namespace lray138\GAS\DateTime;

const getDayNumberShort = __NAMESPACE__ . '\getDayNumberShort';

/**
 * Function description.
 */
function getDayNumberShort(\DateTime $dt) {
    return getDayNoLeadingZero($dt);
}
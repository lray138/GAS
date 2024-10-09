<?php namespace lray138\GAS\DateTime;

const getDayNoLeadingZero = __NAMESPACE__ . '\getDayNoLeadingZero';

/**
 * Function description.
 */
function getDayNoLeadingZero(\DateTime $dt) {
    return format("j", $dt);
}
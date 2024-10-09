<?php namespace lray138\GAS\DateTime;

const getMMM = __NAMESPACE__ . '\getMMM';

/**
 * Function description.
 */
function getMMM(\DateTime $dt) {
    return format("M", $dt);
}
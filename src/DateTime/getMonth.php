<?php namespace lray138\GAS\DateTime;

const getMonth = __NAMESPACE__ . '\getMonth';

/**
 * Function description.
 */
function getMonth(\DateTime $dt) {
    return format("m", $dt);
}
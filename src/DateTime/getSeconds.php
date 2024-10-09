<?php namespace lray138\GAS\DateTime;

const getSeconds = __NAMESPACE__ . '\getSeconds';

/**
 * Function description.
 */
function getSeconds(\DateTime $dt) {
    return format("s", $dt);
}
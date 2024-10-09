<?php namespace lray138\GAS\DateTime;

const formatShell = __NAMESPACE__ . '\formatShell';

/**
 * Function description.
 */
function formatShell(\DateTime $dt) {
    return format("YmdHi", $dt);
}
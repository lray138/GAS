<?php namespace lray138\GAS\Str;

const padZero = __NAMESPACE__ . '\padZero';

/**
 * 
 */
function padZero($x) {
    return sprintf('%02d', $x);
}
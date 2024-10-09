<?php namespace lray138\GAS\DateTime;

const prettyDiff = __NAMESPACE__ . '\prettyDiff';

/**
 * Function description.
 */
function prettyDiff($a, $b, $options = []) {
    return niceDiffFormat($a, $b, $options);
}
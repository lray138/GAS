<?php namespace lray138\GAS\Arr;

const filterEmpty = __NAMESPACE__ . '\filterEmpty';

/**
 * this is so we don't have to pass null in for a first argument, but that
 * maybe better
 * @todo remove this because there was an obvious other choice
 */
function filterEmpty($array) {
    return array_filter($array);
}
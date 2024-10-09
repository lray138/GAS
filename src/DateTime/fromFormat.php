<?php namespace lray138\GAS\DateTime;

const fromFormat = __NAMESPACE__ . '\fromFormat';

/**
 * @todo make this curried;
 */
function fromFormat($format, $value): \DateTime {
    return \DateTime::createFromFormat($format, $value);
}
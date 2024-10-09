<?php declare(strict_types=1);

namespace lray138\GAS\Str;

const addLeadingZero = __NAMESPACE__ . '\addLeadingZero';

/**
 * @param string $number
 * @return string
 */
function addLeadingZero(string $number): string {
    return strlen($number) === 1 ? "0$number" : $number;
}
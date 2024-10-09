<?php namespace lray138\GAS\Str;

const numberFormat = __NAMESPACE__ . '\numberFormat';

// https://www.php.net/manual/en/function.number-format.php
// https://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
function numberFormat($number) {
    return number_format($number);
}
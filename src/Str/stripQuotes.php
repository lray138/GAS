<?php namespace lray138\GAS\Str;

const stripQuotes = __NAMESPACE__ . '\stripQuotes';

function stripQuotes($str) {
    return removeQuotes($str);
}
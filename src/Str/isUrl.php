<?php namespace lray138\GAS\Str;

const isUrl = __NAMESPACE__ . '\isUrl';

function isUrl($string) {
    return filter_var($string, FILTER_VALIDATE_URL) !== false;
}
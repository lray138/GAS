<?php namespace lray138\GAS\Str;

const slugToCamelCase = __NAMESPACE__ . '/slugToCamelCase';

function slugToCamelCase($str) {
    return str_replace("-", "", ucwords($str, "-"));
}
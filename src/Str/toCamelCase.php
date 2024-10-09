<?php namespace lray138\GAS\Str;

const toCamelCase = __NAMESPACE__ . '/toCamelCase';

function toCamelCase($str) {
    return lcfirst(str_replace(" ", "", ucwords($str, " ")));
}
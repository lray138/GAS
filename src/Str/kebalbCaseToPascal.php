<?php namespace lray138\GAS\Str;

const kebalbCaseToPascal = __NAMESPACE__ . '/kebalbCaseToPascal';

function kebalbCaseToPascal($str) {
    return str_replace("-", "", ucwords($str, "-"));
}
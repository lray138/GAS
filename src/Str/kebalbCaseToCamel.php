<?php namespace lray138\GAS\Str;

const kebalbCaseToCamel = __NAMESPACE__ . '/kebalbCaseToCamel';

function kebalbCaseToCamel($str) {
    return lcfirst(kebalbCaseToPascal($str));
}
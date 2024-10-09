<?php namespace lray138\GAS\Arr;

const sortNaturalCaseSensitive = __NAMESPACE__ . '\sortNaturalCaseSensitive';

function sortNaturalCaseSensitive($array) {
    natcasesort($array);
    return $array;
}
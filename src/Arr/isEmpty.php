<?php namespace lray138\GAS\Arr;

const isEmpty = __NAMESPACE__ . '\isEmpty';

function isEmpty(array $array) {
    return count($array) === 0;
}
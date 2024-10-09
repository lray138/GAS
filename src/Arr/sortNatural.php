<?php namespace lray138\GAS\Arr;

const sortNatural = __NAMESPACE__ . '\sortNatural';

function sortNatural($array) {
    natsort($array);
    return $array;
}
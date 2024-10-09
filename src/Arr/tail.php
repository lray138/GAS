<?php namespace lray138\GAS\Arr;

const tail = __NAMESPACE__ . '\tail';

function tail($array) {
    return array_slice($array, 1);
}
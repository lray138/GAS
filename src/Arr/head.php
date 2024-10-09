<?php namespace lray138\GAS\Arr;

const head = __NAMESPACE__ . '\head';

function head($array) {
    foreach($array as $key => $val) {
        return $array[$key];
    }
}
<?php namespace lray138\GAS\Arr;

const end = __NAMESPACE__ . '\end';

function end(array $array) {
    if(!empty($array)) {
        return \end($array);
    }
}
<?php namespace lray138\GAS\Str;

const firstChar = __NAMESPACE__ . '/firstChar';

function firstChar($string) {
    return substr($string, 0, 1);
}
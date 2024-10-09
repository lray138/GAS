<?php namespace lray138\GAS\Str;

const lastChar = __NAMESPACE__ . '/lastChar';

function lastChar($string) {
    return substr($string, strlen($string)-1, 1);
}
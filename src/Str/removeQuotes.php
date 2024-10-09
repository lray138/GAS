<?php namespace lray138\GAS\Str;

const removeQuotes = __NAMESPACE__ . '\removeQuotes';

function removeQuotes(string $str): string {
    return str_replace(["'", '"'], '', $str);
}
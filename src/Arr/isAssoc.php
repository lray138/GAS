<?php namespace lray138\GAS\Arr;

const isAssoc = __NAMESPACE__ . '\isAssoc';

//https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
function isAssoc(array $array) {
    return isAssociative($array);
}
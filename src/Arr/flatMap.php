<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const flatMap = __NAMESPACE__ . '\flatMap';

// https://github.com/lstrojny/functional-php/blob/main/src/Functional/FlatMap.php
// was recommended from 
// https://gist.github.com/davidrjonas/8f820ab0c75534b45189eba1d1fbeb23
function flatMap() {
    $f = function($callable, $array) {
        return array_merge([], ...array_map($callable, $array));
    };

    return curry($f)(...func_get_args());
};
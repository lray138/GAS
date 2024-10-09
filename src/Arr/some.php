<?php namespace lray138\GAS\Arr;

const some = __NAMESPACE__ . '\some';

/**
 * not sure where this came from
 */
function some($callable, $arr) {
    foreach($arr as $a) {
        if($callable($a)) return true;
    }
    return false;
}
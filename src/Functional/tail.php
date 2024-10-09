<?php namespace lray138\GAS\Functional;

const tail = __NAMESPACE__ . '\tail';

/**
 * Function description.
 */
function tail($collection) {
    $tail = [];
    $isHead = true;

    foreach($collection as $key => $value) {
        if($isHead) {
            $isHead = false;
            continue;
        }

        $tail[$key] = $value;
    }

    return $tail;
}
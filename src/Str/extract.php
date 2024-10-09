<?php namespace lray138\GAS\Str;

// inereesting asdf 
/**
 * @todo remove this since it probably doesn't belong
 */
function extract($str) {
    if($str instanceof \GAS\Types\Str) {
        $str = $str->extract();
    }

    return $str;
}
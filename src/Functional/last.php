<?php namespace lray138\GAS\Functional;

/* Note: originally from Idles */

function last(?iterable $collecton)
{
    if (\is_array($collecton)) {
        $k = \array_key_last($collecton);
        return $k !== null ? $collecton[$k] : null;
    }
    $last = null;
    if ($collecton) {
        foreach ($collecton as $value) {
            $last = $value;
        }    
    }
    return $last;
}
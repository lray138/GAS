<?php namespace lray138\GAS\Arr;

const multisort = __NAMESPACE__ . '\multisort';

/**
 * 
 * Reference: https://www.php.net/manual/en/function.array-multisort.php
 */
// probably tough to do FP style and maybe provide warning
// vaugley remember this but not sure what the purpose was... (i.e. array1, array2)
function multisort(array $array1, $array1_sort_order = SORT_ASC, $array1_sort_flags = SORT_REGULAR, array ...$rest) {
    array_multisort($array1, $array1_sort_order, $array1_sort_flags, ...$rest);
    $out = [];
    $count = 1;

    foreach(func_get_args() as $arg) {
        if(is_array($arg)) {
            $out["array{$count}"] = $arg;
            #$out["array${count}"] = $arg;
            $count++;
        }
    }

    return $out;
}
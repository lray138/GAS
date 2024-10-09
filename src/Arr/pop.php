<?php namespace lray138\GAS\Arr;

const pop = __NAMESPACE__ . '\pop';

/**
 * by passing in $arr we avoid the mutability, we could potentially allow it
 * via other mechanisms
 * I've probably been using this wrong in the sense that pop should 
 * probably return the array not the item???
 */ 
function pop(array $arr) {
    array_pop($arr);
    return $arr;
}
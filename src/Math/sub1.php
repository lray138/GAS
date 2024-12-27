<?php namespace lray138\GAS\Math;

/** 
 * wonder if this is partial application example or why
 * this is in here
 */

const sub1 = __NAMESPACE__ . '\sub1';

function sub1($x) {
    return subtract($x, 1);
}

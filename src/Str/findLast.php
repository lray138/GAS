<?php namespace lray138\GAS\Str;

const findLast = __NAMESPACE__ . '\findLast';

// the use case for this is kind of null and void , but 
// interesting concept I guess.
// need more on this but leaving for now
/**
 * @note I wonder what the use case was? 2024-05-12@12:28 EST
 */
function findLast($regex, $string) {
    $matches = [];
    preg_match_all($regex, $string, $matches);
    if(count($matches) > 0) {
        return $matches[0][count($matches[0])-1];
    }
    
    return $matches;
}
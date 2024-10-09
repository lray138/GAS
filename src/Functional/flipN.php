<?php namespace lray138\GAS\Functional;

const flipN = __NAMESPACE__ . '\flipN';

/**
 * Function description.
 */
//lstronj functional 
// function flip($callback) {
//     return function () use ($callback) {
//         return $callback(...\array_reverse(\func_get_args()));
//     };
// }

// in this case, flip sort of intercepts 
// in a currying situation anyway, so with
// multiple placeholders (probably academic)
// we need to account for that here (another time)
// April 2, 2020 - 1 AM ;)
function flipN() {
    $args = func_get_args();

    $placeholders = array_filter($args, function($x) {
        return $x === __();
    });

    if(((\count($args) - count($placeholders))-2) >= $args[0]) {
        // apply values to placeholders
        if(count($placeholders) > 0) {
            // reverse for multiple placeholders (probably academic)
            $keys = array_keys($args, __(), true);
            // add 2 to the starting index to account for arity and the closure
            $sliced = array_slice($args, 2 + $args[0], count($placeholders));
            foreach($keys as $i => $key) {
                $args[$key] = $sliced[$i];
            }
        }

        return $args[1](...array_reverse(array_slice($args, 2, $args[0])));
    } else {
        return function() use ($args) {
            return flipN(...$args, ...func_get_args());
        };
    }
}
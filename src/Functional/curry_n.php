<?php namespace lray138\GAS\Functional;

const curry_n = __NAMESPACE__ . '\curry_n';

/**
 * Return a version of the given function where the $count first arguments are curryied.
 *
 * No check is made to verify that the given argument count is either too low or too high.
 * If you give a smaller number you will have an error when calling the given function. If
 * you give a higher number, arguments will simply be ignored.
 * 
 * Note: I'm not sure where this came from, but I think I added the placeholders 
 * from somewhere else
 *
 * @param int $count number of arguments you want to curry
 * @param callable $function the function you want to curry
 * @return callable a curryied version of the given function
 */
function curry_n($count, callable $function, $bind = false) {
    $accumulator = function (array $arguments) use ($count, $function, &$accumulator, $bind) {
        return function (...$newArguments) use ($count, $function, $arguments, $accumulator, $bind) {
            $arguments = \array_merge($arguments, $newArguments);

            $placeholders = array_filter($arguments, function($x) {
                return $x === __();
            });

            // i.e. there may be more arguments than needed, but we meet 
            // the minimum requirements
            if ($count <= (\count($arguments) - count($placeholders))) {

                // need to find indexes of place holders and swap
                if(count($placeholders) > 0) {
                    // reverse for multiple placeholders (probably academic)
                    $keys = array_keys($arguments, __(), true);
                    $sliced = array_slice($arguments, $count, count($placeholders));

                    foreach($keys as $i => $key) {
                        $arguments[$key] = $sliced[$i];
                        // unset incase of default paremeters
                        // otherwise they will be overwritten
                        unset($arguments[$count+$i]);
                        // probably not worth unsetting the placeholder keys
                        //unset($keys[$key]);
                    }
                }

                if($bind) $function = $function->bindTo($bind);
                return \call_user_func_array($function, $arguments);
            }
            
            return $accumulator($arguments);
        };
    };

    return $accumulator([]);
}
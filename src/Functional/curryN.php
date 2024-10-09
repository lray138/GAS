<?php namespace lray138\GAS\Functional;

const curryN = __NAMESPACE__ . '\curryN';

// $count, $callable, $bind = false
// added this as a "gateway" so that it could be
// full functional synatx i.e. curryN(5)(func)(a)(b)(c)
// for my own satisfaction
function curryN() {
    $args = func_get_args();

    if(count($args) === 1) {
        $arity = $args[0];
        return function() use ($arity) {
            $args = func_get_args();
            if(count($args) === 1) {
                $callable = $args[0];
                return curry_n($arity, $callable);
            }
            return curry_n($arity, $callable, ...$args);
        };
    } elseif(count($args) >= 2) {
        return curry_n($args[0], $args[1])(...array_slice($args, 2));
    }

}
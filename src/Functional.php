<?php 
namespace lray138\GAS\Functional;
use lray138\GAS\Arr;

use function lray138\GAS\IO\dump;

function identity($x) { 
    return $x; 
}

const identity = __NAMESPACE__ . '\identity';

function id($x) {
    return $x;
}

const id = __NAMESPACE__ . '\id';

//lstronj functional 
// function flip($callback) {
//     return function () use ($callback) {
//         return $callback(...\array_reverse(\func_get_args()));
//     };
// }

function flipCurry2($callable) {
    return flip(curry2($callable));
}

function flipN() {
    $args = func_get_args();
    if(count($args)-2 >= $args[0]) {
        return $args[1](...array_reverse(array_slice($args, 2, $args[0])));
    } else {
        return function() use ($args) {
            return flipN(...$args, ...func_get_args());
        };
    }
}

function flipCurryN($num, $callable) {
    return flipN($num, curryN($num, $callable));
}

function flip() {
    return call_user_func_array(flipN(2), func_get_args());
}

// adding this now, because I tried to call it flip2, forgetting that I 
// used flip as a default flip 2
function flip2() {
    return call_user_func_array(flipN(2), func_get_args());
}

function flip3() {
    return call_user_func_array(flipN(2), func_get_args());
}

function extract($data) {
    $out = $data instanceof \lray138\GAS\Types\Type 
            ? $data->extract()
            : $data;
    return $out;
}

const extract = __NAMESPACE__ . '\extract';

function arityN($n, $callable, ...$args) {
    if(count($args) >= $n) {
        $result = $callable(...array_slice($args, 0, $n));
        while($result instanceof \Closure) {
            $result = $result(null);
        }
        return $result;
    }

    return function() use ($n, $callable, $args) {
        return call_user_func_array(arityN, array_merge([$n, $callable], $args, func_get_args()));
    };
    // return function() use ($n, $callable) {
    //     $args = func_get_args();
    //     if(count($args) >= $n) {
    //         $result = $callable(...array_slice(func_get_args(), 0, $n));
    //         while($result instanceof \Closure) {
    //             $result = $result(null);
    //         }
    //         return $result;
    //     }

    //     return function() use ($n, $callable, $args) {
    //         return call_user_func_array(arityN($n, $callable), Arr\merge($args, func_get_args()));
    //     };
    // };
}

const arityN = __NAMESPACE__ . '\arityN'; 

// if using map and a function takes only one argumetn
// a warning will be triggered, use this
function unary() {
    // return function($x) use ($function) {
    //     return call_user_func($function, $x);
    // };
    return call_user_func_array(arity1, func_get_args());
}

function flipUnary($callable) {
    return unary(flip($callable));
}

function arity1($cb) {
    $args = func_get_args();
    return arityN(1, Arr\head($args), ...Arr\tail($args));
}

const arity1 = __NAMESPACE__ . '\arity1';

function arity2() {
    $args = func_get_args();
    return arityN(2, Arr\head($args), ...Arr\tail($args));
}

const arity2 = __NAMESPACE__ . '\arity2';

function arity3() {
    $args = func_get_args();
    return arityN(2, Arr\head($args), ...Arr\tail($args));
}

const arity3 = __NAMESPACE__ . '\arity3';

function compose(...$functions) {
    return array_reduce(
        array_reverse($functions),
        function ($carry, $item) {
            return function ($x) use ($carry, $item) {
                return $item($carry($x));
            };
        },
        identity
    );
}

// could almost remove this...
function pipe(...$functions) {
    return compose(...array_reverse($functions));
}

/**
 * Return a version of the given function where the $count first arguments are curryied.
 *
 * No check is made to verify that the given argument count is either too low or too high.
 * If you give a smaller number you will have an error when calling the given function. If
 * you give a higher number, arguments will simply be ignored.
 *
 * @param int $count number of arguments you want to curry
 * @param callable $function the function you want to curry
 * @return callable a curryied version of the given function
 */
function curry_n($count, callable $function, $bind = false) {
    $accumulator = function (array $arguments) use ($count, $function, &$accumulator, $bind) {
        return function (...$newArguments) use ($count, $function, $arguments, $accumulator, $bind) {
            $arguments = \array_merge($arguments, $newArguments);

            if ($count <= \count($arguments)) {
                if($bind) $function = $function->bindTo($bind);
                return \call_user_func_array($function, $arguments);
            }

            return $accumulator($arguments);
        };
    };
    return $accumulator([]);
}

function curryN($count, $callable, $bind = false) {
    return curry_n($count, $callable, $bind);
}

function curry2(callable $function, $bind = false) {
	return curry_n(2, $function);
}

function curry3(callable $function, $bind = false) {
	return curry_n(3, $function);
}

// forgot where I pulled this from
// I don't mind curryN to be honest
function curry($function, $required = true)
{
    if (\method_exists('Closure', 'fromCallable')) {
        // Closure::fromCallable was introduced in PHP 7.1
        $reflection = new ReflectionFunction(Closure::fromCallable($function));
    } else {
        if (\is_string($function) && \strpos($function, '::', 1) !== false) {
            $reflection = new ReflectionMethod($function);
        } elseif (\is_array($function) && \count($function) === 2) {
            $reflection = new ReflectionMethod($function[0], $function[1]);
        } elseif (\is_object($function) && \method_exists($function, '__invoke')) {
            $reflection = new ReflectionMethod($function, '__invoke');
        } else {
            $reflection = new ReflectionFunction($function);
        }
    }

    $count = $required ?
        $reflection->getNumberOfRequiredParameters() :
        $reflection->getNumberOfParameters();

    return curry_n($count, $function);
}

function unit($value) {
    return $monad::unit($value);
}

function bind($monad, $function) {
    return $monad->bind($function);
}

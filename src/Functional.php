<?php 
namespace lray138\GAS\Functional;
use lray138\GAS\Arr;

use function lray138\GAS\IO\dump;

use lray138\GAS\Types\Either;

function identity($x) { 
    return $x; 
}

const identity = __NAMESPACE__ . '\identity';

function id($x) {
    return $x;
}

const id = __NAMESPACE__ . '\id';

function apply() {
    // add type check here
    $f = function($value, $function) {
        return $function->apply($value);
    };

    return curry2($f)(...func_get_args());
}

const apply = __NAMESPACE__ . '\apply';

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
    if(!is_object($data)) return $data;

    if(method_exists($data, "extract")) {
        return $data->extract();
    }

    // get just is from Chem/bingo 
    // get Just is tricky
    if(method_exists($data, "getJust")) {
        return $data->getOrElse("");
    }

    return "";
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


// placeholder for currying
function __() {
    static $placeholder;
    if ($placeholder === null) {
        $placeholder = new \stdClass;
    }
    return $placeholder;
}

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

// haven't had a bind case yet
function curry2(callable $function, $bind = false) {
	return curry_n(2, $function);
}

function curry3(callable $function, $bind = false) {
	return curry_n(3, $function);
}

// I got this from
// https://github.com/lstrojny/functional-php/blob/main/src/Functional/Curry.php
// this is basically a wrapper that calls 
// I would disagree with auto currying required anyway... ?
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

function chain() {
    $f = function($function, $monad) {
        return $monad->bind($function)->extract();
    };

    return curry2($f)(...func_get_args());
}

function bind() {
    $f = function($function, $monad) {
        return $monad->bind($function);
    };

    return curry2($f)(...func_get_args());
}

function not($bool) {
    return !$bool;
}

const not = __NAMESPACE__ . '\not';

// via FunctionalPHP Packt
function filterM(callable $f, $collection)
{
    $monad = $f(head($collection));

    $_filterM = function($collection) use($monad, $f, &$_filterM){
        if(count($collection) == 0) {
            return $monad->of([]);
        }

        $x = head($collection);
        $xs = tail($collection);

        return $f($x)->bind(function($bool) use($x, $xs, $monad, $_filterM) {
            return $_filterM($xs)->bind(function(array $acc) use($bool, $x, $monad) {
                if($bool) {
                    array_unshift($acc, $x);
                }

                return $monad->of($acc);
            });
        });
    };

    return $_filterM($collection);
}

// via FunctionalPHP Packt
function foldM(callable $f, $initial, $collection)
{
    $monad = $f($initial, head($collection));

    $_foldM = function($acc, $collection) use($monad, $f, &$_foldM){
        if(count($collection) == 0) {
            return $monad->of($acc);
        }

        $x = head($collection);
        $xs = tail($collection);

        return $f($acc, $x)->bind(function($result) use($acc, $xs, $_foldM) {
            return $_foldM($result, $xs);
        });
    };

    return $_foldM($initial, $collection);
}

function head($collection) {
    foreach ($collection as $value) {
        return $value;
    }

    return null;
}

function tail($collection) {
    $tail = [];
    $isHead = true;

    foreach($collection as $key => $value) {
        if($isHead) {
            $isHead = false;
            continue;
        }

        $tail[$key] = $value;
    }

    return $tail;
}

function tryCatch(callable $f): Either {
   try {
        return Either::of($f());
    } catch (\Exception $e) {
        return Either::left($e);
    }
}

function Just($value) {
    return Maybe::of($value);
}

function Maybe($value) {
    return Maybe::of($value);
}

function pluck() {
    $f = function($key, $source) {
        if(is_array($source)) {
            return isset($source[$key]) ? $source[$key] : null;
        }

        if(is_object($source)) {
            return isset($source->$key) ? $source->$key : null;
        }
    };

    return curry2($f)(...func_get_args()); 
}

const pluck = __NAMESPACE__ . '\pluck';

function pluckFrom() {
    return flip(pluck)(...func_get_args());
}
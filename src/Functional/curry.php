<?php namespace lray138\GAS\Functional;

const curry = __NAMESPACE__ . '\curry';

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


/**
 * Curry function
 *
 * @param callable $fn
 * @return callable
 */
function _chat_gpt_curry(callable $fn)
{
    $accumulator = function($arguments) use ($fn, &$accumulator) {
        return function(...$args) use ($fn, $arguments, &$accumulator) {
            $mergedArgs = array_merge($arguments, $args);
            $reflection = new ReflectionFunction($fn);
            if ($reflection->getNumberOfRequiredParameters() <= count($mergedArgs)) {
                return $fn(...$mergedArgs);
            }

            return $accumulator($mergedArgs);
        };
    };

    return $accumulator([]);
}
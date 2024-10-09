<?php namespace lray138\GAS\Functional;

const filterM = __NAMESPACE__ . '\filterM';

/**
 * Function description.
 */
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
<?php namespace lray138\GAS\Functional;

const foldM = __NAMESPACE__ . '\foldM';

/**
 * Function description.
 */
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
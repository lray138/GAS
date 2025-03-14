<?php namespace lray138\GAS\Functional;

require __DIR__ . '/Functional/identity.php';
require __DIR__ . '/Functional/id.php';
require __DIR__ . '/Functional/apply.php';
require __DIR__ . '/Functional/flip.php';
require __DIR__ . '/Functional/flipN.php';
require __DIR__ . '/Functional/flipCurryN.php';
require __DIR__ . '/Functional/flipCurry3.php';
require __DIR__ . '/Functional/flip2.php';
require __DIR__ . '/Functional/flip3.php';
require __DIR__ . '/Functional/extract.php';
require __DIR__ . '/Functional/arityN.php';
require __DIR__ . '/Functional/unary.php';
require __DIR__ . '/Functional/flipUnary.php';
require __DIR__ . '/Functional/arity1.php';
require __DIR__ . '/Functional/arity2.php';
require __DIR__ . '/Functional/arity3.php';
require __DIR__ . '/Functional/compose.php';
require __DIR__ . '/Functional/pipe.php';
require __DIR__ . '/Functional/curry_n.php';
require __DIR__ . '/Functional/collect.php';
require __DIR__ . '/Functional/__.php';
require __DIR__ . '/Functional/curryN.php';
require __DIR__ . '/Functional/curry2.php';
require __DIR__ . '/Functional/curry3.php';
require __DIR__ . '/Functional/curry.php';
require __DIR__ . '/Functional/chain.php';
require __DIR__ . '/Functional/bind.php';
require __DIR__ . '/Functional/fold.php';
require __DIR__ . '/Functional/not.php';
require __DIR__ . '/Functional/filterM.php';
require __DIR__ . '/Functional/foldM.php';
require __DIR__ . '/Functional/noOp.php';
require __DIR__ . '/Functional/head.php';
require __DIR__ . '/Functional/path.php';
require __DIR__ . '/Functional/paths.php';
require __DIR__ . '/Functional/tail.php';
require __DIR__ . '/Functional/tryCatch.php';
require __DIR__ . '/Functional/Just.php';
require __DIR__ . '/Functional/Maybe.php';
require __DIR__ . '/Functional/pluck.php';
require __DIR__ . '/Functional/pick.php';
require __DIR__ . '/Functional/pluckFrom.php';
require __DIR__ . '/Functional/map.php';
require __DIR__ . '/Functional/walk.php';
require __DIR__ . '/Functional/filter.php';
require __DIR__ . '/Functional/last.php';
require __DIR__ . '/Functional/extend.php';
require __DIR__ . '/Functional/flatten.php';
require __DIR__ . '/Functional/nullIfEmpty.php';
require __DIR__ . '/Functional/toPath.php';
require __DIR__ . '/Functional/hasPath.php';

function unwrap($x) {
    $x = is_object($x) && method_exists($x, 'extract') ? $x->extract() : $x;
    
    return is_array($x)
        ? array_map("\lray138\GAS\Functional\unwrap", $x)
        : $x;
}

function wrap($x) {
    return \lray138\GAS\Types\wrapType($x);
}
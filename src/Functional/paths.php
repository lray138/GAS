<?php namespace lray138\GAS\Functional;

/* originally from idles PHP */

use lray138\GAS\Types\ArrType;
use function lray138\GAS\dump;

//  ?iterable

const paths = __NAMESPACE__ . '\paths';

function paths(...$args)
{
    return curryN(
        2,
        function (array $paths, $collection) {  
            // I added this to work with objects too
            $collection = is_object($collection) 
                ? $collection
                : collect($collection);  // I don't like collect because it is an array and not the real
                
            $res = [];

            foreach ($paths as $path) {
                $res[] = path($path, $collection);
            }

            return ArrType::of($res);
        }
    )(...$args);
}


/* not sure where this came from, but it's just paths 
with the arguments flipped */
const pathsR = __NAMESPACE__ . '\pathsR';

function pathsR(...$args) {
    return curryN(
        2,
        function ($collection, array $paths) {    
            $collection = is_object($collection) 
                ? $collection
                : collect($collection);
                
            $res = [];
            foreach (flatten($paths) as $path) {
                $res[] = path($path, $collection);
            }
            return ArrType::of($res);
        }
    )(...$args);
}
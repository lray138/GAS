<?php

namespace lray138\GAS\Arr;

use lray138\GAS\Math;
use lray138\GAS\Functional as FP;
use function lray138\GAS\Functional\curry2;
use function lray138\GAS\IO\dump as dump;

/**
 * @param mixed $needle
 * @param array $haystack
 *
 * @return bool
 */
// its dec 3, 2021 and just correcting this for being in 
// wrong functional order...
function contains() {
    $contains = function($needle, $haystack) {
        return in_array($needle, $haystack);
    };

    return call_user_func_array(FP\curry2($contains), func_get_args());
}

function in() {
    return contains(...func_get_args());
}

function chunk() {
    $chunk = function($size, $array) {
        return array_chunk($array, $size);
    };

    return call_user_func_array(FP\curry2($chunk), func_get_args());
}

function values($array) {
    return array_values($array);
}

const values = __NAMESPACE__ . '\values';

/**
 * @param array    $array
 * @param callable $callback
 *
 * @return array
 */
function each()
{
    $walk = function(callable $func, array $array) {
        array_walk($array, $func);
        return $array;
    };
    
    return call_user_func_array(FP\curry2($walk), func_get_args());
}

const each = __NAMESPACE__ . '\each';

/**
 *
 */
function walk() {
    return call_user_func_array(each, func_get_args());
}

/**
 * @param array $array
 * @param array $exclude
 *
 * @return array
 */
function exclude()
{
    $exclude = function($exclude, $array) {
        return array_diff($array, $exclude);
    };

    return call_user_func_array(FP\curry2($exclude), func_get_args());
}

function unshift() {
    $unshift = function($val, $array) {
        array_unshift($array, $val);
        return $array;
    };

    return call_user_func_array(FP\curry2($unshift), func_get_args());
}

function reduce() {
    $reduce = function($callable, $initial, $array) {
        return array_reduce($array, $callable, $initial);
    };
    return call_user_func_array(FP\curry3($reduce), func_get_args());
}

// not workign like I need anyway
function first() {
    $first = function($callable, $array) {
                foreach($array as $key => $val) {
                    if($callable($val, $key)) {
                        return $val;
                    }
                };
                
                return null;
            };
    return call_user_func_array(FP\curry2($first), func_get_args());
}

function find() {
    $f = function($callable, $array) {
        foreach($array as $key => $val) {
            if($callable($val, $key)) {
                return $array[$key];
            }
        }
    };

    return FP\curry2($f)(...func_get_args());
}

const find = __NAMESPACE__ . '\find';


/**
 * @param array    $array
 * @param callable $callback
 *
 * @return array
 */

// array_values to preserve keys or not....
function filter()
{
    $filter = function($func, array $array) {
        return is_null($func) 
                ? array_filter($array) 
                : array_values(array_filter($array, $func));
    };

    return call_user_func_array(FP\curry2($filter), func_get_args());
}

const filter = __NAMESPACE__ . '\filter';

function filterEmpty($array) {
    return array_filter($array);
}

const filterEmpty = __NAMESPACE__ . '\filterEmpty';

/**
 * @param array $array
 *
 * @return int
 */
function length(array $array)
{
    return count($array);
}

function last(array $arr) {
    if(count($arr) > 0) {
        return head(array_reverse($arr));
    } 
    return null;
}

function pluck() {
    $pluck = function($keys, array $array) {
        if(is_array($keys)) {
            $out = [];
            walk(function($x) use ($array, &$out) {
                if(has($x, $array)) $out[] = $array[$x];
            })($keys);
            return $out;
        } 

        return has($keys, $array) ? $array[$keys] : null;
    };
 
    return call_user_func_array(FP\curry2($pluck), func_get_args());
}

const pluck = __NAMESPACE__ . '\pluck';


function pluckOrNull() {
    $pluckOrNull = function($keys, array $array) {
        if(is_array($keys)) {
            $out = [];
            walk(function($x) use ($array, &$out) {
                $out[] = has($x, $array) ? $array[$x] : null;
            })($keys);
            return $out;
        } 

        return has($keys, $array) ? $array[$keys] : null;
    };
 
    return call_user_func_array(FP\curry2($pluckOrNull), func_get_args());
}

function push() {
    $push = function($value, $array) {
        array_push($array, FP\extract($value));
        return $array;
    };

    return call_user_func_array(FP\curry2($push), func_get_args());
}

function pushKeyVal() {
    $pushKeyVal = function($key, $value, $array) {
        $array[$key] = $value;
        return $array;
    };

    return call_user_func_array(FP\curry3($pushKeyVal), func_get_args());
}

function set() {
    $set = function($key, $value, $array) {
        $array[$key] = $value;
        return $array;
    };

    return call_user_func_array(FP\curry3($set), func_get_args());
}

function pluckFrom() {
    return call_user_func_array(FP\flip2(pluck), func_get_args());
}

// function pluckFrom() {
//     $pluckFrom = function(array $array, $key) {
//         return has($key, $array) ? $array[$key] : null;
//     };

//     return call_user_func_array(FP\curry2($pluckFrom), func_get_args());
// }

function tail($array) {
    return array_slice($array, 1);
}

const tail = __NAMESPACE__ . '\tail';

function get() {
    $get = function($key, $array) {
        if(is_null($array) || count($array) === 0) {
            return null;
        }
        return isset($array[$key]) ? $array[$key] : null;
    };

    return call_user_func_array(FP\curry2($get), func_get_args());
} 

const get = __NAMESPACE__ . '\get';

/* 
 *
 * 
 */
function getOrEmptyStr() {
    $f = function($key, $array) {
        $value = get($key, $array);
        return is_null($value) ? "" : $value;
    };

    return FP\curry2($f)(...func_get_args());
}

function toObj(array $array) {
    $object = new \StdClass();
    foreach ($array as $key => $value) {
        $object->$key = $value;
    }
    return $object;
}

/**
 * @param array $array
 * @param mixed $needle
 *
 * @return bool
 *
 * borderline on calling this "hasKey"
 */
function has()
{
    $has = function($needle, array $array) {
        return array_key_exists($needle, $array);
    };

    return call_user_func_array(FP\curry2($has), func_get_args());
}

const has = __NAMESPACE__ . '\has';

function hasKey() {
    return call_user_func_array(has, func_get_args());
}

const hasKey = __NAMESPACE__ . '\hasKey';

function head($array) {
    foreach($array as $key => $val) {
        return $array[$key];
    }
}

const head = __NAMESPACE__ . '\head';

function notIn() {
    $notIn = function($haystack, $needle) {
        return !in_array($needle, $haystack);
    };

    return call_user_func_array(FP\curry2($notIn), func_get_args());
}

/**
 * @param array  $array
 * @param string $glue
 *
 * @return string
 */
function join() {
    $f = function($x, $y) {
        return \join(FP\extract($x), FP\extract($y));
    };

    return FP\curry2($f)(...func_get_args());
}

const join = __NAMESPACE__ . '\join';

function joinKeyVal() {
    $join = function($delimiter, $array) {
        $out = [];
        walk(function($value, $key) use (&$out, &$delimiter) {
            $out[] = $key . $delimiter . $value;
        }, $array);
        return $out;
    };

    return call_user_func_array(FP\curry2($join), func_get_args());
}

function joinEmpty($val) {
    return \join($val);
}

const joinEmpty = __NAMESPACE__ . '\joinEmpty';

function joinE($val) {
    return \join($val);
}

const joinE = __NAMESPACE__ . '\joinE';

const joinKeyVal = __NAMESPACE__ . '\joinKeyVal';

function implode() {
    return call_user_func_array(FP\curry2('\implode'), func_get_args());
}

const implode = __NAMESPACE__ . '\implode';

/**
 * @param callable $callback
 * @param array    $array
 *
 * @return array
 */
function map() {
    $f = function($f, $array) {
        foreach($array as $key => $val) {
            $array[$key] = $f($array[$key]);
        }
        return $array;
    };

    return FP\curry2($f)(...func_get_args());
}

const map = __NAMESPACE__ . '\map';

function _map($fn, $array) {
    foreach($array as $key => $val) {
        $array[$key] = $fn($array[$key]);
    }
    return $array;
}

/**
 * @param array $array
 * @param array $merge
 *
 * @return array
 */
function merge()
{
    return call_user_func_array(FP\curry2("array_merge"), func_get_args());
}

/**
 * @param array $array
 * @param int   $offset
 * @param int   $limit
 *
 * @return array
 */
function slice() {
    $slice = function($offset, $limit, array $array) {
        if ($limit == 0) {
            return array_slice($array, $offset);
        }

        return array_slice($array, $offset, $limit);
    };

    return call_user_func_array(FP\curry3($slice), func_get_args());
}

/**
 * @param array $array
 * @param int   $offset
 * @param int   $limit
 *
 * @return array
 */
function sliceNormal(array $array, $offset = 0, $limit = 0)
{
    if ($limit == 0) {
        return array_slice($array, $offset);
    }

    return array_slice($array, $offset, $limit);
}

/**
 * @param array $array
 *
 * @return mixed
 */
function random(array $array)
{
    if (length($array) === 0) {
        return null;
    }

    $index = Math\random(0, length($array) - 1);

    return $array[$index];
}

function toUl(array $array) {
    $mapped = implode("", map(function($x) {
        return "<li>" . $x . "</li>";
    }, $array));

    return "<ul>" . $mapped . "</ul>";
}

const toUl = __NAMESPACE__ . '\toUl';

function toXMLString(array $array) {
    $xml = \GAS\Array2XML\Array2XML::createXML('root', $array);
    $root = $xml->getElementsByTagname("text")->item(0);
    return $xml->saveXML($root);
    //return \GAS\Array2XML($array);
}

// https://stackoverflow.com/questions/526556/how-to-flatten-a-multi-dimensional-array-to-simple-one-in-php/15939539
function flatten(array $array) {
    $return = array();
    foreach ($array as $key => $value) {
       if (is_array($value)){ $return = array_merge($return, flatten($value));}
       else {$return[$key] = $value;}
    }
   return $return;
}

const flatten = __NAMESPACE__ . '\flatten';

//https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
function isAssoc(array $array) {
    $keys = array_keys($array);
        return array_keys($keys) !== $keys;
}
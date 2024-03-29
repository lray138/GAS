<?php

namespace lray138\GAS\Arr;

use lray138\GAS\Math;
use lray138\GAS\Functional as FP;
use lray138\GAS\HTML;
use lray138\GAS\Types\ArrType;
use function lray138\GAS\Functional\curry2;
use function lray138\GAS\IO\dump as dump;

/**
 * @param mixed $needle
 * @param array|ArrType $haystack
 *
 * @return bool
 */
function contains() {
    $f = function($needle, $haystack): bool {
        return in_array($needle, $haystack);
    };

    return FP\curry2($f)(...func_get_args());
}

function of(array $arr) {
    return ArrType::of($arr);
}

function some($callable, $arr) {
    foreach($arr as $a) {
        if($callable($a)) return true;
    }
    return false;
}

const some = __NAMESPACE__ . '\some';

/**
 * @param int $size
 * @param array|ArrType $haystack
 *
 * @return array
 */
function chunk() {
    $f = function($size, $array) {
        return array_chunk(FP\extract($array), $size);
    };

    return call_user_func_array(FP\curry2($f), func_get_args());
}


function values($array) {
    return array_values($array);
}

const values = __NAMESPACE__ . '\values';

/**
 * @param array|ArrType $array
 * @param callable      $callback
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

function keyExists() {
    $f = function($key, $array) {
        return array_key_exists($key, FP\extract($array));
    };

    return FP\curry2($f)(...func_get_args());
}

function reverse(array $array) {
    return array_reverse($array);
}

const reverse = __NAMESPACE__ . '\reverse';

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

function last($arr) {
    if(count($arr) > 0) {
        return head(array_reverse($arr));
    } 
    return null;
}

function pop($arr) {
    return array_pop(FP\extract($arr));
}

// if multiple keys are provided it acts like
// pick ? or some other whatever function
function pluck() {
    $f = function($keys, $array) {
        $array = FP\extract($array);

        // if(is_array($keys)) {
        //     $out = [];
        //     walk(function($x) use ($array, &$out) {
        //         if(has($x, $array)) $out[] = $array[$x];
        //     })($keys);
        //     return $out;
        // } 

        if(!is_array($keys)) $keys = [$keys];

        foreach($keys as $key) {
            if(isset($array[$key])) {
                return $array[$key];
            }
        }

        return null;
        //return has($keys, $array) ? $array[$keys] : null;
    };
 
    return FP\curry2($f)(...func_get_args());
}

const pluck = __NAMESPACE__ . '\pluck';


// if multiple keys are provided it acts like
// pick ? or some other whatever function
function pick() {
    $f = function($keys, $array) {
        $array = FP\extract($array);

        if(!is_array($keys)) $keys = [$keys];

        $out = [];
        foreach($keys as $key) {
            if(isset($array[$key])) {
                $out[$key] = $array[$key];
            }
        }

        return $out;
        //return has($keys, $array) ? $array[$keys] : null;
    };
 
    return FP\curry2($f)(...func_get_args());
}

const pick = __NAMESPACE__ . '\pick';

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

function pluckOr() {
    $f = function($key, $else, $arr) {
        $plucked = pluck($key, $arr);

        if(!is_null($plucked)) return $plucked;

        return is_callable($else) 
            ? $else($arr) 
            : $else;
    };

    return FP\curry3($f)(...func_get_args());
}

const pluckOr = __NAMESPACE__ . '\pluckOr';

function pluckFromOr() {
    return FP\flipN(3)(pluckOr)(...func_get_args());
}

function pluckFromOrElse() {
    return pluckFromOr(...func_get_args());
}

function push() {
    // catch 22 here because in some cases we want the 
    // ArrType to be pushed...
    // maybe that I just started applying extract where it 
    // didn't need to be, if it was combine or something of that nature????
    // I guess this is where we go "next" level with the functional understanding
    $push = function($value, $array) {
        if($array instanceof ArrType) {
           return $array->push($value);
        }

        array_push($array, $value);
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
        if(!is_array($array)) {
            return null;
        }

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
 * @note there was a reason for the foreach but
 * i forget why
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

// https://github.com/lstrojny/functional-php/blob/main/src/Functional/FlatMap.php
// was recommended from 
// https://gist.github.com/davidrjonas/8f820ab0c75534b45189eba1d1fbeb23
function flatMap() {
    $f = function($f, $array) {
        return array_merge([], ...array_map($fn, $array));
    };

    return FP\curry2($f)(...func_get_args());
};

/**
 * @param array $array
 * @param array $merge
 *
 * @return array
 */
function merge() {
    $f = function($merge, $with) {
        // if($with instanceof ArrType) {
        //    return $with->merge($merge);
        // }

        $with = FP\extract($with);
        $merge = FP\extract($merge);

        if(is_null($merge)) {
            return $with;
        }

        return array_merge($with, $merge);
    };

    return FP\curry2($f)(...func_get_args());
}

function mergeLeft() {
    $f = function($with, $merge) {
        // if($with instanceof ArrType) {
        //    return $with->merge($merge);
        // }

        $with = FP\extract($with);
        $merge = FP\extract($merge);

        if(is_null($merge)) {
            return $with;
        }

        return array_merge($with, $merge);
    };

    return FP\curry2($f)(...func_get_args());
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

function toUl(array $array, $attributes = []) {
    $mapped = implode("", map(function($x) {
        return "<li>" . $x . "</li>";
    }, $array));

    return HTML\ul($mapped, $attributes);
}

const toUl = __NAMESPACE__ . '\toUl';

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


function isEmpty(array $array) {
    return count($array) === 0;
}

const isEmpty = __NAMESPACE__ . '\isEmpty';

function addIndexKey(array $data) {

    dump($data);


    dump(array_flip(array_fill_keys(
        range(0, count(array_values($data)))
        , "index"
    )));
    return $data;
}
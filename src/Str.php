<?php

namespace lray138\GAS\Str;

use lray138\GAS\{
    Arr,
    Functional as FP,
    Types
};

use function lray138\GAS\Functional\{curry3, curry2};
use function lray138\GAS\IO\dump;

const DOUBLE_QUOTE = '"';
const SINGLE_QUOTE = "'";

function of($value) {
    return Types\Str::of($value);
}

const toInt = __NAMESPACE__ . '\toInt';

function toInt(string $str) {
    return (int) $str;
}

function contains() {
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) === false) {
                    return false;
                }
            }
            return true;
        }
        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}

function containsAny() {
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) !== false) {
                    return true;
                }
            }
            return false;
        }
        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}

function containsNone() {
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) !== false) {
                    return false;
                }
            }
            return true;
        }
        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}

function containsAll() {
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) === false) {
                    return false;
                }
            }
            return true;
        }
        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}

const contains = __NAMESPACE__ . '\contains';

function addLeadingZero($number) {
    if($number < 10) {
        return "0$number";
    }
    return (string) $number;
}

const addLeadingZero = __NAMESPACE__ . '\addLeadingZero';

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isExpression($variable) {
    return isRegex($variable);
}

function isRegex($variable) {
    return Types\isExpression($variable);
}

// this is kind of borderline here... may belong in
// something else... like it'w on.. and then do 'from' or 'of'
// not the query selector way... https://stackoverflow.com/questions/1205751/php5-find-root-node-in-domdocument
function toHTML5DOM(string $element, $select = "body") {
    $dom = new \IvoPetkov\HTML5DOMDocument();
    $dom->loadHTML($element);
    return $dom->documentElement->firstElementChild;
}

/* 
str_pad(
    string $string,
    int $length,
    string $pad_string = " ",
    int $pad_type = STR_PAD_RIGHT
): string
*/
function padLeftN() {
    $padLeftN = function($n, $delimeter, $string) {
        $out = \str_pad($string, $n, $delimeter, STR_PAD_LEFT);
        return $out;
    };

    return call_user_func_array(FP\curry3($padLeftN), func_get_args());
}

const padLeftN = __NAMESPACE__ . '\padLeftN';

function padLeft() {
    return call_user_func_array(padLeftN(1), func_get_args());
}

const padLeft = __NAMESPACE__ . '\padLeft';

// the use case for this is kind of null and void , but 
// interesting concept I guess.
// need more on this but leaving for now
function findLast($regex, $string) {
    $matches = [];
    preg_match_all($regex, $string, $matches);
    if(count($matches) > 0) {
        return $matches[0][count($matches[0])-1];
    }
    
    return $matches;
}

function findFirst($regex, $string) {
    $matches = [];
    preg_match($regex, $string, $matches);
    return $matches;
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isArray($variable) {
    return Types\isArray($variable);
}

function afterNth() {
    $f = function($n, $delimiter, $string) {
        $bits = explode($delimiter, $string);
        $sliced = array_slice($bits, $n);
        return implode("/", $sliced);
    };

    return FP\curry3($f)(...func_get_args());
}

function beforeNth() {
    $f = function($n, $delimiter, $string) {
        $out = [];

        // if($n < 0) {
        //     return afterNth($n, $delimiter, implode("/", array_reverse(explode("/", $string))));
        // }

        $bits = explode($delimiter, $string);
        foreach($bits as $key => $bit) {
            if($key === $n) break;
            $out[] = $bit;
        }

        return implode("/", $out);
    };

    return FP\curry3($f)(...func_get_args());
}

// for example, after last '.' for extension, but 
// we want to include the delimiter for better matching
function afterLast() {
    $afterLast = function($substring, $string, $include_delimeter = false) {
        $index = strrpos($string, $substring);
        // if we wanted to include the character we would not add 1... 
        $start = ($index !== 0) ? $index + 1 : strlen($substring);
        $length = ($index !== 0) ? strlen($string)-$index : (strlen($string) - strlen($substring));
        $out = $index === false ? $string : substr($string, $start, $length);
        return $include_delimeter ? $substring . $out : $out;
    };
    return curry2($afterLast)(...func_get_args());
}

function afterFirst() {
    $afterFirst = function($needle, $haystack) {
        return Arr\join($needle, Arr\tail(explode($needle, $haystack)));
    };

    return call_user_func_array(curry2($afterFirst), func_get_args());
}

const afterFirst = __NAMESPACE__ . '\afterFirst';

function beforeFirst() {
    $f = function($needle, $haystack) {
        return FP\compose(
            Arr\head,
            Arr\filterEmpty,
            explode($needle)
        )($haystack);
    };

    return curry2($f)(...func_get_args());
}

// added trim right so that I can .. hmmm...
function beforeLast() {
    $beforeLast = function($substring, $string, $trim_right = false) {
        $index = strrpos($string, $substring, 0);
        if($trim_right) {
            $index++;
        }
        return $index === false ? $string : substr($string, 0, $index);
    };
    return call_user_func_array(curry2($beforeLast), func_get_args());
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function startsWith() {
    $startsWith = function($needle, $haystack) {
        if (isExpression($needle)) {
            return startsWithExpression($haystack, $needle);
        }

        return startsWithString($haystack, $needle);
    };
    
    return call_user_func_array(curry2($startsWith), func_get_args());
}

const startsWith = __NAMESPACE__ . '\startsWith';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function startsWithString($haystack, $needle)
{
    return slice($haystack, 0, length($needle)) === $needle;
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function startsWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return matches($haystack, "#^{$pattern}#");
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWith()
{
    $endsWith = function($needle, $haystack) {
        if (isExpression($needle)) {
            return endsWithExpression($haystack, $needle);
        }

        return endsWithString($haystack, $needle);
    };

    return call_user_func_array(curry2($endsWith), func_get_args());
}

function equals(string $compare, string $to = "") {
    $f = function($compare, $to): bool {
        return $compare === $to;
    };
    return FP\curryN(2, $f)(...func_get_args());
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWithString($haystack, $needle)
{
    return slice($haystack, -1 * length($needle)) === $needle;
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWithExpression($haystack, $needle) {
    $pattern = slice($needle, 1, length($needle) - 2);
    
    return matches($haystack, "#{$pattern}$#");
}

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $offset
 *
 * @return int
 */
function indexOf($haystack, $needle, $offset = 0)
{
    if (isExpression($needle)) {
        return indexOfExpression($haystack, $needle, $offset);
    }

    return indexOfString($haystack, $needle, $offset);
}

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $offset
 *
 * @return int
 */
function indexOfString($haystack, $needle, $offset = 0)
{
    $index = -1;

    if (($match = strpos($haystack, $needle, $offset)) !== false) {
        $index = $match;
    }

    return $index;
}

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $offset
 *
 * @return int
 */
function indexOfExpression($haystack, $needle, $offset = 0)
{
    $index = -1;

    if (preg_match($needle, $haystack, $matches, PREG_OFFSET_CAPTURE, $offset)) {
        $index = $matches[0][1];
    }

    return $index;
}

/**
 * @param string $string
 *
 * @return int
 */
function length($string)
{
    return strlen($string);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matches() {
    $matches = function($haystack, $needle) {

        if (isExpression($haystack)) {
            return matchesExpression($haystack, $needle);
        }

        return matchesString($haystack, $needle);
    };

    return call_user_func_array(FP\curry2($matches), func_get_args());
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matchesString($haystack, $needle)
{
    if ($needle === $haystack) {
        return true;
    }

    return false;
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matchesExpression($haystack, $needle)
{
    //preg_match(pattern, subject)
    if (preg_match($haystack, $needle)) {
        return true;
    }

    return false;
}

function _match() {
    $match = function($pattern, $subject) {
        $matches = [];
        preg_match($pattern, $subject, $matches);
        return $matches;
    };

    return call_user_func_array(curry2($match), func_get_args());
}

function matchOne() {

}

function matchAll() {
    $matchAll = function($pattern, $subject) {
        $matches = [];
        $count = preg_match_all($pattern, $subject, $matches);

        if($count === 0) {
            return false;
        }

        $head = array_shift($matches);
        $tail = $matches;

        $out = [];
        for ($i = 0; $i < $count; $i++) {
            $match = ["full" => $head[$i]];
            foreach($tail as $key => $t) {
               $match["group_" . ($key+1)] = $t[$i];
            }
            $out[] = $match;
        }

        return $out;
    };

    return call_user_func_array(curry2($matchAll), func_get_args());
}

const matchAll = __NAMESPACE__ . '\matchAll';

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 *
 * @return string
 */
function replace()
{
    //$haystack, $needle, $replacement
    $replace = function($needle, $replacement, $haystack) {
        if (isArray($needle)) {
            if(!isArray($replacement)) {
                return replaceWithArray($needle, [$replacement], $haystack);
            }
            return replaceWithArray($needle, $replacement, $haystack);
        }

        if (isExpression($needle)) {
            return replaceWithExpression($needle, $replacement, $haystack);
        }

        return replaceWithString($needle, $replacement, $haystack);
    };

    return call_user_func_array(curry3($replace), func_get_args());
}

const replace = __NAMESPACE__ . '\replace';

/**
 * @param string $haystack
 * @param array  $needle
 * @param array  $replacement
 *
 * @return string
 */
function replaceWithArray(array $needle, array $replacement, $haystack)
{
    foreach ($needle as $i => $next) {
        $replace_with = count($replacement) === 1 ? $replacement[0] : $replacement[$i];
        $haystack = replace($next, $replace_with, $haystack);
    }
    return $haystack;
}

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 *
 * @return string
 */
function replaceWithString() {
    $replaceWithString = function($needle, $replacement, $haystack) {
        return str_replace($needle, $replacement, $haystack);
    };

    return call_user_func_array(curry3($replaceWithString), func_get_args());
}

/**
 * @param string       $haystack
 * @param string|array $needle
 * @param string|array $replacement
 *
 * @return string
 */
function replaceWithExpression() {
    $replaceWithExpression = function($needle, $replacement, $haystack) {
        return (string) preg_replace($needle, $replacement, $haystack);
    };

    return call_user_func_array(curry3($replaceWithExpression), func_get_args());
}

/**
 * @param string $string
 * @param int    $offset
 * @param int    $limit
 *
 * @return string
 */
function slice($string, $offset = 0, $limit = 0)
{
    if ($limit == 0) {
        return substr($string, $offset);
    }

    return substr($string, $offset, $limit);
}

/**
 * @param string      $haystack
 * @param string|null $needle
 * @param int         $limit
 *
 * @return array
 */
function split($haystack, $needle = null, $limit = 0)
{
    if ($needle === null) {
        return splitWithNull($haystack, $limit);
    }

    if (isExpression($needle)) {
        return splitWithExpression($haystack, $needle, $limit);
    }

    return splitWithString($haystack, $needle, $limit);
}

/**
 * @param string $haystack
 * @param int    $limit
 *
 * @return array
 */
function splitWithNull($haystack, $limit = 0)
{
    if ($limit === 0) {
        return str_split($haystack);
    }

    return str_split($haystack, $limit);
}

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $limit
 *
 * @return array
 */
function splitWithString($haystack, $needle, $limit = 0)
{
    if ($limit === 0) {
        return explode($needle, $haystack);
    }

    return explode($needle, $haystack, $limit);
}

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $limit
 *
 * @return array
 */
function splitWithExpression($haystack, $needle, $limit = 0)
{
    if ($limit === 0) {
        return preg_split($needle, $haystack);
    }

    return preg_split($needle, $haystack, $limit);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 * updating on Sat FEB 18, 2022, cause this is backwards actually
 */
function trim() {
    $f = function($needle, $haystack) {
        if (isExpression($needle)) {
            return trimWithExpression($haystack, $needle);
        }

        return trimWithString($needle, $haystack);
    };

    return FP\curry2($f)(...func_get_args());
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 * 
 *  this code was from Chris Pitt typed PHP book, but was not in 
 *  what I consider "functional order"
 *  ok, here's the prob then I switched it up there and not everywhere... 
 */
function trimWithString($characters, $string) {
    return is_null($characters) ? \trim($string) : \trim($string, $characters);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return (string) preg_replace("#^{$pattern}|{$pattern}$#", "", $haystack);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimLeft($needle, $haystack) {
    if (isExpression($needle)) {
        return trimLeftWithExpression($haystack, $needle);
    }
    return trimLeftWithString($haystack, $needle);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string 
 * I think this is Chris Pitt code.
 */
function trimLeftWithString($haystack, $needle) {
    
    return \ltrim($haystack, $needle);
}

function ltrim() {
    $f = function($needle, $haystack) {
        return \ltrim($haystack, $needle);
    };

    return FP\curry2($f)(...func_get_args());
}

function rtrim() {
    $f = function($needle, $haystack) {
        return \rtrim($haystack, $needle);
    };
    return FP\curry2($f)(...func_get_args());
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimLeftWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return (string) preg_replace("#^{$pattern}#", "", $haystack);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimRight($needle, $haystack)
{
    if (isExpression($needle)) {
        return trimRightWithExpression($haystack, $needle);
    }

    return trimRightWithString($haystack, $needle);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimRightWithString($haystack, $needle)
{
    return \rtrim($haystack, $needle);
}

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimRightWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return (string) preg_replace("#{$pattern}$#", "", $haystack);
}

// adding this because I tried to use concat like this,
// I thought I had a function that did this, but it looks like
function join($delimeter, $bits = null) {
    if(!is_null($bits)) {
        return implode($delimeter, array_slice(func_get_args(), 1));
    }

    return function(...$args) use ($delimeter) {
        return implode($delimeter, $args);
    };
}

function concat() {

    return count(func_get_args()) > 1 
        ? concatN(count(func_get_args()), ...func_get_args())
        : concatN(2, ...func_get_args());

   
    // $concat = function($x, $y) {
    //     return is_array($x) 
    //         ? \implode($x) . $y 
    //         : $x . $y;
    // };
    
    // return call_user_func_array(curry2($concat), func_get_args());
}

const concat = __NAMESPACE__ . '\concat';

function concatN() {
    $args = func_get_args();

    $filtered = Arr\filter(function($x) {
        return $x instanceof \lray138\GAS\Functional\Placeholder === false;
    }, $args);

    if(count($filtered)-1 < $args[0]) {
       return function() use ($args) {
            return concatN(...$args, ...func_get_args());
       };
    }

    $f = function() use ($args, $filtered) {
        $bits = func_get_args();
        $out = "";

        for ($i = 0; $i < count($bits); $i++) { 
            $out .= $bits[$i];
        }

        return $out;
    };

    return FP\curryN($args[0], $f, ...Arr\tail($args));
}

// this didn't work with placeholders
function concatNOld() {
    $args = func_get_args();

    if(count($args)-1 >= $args[0]) {

        return implode(array_slice($args, 1));

        // return array_reduce(
        //     array_slice($args, 1)
        //     , function($carry, $value) {
        //         return concat($carry, $value);
        //     }, "");

    } else {
        return function() use ($args) {
            return concatN(...$args, ...func_get_args());
        };
    }

}

function firstChar($string) {
    return substr($string, 0, 1);
}

function lastChar($string) {
    return substr($string, strlen($string)-1, 1);
}

function lastCharIs() {
    $lastCharIs = function($char, $string) {
        return substr($string, strlen($string)-1, 1) === $char;
    };

    return call_user_func_array(curry2($lastCharIs), func_get_args());
}

function prepend() {
    $prepend = function($prepend, $to) {
        return concat($prepend, $to);
    };

    return call_user_func_array(curry2($prepend), func_get_args());
}

function append() {
    $append = function($append, $to) {
        return concat($to, $append);
    };

    return call_user_func_array(curry2($append), func_get_args());
}

function wrap() {
    $wrap = function($a, $b, $c) {
        return $a . $c . $b;
    };

    return call_user_func_array(curry3($wrap), func_get_args());
}

function kebalbCaseToPascal($str) {
    return str_replace("-", "", ucwords($str, "-"));
}

function kebalbCaseToCamel($str) {
    return lcfirst(kebalbCaseToPascal($str));
}

function toCamelCase($str) {
    return lcfirst(str_replace(" ", "", ucwords($str, " ")));
}

function slugToCamelCase($str) {
    return str_replace("-", "", ucwords($str, "-"));
}

function slugify($str) {
    return strtolower(str_replace(" ", "-", $str));
}

function XMLToArray($xml) {
    $previous_value = libxml_use_internal_errors(true);
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false; 
    $dom->loadXml($xml);
    libxml_use_internal_errors($previous_value);
    if (libxml_get_errors()) {
        return [];
    }
    return DOMToArray($dom);
}

function DOMToArray($root) {
    $result = array();

    if ($root->hasAttributes()) {
        $attrs = $root->attributes;
        foreach ($attrs as $attr) {
            $result['@attributes'][$attr->name] = $attr->value;
        }
    }

    if ($root->hasChildNodes()) {
        $children = $root->childNodes;
        if ($children->length == 1) {
            $child = $children->item(0);
            if (in_array($child->nodeType,[XML_TEXT_NODE,XML_CDATA_SECTION_NODE])) {
                $result['_value'] = $child->nodeValue;
                return count($result) == 1
                    ? $result['_value']
                    : $result;
            }

        }
        $groups = array();
        foreach ($children as $child) {
            if (!isset($result[$child->nodeName])) {
                $result[$child->nodeName] = DOMToArray($child);
            } else {
                if (!isset($groups[$child->nodeName])) {
                    $result[$child->nodeName] = array($result[$child->nodeName]);
                    $groups[$child->nodeName] = 1;
                }
                $result[$child->nodeName][] = DOMToArray($child);
            }
        }
    }
    return $result;
}

// may or may not be a Str object
function extract($str) {
    if($str instanceof \GAS\Types\Str) {
        $str = $str->extract();
    }
    return $str;
}

function explode() {
    return call_user_func_array(curry2("explode"), func_get_args());
}

const extract = __NAMESPACE__ . '\extract';

//https://stackoverflow.com/questions/161738/what-is-the-best-regular-expression-to-check-if-a-string-is-a-valid-url


function toUpper($str) {
    return strtoupper($str);
}

const toUpper = __NAMESPACE__ . '\toUpper';

// https://www.php.net/manual/en/function.number-format.php
// https://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
function numberFormat($number) {
    return number_format($number);
}

function removeQuotes($str) {
    return replace(["'", '"'], '', $str);
}

const removeQuotes = __NAMESPACE__ . '\removeQuotes';
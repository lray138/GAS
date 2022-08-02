<?php

namespace lray138\GAS\Types;

use function lray138\GAS\dump;

/* was named Types, but want that for the folder
code from/based on Typed PHP by Christopher Pitt 
*/

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isNumber($variable) {
    return is_integer($variable) or is_float($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isBoolean($variable) {
    return is_bool($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isNull($variable)
{
    return is_null($variable) || isNothing($variable);
}

function isType($variable)
{
     return $variable instanceof \lray138\GAS\Types\Type;
}


function isError($variable)
{
     return $variable instanceof \lray138\GAS\Types\Error;
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isNothing($variable)
{
    return is_null($variable) || $variable instanceof \lray138\GAS\Types\None || $variable instanceof \lray138\GAS\Types\Nothing;
}

const isNothing = __NAMESPACE__ . '\isNothing';

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isObject($variable)
{
    return is_object($variable) and !isFunction($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isFunction($variable) {
    return is_callable($variable) and is_object($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isExpression($variable)
{
    return isRegex($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isRegex($variable)
{
    // Sun Apr 17 2020 @ 19:44 got error because of the order of these things
    // when it was an array, and basically was getting an error when an array was passed...
    // so for now just putting if 1 string... 

    if(!is_string($variable)) return false;

    // I added this because it was choking on "<hr>" for HTML cleanup
    $notVoidTag = implode([substr($variable, 0, 1), substr($variable, strlen($variable)-1, 1)]) !== "<>";
    
    $isNotFalse = @preg_match($variable, "") !== false;
    $hasNoError = preg_last_error() === PREG_NO_ERROR;
    return $isNotFalse and $hasNoError && $notVoidTag;
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isString($variable)
{
    return is_string($variable) and !isExpression($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isResource($variable)
{
    return is_resource($variable);
}

/**
 * @param mixed $variable
 *
 * @return bool
 */
function isArray($variable)
{
    return is_array($variable);
}

function isArr($variable) {
    return is_a($variable, __NAMESPACE__ . '\ArrType');
}

/**
 * @param mixed $variable
 *
 * @return string
 */
function getType($variable) {
    $functions = [
        "isNumber" => "number",
        "isBoolean" => "boolean",
        "isNull" => "null",
        "isObject" => "object",
        "isFunction" => "function",
        "isExpression" => "expression",
        "isString" => "string",
        "isResource" => "resource",
        "isArray" => "array"
    ];

    $result = "unknown";

    foreach ($functions as $function => $type) {
        $qualified = "lray138\\GAS\\Types\\{$function}";

        if ($qualified($variable)) {
            $result = $type;
            break;
        }
    }

    return $result;
}

function wrap($variable) {
    return wrapType($variable);
}

const wrap = __NAMESPACE__ . '\wrap';

function wrapType($variable) {
    // no need to wrap if it's already a type
    if($variable instanceof Type) {
        return $variable;
    }

    $result = "Error";

    $types = [
        "number" => "Number",
        "boolean" => "Boolean",
        "null" => "Nothing", // changed from None
        "expression" => "StrType",
        "string" => "StrType", // was Str (it's StrType to avoid confusion with functions Str)
        "array" => "ArrType"  // was Arr (same as above)
    ];

    $type = getType($variable);

    $object_types = [
        "DateTime" => "\lray138\GAS\Types\Time"
        , "Moment\MomentFromVo" => "\lray138\GAS\Types\Time"
    ];

    if($type === "object") {
        $class = get_class($variable);
        if(isset($object_types[$class])) {
            return $object_types[$class]::of($variable);
        }

        // this is not right
        //return call_user_func("\\lray138\\GAS\\Types\\" . $result . "::of", $class);
        return $variable;
    }

    if(isset($types[$type])) {
        $result = $types[$type];
    } else {
        $variable = "Type for value '" . $variable . "' can not be determined";
    }

    return call_user_func("\\lray138\\GAS\\Types\\" . $result . "::of", $variable);
}

const wrapType = __NAMESPACE__ . '\wrapType';

function Arr($value = []) {
    return ArrType::of($value);
}

const Arr = __NAMESPACE__ . '\Arr';

function Many($value = null) {
    return Many::of($value);
}

function Maybe($value =  null) {
    return Maybe::of($value);
}

const Maybe = __NAMESPACE__ . '\Maybe';

function Some($value) {
    return Some::of($value);
}

const Some = __NAMESPACE__ . '\Some';

function Str($value = "") {
    return StrType::of($value);
}

const Str = __NAMESPACE__ . '\Str';

function None() {
    return None::of();
}

const None = __NAMESPACE__ . '\None';

function Nothing() {
    return Nothing::of();
}

const Nothing = __NAMESPACE__ . '\Nothing';

function Error($message) {
    return Error::of($message);
}

const Error = __NAMESPACE__ . '\Error';

function Either($value) {
    return \lray138\GAS\Types\Either::of($value);
}

const Either = __NAMESPACE__ . '\Either';

function Left($message) {
    $out = \lray138\GAS\Types\Either\Left::of($message);
    return $out;
}

const Left = __NAMESPACE__ . '\Left';

function Right($value) {
    return \lray138\GAS\Types\Either\Right::of($value);
}

const Right = __NAMESPACE__ . '\Right';


function Model() {
    $f = function($table, $db) {
        return new Model($table, $db);
    };

    return \lray138\GAS\Functional\curry2($f)(...func_get_args()); 
}

function Calendar() {
    return \lray138\GAS\Types\Calendar::of();
}

function Time($datetime = null) {
    return \lray138\GAS\Types\Time::of($datetime);
}

const Time = __NAMESPACE__ . '\Time';

function Number($number = null) {
    return is_null($number)
        ? \lray138\GAS\Types\Number::of(0)
        : \lray138\GAS\Types\Number::of($number);
}

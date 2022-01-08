<?php

namespace lray138\GAS\Types;

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
    return is_null($variable);
}

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

/**
 * @param mixed $variable
 *
 * @return string
 */
function getType($variable)
{
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
        $qualified = "GAS\\Functions\\Types\\{$function}";

        if ($qualified($variable)) {
            $result = $type;
            break;
        }
    }

    return $result;
}

function wrapType($variable) {

    $result = "unknown";

    $types = [
        "number" => "Number",
        "boolean" => "Boolean",
        "null" => "None",
        "string" => "Str",
        "array" => "Arr"
    ];

    $result = $types[getType($variable)];

    if($result === "unknown") {

    } else {
        return call_user_func("\\GAS\\Types\\" . $result . "::of", $variable);
    }

}

const wrapType = __NAMESPACE__ . '\wrapType';

function Arr($value = []) {
    return ArrType::of($value);
}

function Many($value = null) {
    return Many::of($value);
}

function Maybe($value =  null) {
    return Maybe::of($value);
}

function Str($value = "") {
    return StrType::of($value);
}
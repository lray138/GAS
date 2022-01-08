<?php

namespace lray138\GAS\Math;

/* think this is from/based on Typed PHP (Chris Pitt) */

use lray138\GAS\Functional as FP;
use function func_get_args as args;

/**
 * @param int|float $number
 *
 * @return float
 */
function absolute($number)
{
    return (float) \abs($number);
}

/**
 * @param int|float
 * @param int|float
 *
 * @return float
 */
function add() {
    $f = function($x, $y) {
        return (float) $x + (float) $y;
    };

    return FP\curry2($f)(...func_get_args());
}

/**
 * @param int|float $number
 *
 * @return float
 */
function arcCosine($number)
{
    return (float) \acos($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function arcSine($number)
{
    return (float) \asin($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function arcTangent($number)
{
    return (float) \atan($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function cosine($number)
{
    return (float) \cos($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function exponent($number)
{
    return (float) \exp($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function hyperbolicCosine($number)
{
    return (float) \cosh($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function hyperbolicSine($number)
{
    return (float) \sinh($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function hyperbolicTangent($number)
{
    return (float) \tanh($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function arcHyperbolicCosine($number)
{
    return (float) \acosh($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function arcHyperbolicSine($number)
{
    return (float) \asinh($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function arcHyperbolicTangent($number)
{
    return (float) \atanh($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function logarithm($number)
{
    return (float) \log($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function sine($number)
{
    return (float) \sin($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function squareRoot($number)
{
    return (float) \sqrt($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function tangent($number)
{
    return (float) \tan($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function degrees($number)
{
    return (float) \rad2deg($number);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function radians($number)
{
    return (float) \deg2rad($number);
}


/**
 * @param int|float $number
 * @param int|float $divisor
 *
 * @return float
 */
function modulus($number, $divisor)
{
    return (float) \fmod($number, $divisor);
}

/**
 * @param int|float $number
 * @param int|float $power
 *
 * @return float
 */
function power($number, $power)
{
    return (float) \pow($number, $power);
}

/**
 * @param int|float $number
 *
 * @return float
 */
function round($number)
{
    return (float) \round($number);
}

function roundTo() {
    $roundTo = function($decimals, $number) {
        return (float) \round($number, $decimals);
    };

    return call_user_func_array(FP\curry2($roundTo), func_get_args());
}

/**
 * @param int|float $number
 *
 * @return int
 */
function ceiling($number)
{
    return (int) \ceil($number);
}

/**
 * @param int|float $number
 *
 * @return int
 */
function floor($number)
{
    return (int) \floor($number);
}

/**
 * @param int|float $min
 * @param int|float $max
 *
 * @return int
 */
function random($min, $max)
{
    return (int) \mt_rand($min, $max);
}

/**
 * @param int|float $number
 * @param int|float $min
 * @param int|float $max
 *
 * @return int|float
 */
function limit($number, $min, $max)
{
    if ($number < $min) {
        return $min;
    }

    if ($number > $max) {
        return $max;
    }

    return $number;
}

// kind of pointless to be curried?
function subtract() {
    $subtract = function($x, $y) {
        return $x - $y;
    };
    return call_user_func_array(FP\curry2($subtract), args());
}

function sub() {
    return subtract(func_get_args());
}

function sub1($x) {
    return subtract($x, 1);
}

function divide() {
    $divide = function($x, $y) {
        return $x / $y;
    };

    return call_user_func_array(FP\curry2($divide), args());
}

const divide = __NAMESPACE__ . '\divide';

function divideBy() {
    return call_user_func_array(FP\flip(divide), func_get_args());
}

// might as well use flip for this
function subtractN() {
    $subtract = function($x, $y) {
        return $y - $x;
    };

    return call_user_func_array(FP\curry2($subtract), args());
}

function multiply() {
    $multiply = function($x, $y) {
        return $x * $y;
    };

    return call_user_func_array(FP\curry2($multiply), func_get_args());
}
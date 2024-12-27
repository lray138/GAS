<?php 

namespace lray138\GAS\Tools;

use lray138\GAS\{
	HTML
	, Types as T
	, Arr
	, RegexPatterns as RP
	, Functional as FP
	, Str
};

use function lray138\GAS\Functional\flipCurry2 as _;
use function lray138\GAS\dump;

/*-----------------------------------------------------------------------*/
function arrToColumns($cols_per_row, $data, $callable = null) {
	$class = (12/$cols_per_row);

	$chunked = Arr\chunk($cols_per_row, $data);

	return T\Arr($chunked)
		->map(Arr\map(function($x) use ($class) {
			return _(HTML\div)('class="col-lg-'. $class . '"')($x);
		}))
		->map(Arr\join(""))
		->map(_(HTML\div)('class="row"'))
		->join()
		->map(_(HTML\div)('class="container"'))
		->extract();
}

function arrToXML() {
	$xml = \GAS\Array2XML\Array2XML::createXML('root', $array);
    $root = $xml->getElementsByTagname("text")->item(0);
    return $xml->saveXML($root);
    //return \GAS\Array2XML($array);
}

function urlify($string) {
	return preg_replace(RP\findUrl(), RP\replaceUrl(), $string);
}

const urlify = __NAMESPACE__ . '\urlify';

function attributesStringToArrType($str) {
	return T\Arr(explode(" ", $str))
        ->map(FP\pipe(
            Str\explode("=")
            , Arr\map(Str\removeQuotes)
        ))
        ->reduce(function($c, $x) {
            return $c->set($x[0], $x[1]);
        }, T\Arr());
}
<?php 

namespace lray138\GAS\Tools;

use lray138\GAS\{
	HTML,
	Types,
	Arr 
};

use function lray138\GAS\Functional\flipCurry2 as _;
use function lray138\GAS\dump;

function arrToColumns($cols_per_row, $data, $callable = null) {
	$class = (12/$cols_per_row);

	$chunked = Arr\chunk($cols_per_row, $data);

	return Types\Arr($chunked)
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
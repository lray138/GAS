<?php 
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML 
	, Types as T
	, Arr
	, Str
	, Functional as FP
};

use function lray138\GAS\Functional\compose;
use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

function table($headings, $content = [], $options = []) {
	$f = function($headings, $content, $options = []) {

		return _(HTML\table)('class="table"')([
			_thead($headings)
			, _tbody($content)
		]);

	};

	return FP\curry2($f)(...func_get_args());
}

function _thead($data = []) {
    return _(HTML\thead)('')([
    	_(HTML\tr)('')(array_map(_(HTML\th)('scope="col"'), $data))
	]);
};

function _tbody($data = []) {
	$data = array_map(function($x) {
		$out = array_map(function($x) {
			return $x === 0 
				? _(HTML\th)('scope="col"')
				: _(HTML\td)('');
		}, array_keys(array_values($x)));

		return HTML\tr(array_map(function($x) {
			return $x[0]($x[1]);
		}, array_map(null, $out, $x)));
	}, $data);

    return _(HTML\tbody)('')($data);
}
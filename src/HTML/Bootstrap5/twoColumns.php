<?php 
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML 
	, Types as T
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

function twoColumns(T\ArrType $data) {
	return T\Arr([
			HTML\div($data->column_1, getColumnAttributes(2, 1, $data))
			, HTML\div($data->column_2, getColumnAttributes(2, 2, $data))
		])
		->implode()
		->map(_(HTML\div)(getRowAttributes($data)))
		->map(_(HTML\div)(getContainerAttributes($data)));
};
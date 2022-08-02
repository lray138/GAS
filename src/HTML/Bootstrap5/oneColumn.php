<?php 
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML 
	, Types as T
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

function oneColumn(T\ArrType $data) {
	return T\Str(HTML\div($data->column_1, getColumnAttributes(1, 1, $data)))
		->map(_(HTML\div)(getRowAttributes($data)))
		->map(_(HTML\div)(getContainerAttributes($data)));
};
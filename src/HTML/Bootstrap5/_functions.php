<?php 

namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\Types as T;

function getContainerAttributes(T\ArrType $data) {
	$out = $data->container_attributes->isNothing() 
		? T\Arr([ "class" => $data->fluid->is() ? "container-fluid" : "container" ]) 
		: $data->container_attributes;

	return $out->class->isNothing() 
		? $out->set("class", "container")
		: $out;
}

function getRowAttributes(T\ArrType $data) {
	return $data->row_attributes->isNothing() 
		? [ "class" => "row" ]
		: $data->row_attributes;
}

// OK, I like this too...
// starting to wonder then, probably just send everythign in the array
function getColumnAttributes($columns_per_row, $column_number, T\ArrType $data) {

	$default_column_size = 12 / $columns_per_row;

	return $data->get("column_" . $column_number . "_attributes")->isNothing() 
		? [ "class" => $data->default_column_class->is() ? $data->get("column_" . $column_number . "_attributes") : "col-lg-" . $default_column_size ]  
		: $data->get("column_" . $column_number . "_attributes");

}
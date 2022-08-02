<?php 
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML 
	, Types as T
	, Arr
	, Str
};

use function lray138\GAS\Functional\compose;
use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

function nameToLabel($name) {
	return compose(
		Arr\join(" ")
		, Arr\map(compose("ucfirst", "trim"))
		, Str\explode(" ")
		, Str\replace("_", " ")
		, Str\replace("-", " ")
	)($name);
}

function textInput($data = []) {
	if(is_null($data["name"])) return "";
	extract($data);
	
	$id = is_null($id) ? $name : $id;
	$label = is_null($label) ? nameToLabel($name) : $label;

	unset($data["id"], $data["name"], $data["label"]);

	$attr = array_merge([
		"type" => "text"
		, "class" => "form-control"
		, "name" => $name 
		, "id" => $id 
	], $data);

	return _(HTML\label)('class="form-label" for="' . $name . '"')($label)
	. HTML\input($attr);
}

function textInputHiddenId($data = []) {
	if(is_null($data["name"])) return "";
	extract($data);
	
	$id = is_null($id) ? $name : $id;
	$label = is_null($label) ? nameToLabel($name) : $label;

	return _(HTML\label)('class="form-label" for="' . $name . '"')($label)
	. HTML\input('type="text" class="form-control" name="' . $name . '" id="' . $id . '"')
	. HTML\input('type="hidden" class="form-control" name="' . $name . '_id" id="' . $id . '_id"');
}

function textarea($data = []) {
	if(is_null($data["name"])) return "";
	extract($data);

	$id = is_null($id) ? $name : $id;
	$label = is_null($label) ? nameToLabel($name) : $label;

	return _(HTML\label)('class="form-label" for="' . $name . '"')($label)
		. HTML\textarea("", 'class="form-control" name="' . $name . '" id="' . $id .'"');
}


<?php 

namespace lray138\GAS\Views;

use lray138\GAS\{
    HTML,
    Types as T,
    Functional as FP
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

function blank(T\ArrType $data) {
	$head_content = T\Arr([
	    HTML\meta('charset="utf-8"')
	    , HTML\meta('name="viewport" content="width=device-width, initial-scale=1"')
	    , HTML\title($data->title)
	])->merge($data->head_merge);

	$footer_js = T\Arr()
	    ->merge($data->ooter_js_merge);

	$body_attributes = [];

	$body_content = $data->main;
	
	$html = _(HTML\html)('lang="en"')([
		HTML\head($head_content),
	    HTML\body($body_content, $body_attributes)
	]);

	$doctype = "<!DOCTYPE html>";

	return $doctype . $html;
}
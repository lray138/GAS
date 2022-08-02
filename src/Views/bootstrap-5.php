<?php 

namespace lray138\GAS\Views;

use lray138\GAS\{
    HTML,
    Types as T,
    Functional as FP
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

function bootstrap5(T\ArrType $data) {
	$head_content = T\Arr([
	    HTML\meta('charset="utf-8"'),
	    HTML\meta('name="viewport" content="width=device-width, initial-scale=1"')    ,
	    HTML\link('href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"'),
	    HTML\title($page->title)
	])->merge($head_merge);

	$footer_js = T\Arr()
	    ->push(_(HTML\script)('src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"')(''))
	    ->merge($footer_js_merge);

	$body_attributes = [];

	$html = _(HTML\html)('lang="en"')([
		HTML\head($head_content),
	    HTML\body($body_content, $body_attributes)
	]);

	$doctype = "<!DOCTYPE html>";

	return $doctype . $html;
}
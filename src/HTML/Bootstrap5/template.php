<?php
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML,
	Types\ArrType
};

use function lray138\GAS\Functional\flip as _;
		
function template(T\ArrType $data) {
    $head_content = T\Arr([
        HTML\meta('charset="utf-8"')
        , HTML\meta('name="viewport" content="width=device-width, initial-scale=1"')    
        , HTML\link('href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"')
    ])->merge($data->head_merge);

    $footer_js = T\Arr()
        ->push(_(HTML\script)('src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"')(''))
        ->merge($data->footer_js_merge);

    $body_attributes = [];
    
    $body_content = $data->body->isNothing() ? T\Arr() : $data->body;
    $body_content = $body_content->push($footer_js->implode());

    $html = _(HTML\html)('lang="en"')([
        HTML\head($head_content),
        HTML\body($body_content, $body_attributes)
    ]);

    $doctype = "<!DOCTYPE html>";

    return $doctype . $html;
}

const template = __NAMESPACE__ . '\template';
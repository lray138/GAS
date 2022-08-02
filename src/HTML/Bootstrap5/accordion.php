<?php 
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
    Arr
    , HTML
	, Types as T
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;
use function lray138\GAS\Tools\attributesStringToArrType as Attributes;


/* *
 * 
 */		
function accordion($data = null) {
    if(!$data instanceof T\ArrType) {
        $data = T\Arr($data);
    }

    $key = 0;
    $reducer = function($carry, $item) use (&$key) {
        $key++;
        return $carry . _accordionItem($item->set("key", $key));
    };

    return _(HTML\div)('class="accordion" id="accordionExample"')($data->reduce($reducer, ""));
};

const accordion = __NAMESPACE__ . '\accordion';

/* *
 *
 */
function _accordionItem(T\ArrType $data = null) {
    // until we get options working I will default to 
    // having them auto collapsed
    $heading_attributes = 'class="accordion-header" id="heading_' . $data->key . '"';

    $button_attributes = Attributes('type="button" data-bs-toggle="collapse"')
        ->set("class", "accordion-button" . ($data->key->is(1) ? "" : " collapsed"))
        //->set("class", "accordion-button collapsed")
        ->set("data-bs-target", "#collapse_" . $data->key)
        ->set("aria-expanded", $data->key->is(1) ? "true" : "false")
        ->set("aria-controls", "collapse_" . $data->key)
        ;

    $accordion_attributes = T\Arr()
        ->set("id", "collapse_" . $data->key)
        ->set("class", "accordion-collapse collapse" . ($data->key->is(1) ? " show" : ""))
        //->set("class", "accordion-collapse collapse")
        ->set("aria-labelledby", "heading_" . $data->key)
        ->set("data-bs-parent", "#accordionExample")
        ;

    return _(HTML\div)('class="accordion-item"')([
        _(HTML\h2)($heading_attributes)([
            _(HTML\button)($button_attributes)($data->heading)    
        ])
        , _(HTML\div)($accordion_attributes)([
            _(HTML\div)('class="accordion-body"')($data->content)    
        ])
    ]);
};
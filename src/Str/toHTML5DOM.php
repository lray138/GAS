<?php namespace lray138\GAS\Str;

const toHTML5DOM = __NAMESPACE__ . '\toHTML5DOM';

/**
 *  @todo this is kind of borderline here... may belong in
 * something else... like it'w on.. and then do 'from' or 'of'
 * not the query selector way... https://stackoverflow.com/questions/1205751/php5-find-root-node-in-domdocument
 */
function toHTML5DOM(string $element, $select = "body") {
    $dom = new \IvoPetkov\HTML5DOMDocument();
    $dom->loadHTML($element);
    return $dom->documentElement->firstElementChild;
}
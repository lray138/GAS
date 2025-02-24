<?php namespace lray138\GAS\Functional;

const extract = __NAMESPACE__ . '\extract';

/**
 * @todo I think the mentality here is that we 
 */
function extract($data) {
    if(!is_object($data)) return $data;

    if(method_exists($data, "extract")) {
        return $data->extract();
    }

    // get just is from Chem/bingo 
    // get Just is tricky

    // Dec 28, 2024 - 11:07 - intresting this is here, because
    // I noticed that "getJust" somehwere in the last couple days 
    // and though that it made it harder to pass that around (i.e. get vs getJust)
    // then as long as it satisfied the interface it could be ... whatever... 
    if(method_exists($data, "getJust")) {
        return $data->getOrElse("");
    }

    // wonder why empty str vs. null ? hehe 
    return "";
}
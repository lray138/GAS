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
    if(method_exists($data, "getJust")) {
        return $data->getOrElse("");
    }

    return "";
}
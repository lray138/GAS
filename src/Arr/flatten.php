<?php namespace lray138\GAS\Arr;

const flatten = __NAMESPACE__ . '\flatten';

// https://stackoverflow.com/questions/526556/how-to-flatten-a-multi-dimensional-array-to-simple-one-in-php/15939539
function flatten_old(array $array) {
    $return = array();
    foreach ($array as $key => $value) {
       if (is_array($value)){ $return = array_merge($return, flatten($value));}
       else {$return[$key] = $value;}
    }
   return $return;
}

function flatten_chatgpt_try1(array $array) {
    $result = [];
    
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $flattened = flatten($value);
            foreach ($flattened as $subKey => $subValue) {
                $result[] = $subValue;
            }
        } else {
            $result[] = $value;
        }
    }
    
    return $result;
}

function flatten_chatgpt_try2(array $array) {
    $result = [];
    
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $flattened = flatten($value);
            foreach ($flattened as $subKey => $subValue) {
                $result[$subKey] = $subValue;
            }
        } else {
            $result[$key] = $value;
        }
    }
    
    return $result;
}

function flatten_try3(array $array) {
    $result = [];

    array_walk_recursive($array, function($value, $key) use (&$result) {
        $result[] = $value;
    });

    return $result;
}

function flatten(array $array) {
    $result = [];

    $flattenArray = function ($array, &$result) use (&$flattenArray) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $flattenArray($value, $result);
            } else {
                $result[] = $value;
            }
        }
    };

    $flattenArray($array, $result);

    return $result;
}

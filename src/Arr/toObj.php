<?php namespace lray138\GAS\Arr;

const toObj = __NAMESPACE__ . '\toObj';

/**
 * @todo verify this works for deeper recursion vs. shallow
 */
function toObj(array $array) {
    $object = new \stdClass();
    
    foreach ($array as $key => $value) {
        if (is_array($value) && isAssociative($value)) {
            $object->$key = toObj($value); // Recursively convert nested associative arrays
        } else {
            $object->$key = $value; // Assign scalar values directly
        }
    }
    
    return $object;
}

function toObjShallow(array $array) {
    $object = new \StdClass();
    foreach ($array as $key => $value) {
        $object->$key = $value;
    }
    return $object;
}
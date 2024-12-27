<?php namespace lray138\GAS\Functional;

const flatten = __NAMESPACE__ . '\flatten';

/**
 * Function description.
 */
// from ace bingo
function flatten(array $list): array {
  $flattened = fold(
    function ($acc, $value) {
      return \is_array($value) ?
        extend($acc, flatten($value)) :
        extend($acc, [$value]);
    },
    $list,
    []
  );

  return $flattened;
}
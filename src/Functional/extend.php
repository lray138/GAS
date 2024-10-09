<?php namespace lray138\GAS\Functional;

const extend = __NAMESPACE__ . '\extend';

/**
 * Function description.
 */
// from ace/bingo
function extend(array ...$lists): array
{
  $ret = [];

  for ($idx = 0; $idx < \count($lists); ++$idx) {
    $list = $lists[$idx];

    foreach ($list as $key => $val) {
      if (\is_string($key)) {
        $ret[$key] = $val;
      } else {
        $ret[] = $val;
      }
    }
  }

  return $ret;
}
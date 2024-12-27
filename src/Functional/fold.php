<?php namespace lray138\GAS\Functional;

const fold = __NAMESPACE__ . '\fold';

function _fold(callable $func, $list, $acc)
{
  if (\is_array($list) || \is_object($list)) {
    foreach ($list as $idx => $val) {
      $acc = $func($acc, $val, $idx);
    }
  }

  return $acc;
}

function fold(callable $func, $list, $acc)
{
  return _fold($func, $list, $acc);
}
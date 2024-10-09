<?php
namespace lray138\GAS\Test;

/* this was before I found PEST...  2024-10-08 15:44:00 WOW */

// via https://www.blogbyben.com/2020/06/an-ultra-lightweight-php-unit-test.html
// https://www.php.net/manual/en/function.assert.php
// shared/lib/testing.php -- test framework
function runAll($dir, $options = []) {
  return directory_deep_fold($dir,
    function($file, $carry) use($options) {
      $stats = testing_run($file, $options);
      return [
        'pass' => $stats['pass'] + $carry['pass'],
        'fail' => $stats['fail'] + $carry['fail'],
        'messages' => $stats['messages'] + $carry['messages']
      ];
    }, ['pass' => 0, 'fail' => 0, 'messages' => []]);
}

function testing_run($file, $options) {
  set_error_handler(__NAMESPACE__ . '\exception_error_handler');
  ini_set('zend.assertions', true);
  ini_set('assert.exception', true);

  $pass_handler = g($options, 'pass', function($file, $index) {});
  $fail_handler = g($options, 'fail', function($file, $index, $cause) {});
  require_once($file);
  $stats = ['pass' => 0, 'fail' => 0];
  $ctx = [];
  if(isset($tests)) {
    foreach($tests as $i => $t) {
      try {
        $ctx = $t($ctx);
        $pass_handler($file, $i);
        $stats['pass']++;
      } catch(\Throwable $ex) {
        $stats['fail']++;
        $stats['messages'][] = $ex->getMessage();
        $fail_handler($file, $i, $ex);
      } catch(\Exception $ex) {
        echo "here 2";
        $stats['fail']++;
        $fail_handler($file, $i, $ex);
      }
    }
  } else {
    $fail_handler($file, 0, new \Exception("No variables \$tests defined"));
    $stats['fail']++;
  }
  return $stats;
}

// Utility Functions
function g($array, $key, $default = false) {
  return array_key_exists($key, $array) ? $array[$key] : $default;
}

function directory_deep_fold($root, $fn, $carry) {
  $dh = opendir($root);
  while($file = readdir($dh)) {
    if($file == '.' || $file == '..') {
      continue;
    } else if(is_dir("$root/$file")) {
      $carry = directory_deep_fold("$root/$file", $fn, $carry);
    } else {
      $carry = call_user_func($fn, "$root/$file", $carry);
    }
  }
  return $carry;
}

// Borrowed from: https://www.php.net/errorexception
function exception_error_handler($severity, $message, $file, $line) {
  if (!(error_reporting() & $severity)) {
    return;
  }
  throw new \ErrorException($message, 0, $severity, $file, $line);
}
<?php 

namespace lray138\GAS;

use lray138\GAS\IO;

function dump() {
    return IO\dump(...func_get_args());
}

const dump = __NAMESPACE__ . '\dump';
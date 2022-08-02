<?php
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML,
	Types\ArrType,
    Functional as FP
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;

/**
 * Would consider in for
 */	
function breadcrumbs($data = null) {

    $crumbs = $data->removeLast()
        ->map(FP\compose(
            _(HTML\li)('class="breadcrumb-item"')
            , function($x) { return HTML\a($x->text, ["href" => $x->href]); }
        ))
        ->push(_(HTML\li)('class="breadcrumb-item active" aria-current="page"')($data->pop()->text));

    return _(HTML\nav)('aria-label="breadcrumb"')([
        _(HTML\ol)('class="breadcrumb"')($crumbs)
    ]);
};

const breadcrumbs = __NAMESPACE__ . '\breadcrumbs';
<?php
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML,
	Types\ArrType
};

use function lray138\GAS\Functional\flip as _;
use function lray138\GAS\dump;
		
function header(ArrType $data = null) {

    $site_name = "Example";

    $list_items = [
        _(HTML\li)('')([
            _(HTML\a)('href="#" class="nav-link px-2 link-secondary"')("Home")        
        ]),
        _(HTML\li)('')([
            _(HTML\a)('href="#" class="nav-link px-2 link-dark"')("Features")        
        ]),
        _(HTML\li)('')([
            _(HTML\a)('href="#" class="nav-link px-2 link-dark"')("Pricing")        
        ]),
        _(HTML\li)('')([
            _(HTML\a)('href="#" class="nav-link px-2 link-dark"')("FAQs")        
        ]),
        _(HTML\li)('')([
            _(HTML\a)('href="#" class="nav-link px-2 link-dark"')("About")        
        ])    
    ];

    $buttons = [
        _(HTML\button)('type="button" class="btn btn-outline-primary me-2"')("Login"),
        _(HTML\button)('type="button" class="btn btn-primary"')("Sign-up")    
    ];

    return _(HTML\div)('class="container"')([
        _(HTML\header)('class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom"')([
            _(HTML\a)('href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none"')(HTML\h3($site_name)),
        _(HTML\ul)('class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0"')($list_items),
        _(HTML\div)('class="col-md-3 text-end"')($buttons)
    ])
]);
};

const header = __NAMESPACE__ . '\header';
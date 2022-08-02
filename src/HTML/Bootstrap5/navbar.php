<?php
namespace lray138\GAS\HTML\Bootstrap5;

use lray138\GAS\{
	HTML,
	Types\ArrType
};

use function lray138\GAS\Functional\flip as _;
		
function navbar(ArrType $data = null) {
    return _(HTML\nav)('class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="navbar"')([
    _(HTML\div)('class="container-fluid"')([
        _(HTML\button)('class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation"')([
            _(HTML\span)('class="navbar-toggler-icon"')('')    
        ]),
        _(HTML\div)('class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08"')([
            _(HTML\ul)('class="navbar-nav"')([
                _(HTML\li)('class="nav-item"')([
                    _(HTML\a)('class="nav-link active" aria-current="page" href="#"')("Centered nav only")            
                ]),
                _(HTML\li)('class="nav-item"')([
                    _(HTML\a)('class="nav-link" href="#"')("Link")            
                ]),
                _(HTML\li)('class="nav-item"')([
                    _(HTML\a)('class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"')("Disabled")            
                ]),
                _(HTML\li)('class="nav-item dropdown"')([
                    _(HTML\a)('class="nav-link dropdown-toggle" href="#" id="dropdown08" data-bs-toggle="dropdown" aria-expanded="false"')("Dropdown"),
                    _(HTML\ul)('class="dropdown-menu" aria-labelledby="dropdown08"')([
                        _(HTML\li)('')([
                            _(HTML\a)('class="dropdown-item" href="#"')("Action")                    
                        ]),
                        _(HTML\li)('')([
                            _(HTML\a)('class="dropdown-item" href="#"')("Another action")                    
                        ]),
                        _(HTML\li)('')([
                            _(HTML\a)('class="dropdown-item" href="#"')("Something else here")                    
                        ])                
                    ])            
                ])        
            ])    
        ])
    ])
]);
};

const navbar = __NAMESPACE__ . '\navbar';
<?php namespace lray138\GAS\WordPress;

// helpers and wrappers and returns will be of GAS Types
use lray138\GAS\Types\{
    StrType as Str,
    ArrType as Arr,
};

// // // 

use function lray138\GAS\{Num, dump};

use lray138\GAS\Types\{
	StrType,
	Either
};

function getPageByPath($path): Either {
    if(is_object($path) && method_exists($path, "extract")) {
        $path = $path->extract();
    }

	$page = get_page_by_path($path);

	return is_null($page) 
		? Either::left("page with path '$path' not found")
		: Either::right($page);
}

// I'm OK with data being a native array because we would
// immediately extract anyway, need to add the "extract" logic
function createPage($data = []): Either {

	extract($data);

	if(is_null($parent_id)) {
		return Either::left("Please provide a valid parent ID");
	}

	// Create the new page
    $page_data = array(
        'post_title'    => $title,					// Title of the page
        'post_name'     => $name,             		// Slug of the page
        'post_status'   => 'publish',               // Status of the page (publish immediately)
        'post_type'     => 'page',                  // Page post type
        'post_content'  => '',                      // Content of the page (you can add content here if needed)
        'post_author'   => $author,   // Author ID
        'post_parent'   => $parent_id,             // Set the parent page ID
        'meta_input'    => array(
            '_wp_page_template' => $template // Assign the custom template
        ),
    );
    
    // Insert the page into the database
    $page_id = wp_insert_post($page_data);

    return $page_id === 0 
        ? Either::left("There was a problem creating the page")
        : Either::right(get_page($page_id));
}

function getUserByName(Str $name): Either {
    return $name
        ->bind(function($x) {
            $user = get_user_by('login', $x);
            return $user ? Either::right($user) : Either::left("User with login '$x' not found.");
        });
}

function getPagesByTemplate($template): Arr {
    return Arr::of(get_posts([
            'post_type'  => 'page',
            'meta_query' => [
                [
                    'key'     => '_wp_page_template',
                    'value'   => $template,
                    'compare' => '=', // Exact match
                ],
            ],
            'posts_per_page' => -1, // Get all matching pages
        ]));
}
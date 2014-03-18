<?php


	//wp_enqueue_script('jquery');
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain( 'html5reset', TEMPLATEPATH . '/languages' );
 
        $locale = get_locale();
        $locale_file = TEMPLATEPATH . "/languages/$locale.php";
        if ( is_readable($locale_file) )
            require_once($locale_file);
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !function_exists(core_mods) ) {
		function core_mods() {
			if ( !is_admin() ) {
				wp_deregister_script('jquery');
				wp_register_script('jquery', ("//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"), false);
				wp_enqueue_script('jquery');
			}
		}
		core_mods();
	}

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => __('Sidebar Widgets','html5reset' ),
    		'id'   => 'sidebar-widgets',
    		'description'   => __( 'These are widgets for the sidebar.','html5reset' ),
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
    
    add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.
    
    
    // disable admin bar
    if (!function_exists('disableAdminBar')) {
    	function disableAdminBar(){
      	remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
      }
    }

    /**
    * Filter out hard-coded width, height attributes on all images in WordPress. 
    * https://gist.github.com/4557917
    *
    * This version applies the function as a filter to the_content rather than send_to_editor. 
    * Changes made by filtering send_to_editor will be lost if you update the image or associated post 
    * and you will slowly lose your grip on sanity if you don't know to keep an eye out for it. 
    * the_content applies to the content of a post after it is retrieved from the database and is "theme-safe". 
    * (i.e., Your changes will not be stored permanently or impact the HTML output in other themes.)
    *
    * Also, the regex has been updated to catch both double and single quotes, since the output of 
    * get_avatar is inconsistent with other WP image functions and uses single quotes for attributes. 
    * [insert hate-stare here]
    *
    */
    function bones_remove_img_dimensions($html) {
      $html = preg_replace('/(width|height)=["\']\d*["\']\s?/', "", $html);
        return $html;
    }
    add_filter('post_thumbnail_html', 'bones_remove_img_dimensions', 10);
    add_filter('the_content', 'bones_remove_img_dimensions', 10);
    add_filter('get_avatar','bones_remove_img_dimensions', 10);


function drom_register() {
	$labels = array(
		'name' => _x('DROM', 'post type general name'),
		'singular_name' => _x('DROM Chapter', 'post type singular name'),
		'add_new' => _x('Add New', 'event'),
		'add_new_item' => __('Add New DROM Chapter'),
		'edit_item' => __('Edit DROM Chapter'),
		'new_item' => __('New DROM Chapter'),
		'view_item' => __('View DROM Chapter'),
		'search_items' => __('Search DROM Chapters'),
		'not_found' =>  __('No DROM Chapters found'),
		'not_found_in_trash' => __('No DROM Chapters found in Trash'),
		'parent_item_colon' => ''
	);

	$args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'show_in_nav_menus' => true,
	    'query_var' => true,
	    'rewrite' => array( 'slug' => 'drom', 'with_front' => false ),
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => 5,
	    //'taxonomies' => array( 'project-type' ),
	    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions', 'post-formats' )
	);

	register_post_type( 'drom' , $args );
}

add_action('init', 'drom_register');

function register_sd_menu() {
  register_nav_menu('header',__( 'Header' ));
  register_nav_menu('drom-toc',__( 'DROM TOC' ));
}
add_action( 'init', 'register_sd_menu' );



function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6';

	// Add elements not included in standard tinyMCE doropdown p,h1,h2,h3,h4,h5,h6
	$init['extended_valid_elements'] = 'textbox';

	return $init;
}

// Modify Tiny_MCE init
add_filter('tiny_mce_before_init', 'customformatTinyMCE' );




?>
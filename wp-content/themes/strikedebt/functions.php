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
	    'capability_type' => 'page',
	    'has_archive' => false, 
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







/* -- DROM meta boxes -- */

//First, let's see if we're on the DROM Front Page template - if so, get meta boxes for reviews
add_action('admin_init','my_meta_init');

function my_meta_init() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	
	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

	// check for a template type
	if ($template_file == 'page-dromfront.php') {
		add_meta_box('sd_praise_meta', 'Praise for DROM', 'sd_praise_meta_setup', 'page', 'normal', 'high');
	}
}

//now, let's add a meta box for the subtitle
function sd_drom_custom_boxes(){
	add_meta_box('sd_drom_subtitles', 'Visual Subtitles', 'sd_drom_subtitles_meta_box', 'drom', 'normal', 'high');
}
add_action('add_meta_boxes', 'sd_drom_custom_boxes');




/* callbacks for each meta box */
//subtitle meta boxes on DROM chapter pages
function sd_drom_subtitles_meta_box($post) {
	wp_nonce_field( 'sd_drom_subtitles_meta_box', 'sd_drom_subtitles_meta_box_nonce' );
	
	$post_meta = get_post_meta($post->ID);
	?>
	<table>
		<tr>
			<td>
				<textarea rows='2' cols='180' id="drom_subtitle" name="drom_admin_subtitle" style="width:92%;float:left;"><?php echo $post_meta['drom_subtitle'][0];//esc_attr($post_meta['nm_artistry_notes'][0]); ?></textarea>
			</td>
		</tr>
	</table>
	
	
<?php
	
}

//praise meta boxes on DROM archive page
function sd_praise_meta_setup($post) {
	wp_nonce_field( 'sd_praise_meta_setup', 'sd_praise_meta_box_nonce' );
	
	$post_meta = get_post_meta($post->ID);	
	?>
	<table>
		<tr>
			<td>
			<h2 style="margin-top:0px;margin-bottom:0px">Review #1</h2>
			<div style="float:left;width:65%;">
				<label for="sd_review_1">Content #1: </label>
				<br />	
				<textarea rows='5' cols='80' id="sd_review_1" name="sd_admin_review_1" style="width:92%;float:left;"><?php echo $post_meta['sd_review_1'][0]; ?></textarea>
			</div>
			<div style="float:right;width:35%;">
				<label for="sd_author_1">Author #1: </label><br />
				<textarea rows='5' cols='80' id="sd_author_1" name="sd_admin_author_1" style="width:92%;float:right;"><?php echo $post_meta['sd_author_1'][0]; ?></textarea>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<h2 style="margin-top:0px;margin-bottom:0px">Review #2</h2>
			<div style="float:left;width:65%;">
				<label for="sd_review_2">Content #2: </label><br />	
				<textarea rows='5' cols='80' id="sd_review_2" name="sd_admin_review_2" style="width:92%;float:left;"><?php echo $post_meta['sd_review_2'][0]; ?></textarea>
			</div>
			<div style="float:right;width:35%;">
				<label for="sd_author_2">Author #2: </label><br />
				<textarea rows='5' cols='80' id="sd_author_2" name="sd_admin_author_2" style="width:92%;float:right;"><?php echo $post_meta['sd_author_2'][0]; ?></textarea>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<h2 style="margin-top:0px;margin-bottom:0px">Review #3</h2>
			<div style="float:left;width:65%;">
				<label for="sd_review_3">Content #3: </label><br />	
				<textarea rows='5' cols='80' id="sd_review_3" name="sd_admin_review_3" style="width:92%;float:left;"><?php echo $post_meta['sd_review_3'][0]; ?></textarea>
			</div>
			<div style="float:right;width:35%;">
				<label for="sd_author_3">Author #3: </label><br />
				<textarea rows='5' cols='80' id="sd_author_3" name="sd_admin_author_3" style="width:92%;float:right;"><?php echo $post_meta['sd_author_3'][0]; ?></textarea>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<h2 style="margin-top:0px;margin-bottom:0px">Review #4</h2>
			<div style="float:left;width:65%;">
				<label for="sd_review_4">Content #4: </label><br />	
				<textarea rows='5' cols='80' id="sd_review_4" name="sd_admin_review_4" style="width:92%;float:left;"><?php echo $post_meta['sd_review_4'][0]; ?></textarea>
			</div>
			<div style="float:right;width:35%;">
				<label for="sd_author_4">Author #4: </label><br />
				<textarea rows='5' cols='80' id="sd_author_4" name="sd_admin_author_4" style="width:92%;float:right;"><?php echo $post_meta['sd_author_4'][0]; ?></textarea>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<h2 style="margin-top:0px;margin-bottom:0px">Review #5</h2>
			<div style="float:left;width:65%;">
				<label for="sd_review_1">Content #5: </label><br />	
				<textarea rows='5' cols='80' id="sd_review_5" name="sd_admin_review_5" style="width:92%;float:left;"><?php echo $post_meta['sd_review_5'][0]; ?></textarea>
			</div>
			<div style="float:right;width:35%;">
				<label for="sd_author_5">Author #5: </label><br />
				<textarea rows='5' cols='80' id="sd_author_5" name="sd_admin_author_5" style="width:92%;float:right;"><?php echo $post_meta['sd_author_5'][0]; ?></textarea>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<h2 style="margin-top:0px;margin-bottom:0px">Review #6</h2>
			<div style="float:left;width:65%;">
				<label for="sd_review_6">Content #6: </label><br />	
				<textarea rows='5' cols='80' id="sd_review_6" name="sd_admin_review_6" style="width:92%;float:left;"><?php echo $post_meta['sd_review_6'][0]; ?></textarea>
			</div>
			<div style="float:right;width:35%;">
				<label for="sd_author_6">Author #6: </label><br />
				<textarea rows='5' cols='80' id="sd_author_6" name="sd_admin_author_6" style="width:92%;float:right;"><?php echo $post_meta['sd_author_6'][0]; ?></textarea>
			</div>
			</td>
		</tr>
		
	</table>
	<?php
}

/* Save the meta boxes to postmeta*/
function sd_save_subtitle_meta_boxes( $post_id ) {
	/** verify this came from the our screen and with proper authorization, because save_post can be triggered at other times.   */

	// Check if our nonce is set.
	if ( ! isset( $_POST['sd_drom_subtitles_meta_box_nonce'] ) )
		return $post_id;
	
	$nonce = $_POST['sd_drom_subtitles_meta_box_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'sd_drom_subtitles_meta_box' ) )
		return $post_id;

	$subtitle = sanitize_text_field( $_POST['drom_admin_subtitle'] );
	update_post_meta( $post_id, 'drom_subtitle', $subtitle );
	
	
}
add_action( 'save_post', 'sd_save_subtitle_meta_boxes' );


function sd_save_praise_meta_boxes( $post_id ) {
	/** verify this came from the our screen and with proper authorization, because save_post can be triggered at other times.   */

	// Check if our nonce is set.
	if ( ! isset( $_POST['sd_praise_meta_box_nonce'] ) )
		return $post_id;
	
	$nonce = $_POST['sd_praise_meta_box_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'sd_praise_meta_setup' ) )
		return $post_id;

	$review1 = sanitize_text_field( $_POST['sd_admin_review_1'] );
	$author1 = sanitize_text_field( $_POST['sd_admin_author_1'] );
	$review2 = sanitize_text_field( $_POST['sd_admin_review_2'] );
	$author2 = sanitize_text_field( $_POST['sd_admin_author_2'] );
	$review3 = sanitize_text_field( $_POST['sd_admin_review_3'] );
	$author3 = sanitize_text_field( $_POST['sd_admin_author_3'] );
	
	$review4 = sanitize_text_field( $_POST['sd_admin_review_4'] );
	$author4 = sanitize_text_field( $_POST['sd_admin_author_4'] );
	$review5 = sanitize_text_field( $_POST['sd_admin_review_5'] );
	$author5 = sanitize_text_field( $_POST['sd_admin_author_5'] );
	$review6 = sanitize_text_field( $_POST['sd_admin_review_6'] );
	$author6 = sanitize_text_field( $_POST['sd_admin_author_6'] );
	
	
	update_post_meta( $post_id, 'sd_review_1', $review1 );
	update_post_meta( $post_id, 'sd_author_1', $author1 );
	update_post_meta( $post_id, 'sd_review_2', $review2 );
	update_post_meta( $post_id, 'sd_author_2', $author2 );
	update_post_meta( $post_id, 'sd_review_3', $review3 );
	update_post_meta( $post_id, 'sd_author_3', $author3 );

	update_post_meta( $post_id, 'sd_review_4', $review4 );
	update_post_meta( $post_id, 'sd_author_4', $author4 );
	update_post_meta( $post_id, 'sd_review_5', $review5 );
	update_post_meta( $post_id, 'sd_author_5', $author5 );
	update_post_meta( $post_id, 'sd_review_6', $review6 );
	update_post_meta( $post_id, 'sd_author_6', $author6 );
	
	
}
add_action( 'save_post', 'sd_save_praise_meta_boxes' );




?>
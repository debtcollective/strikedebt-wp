<?php
/**
 * @package Author_Images_Widget
 * @author Scott Reilly
 * @version 003
 */
/*
 * Author Images plugin widget code
 *
 * Copyright (c) 2011-2012 by Scott Reilly (aka coffee2code)
 *
 */

if ( !class_exists( 'c2c_AuthorImagesWidget' ) ) :

require_once( 'c2c-widget.php' );

class c2c_AuthorImagesWidget extends C2C_Widget_005 {

	/**
	 * Constructor
	 */
	function c2c_AuthorImagesWidget() {
		parent::__construct( 'author-images', __FILE__, array() );
	}

	/**
	 * Initializes the plugin's configuration and localizable text variables.
	 *
	 * @return void
	 */
	function load_config() {
		$this->title       = __( 'Author Image(s)', $this->textdomain );
		$this->description = __( 'Display image (if present) and/or name for all authors on the blog.', $this->textdomain );

		$this->config = array(
			'title' => array( 'input' => 'text', 'default' => __( 'Authors', $this->textdomain ),
					'label' => __( 'Title', $this->textdomain ) ),
			'exclude_admin' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Exclude admin?', $this->textdomain ),
					'help' => __( 'Prevent admin accounts from being listed?', $this->textdomain ) ),
			'hide_empty' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Ignore authors who have\'t published a post?', $this->textdomain ),
					'help' => __( 'Omits showing image for authors who have not published a post.', $this->textdomain ) ),
			'show_name' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Show user\'s name?', $this->textdomain ),
					'help' => __( 'Also show the user\'s name? By default this is their configured display name.', $this->textdomain ) ),
			'show_fullname' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Show user\'s full name?', $this->textdomain ),
					'help' => __( 'If showing the user\'s name, force display of their full name instead of their configured display name (which may be a nickname or first name)? <em>NOTE: "Show user\'s name?" must be checked for this to take effect.)</em>', $this->textdomain ) ),
			'show_name_if_no_image' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Show user\'s name if no image is found?', $this->textdomain ),
					'help' => __( 'Should the author\'s name be shown if the author doesn\'t have an image? If not checked, then authors without an image are omitted from the listing.', $this->textdomain ) ),
			'use_gravatar' => array( 'input' => 'checkbox', 'default' => true,
					'label' => __( 'Use Gravatar?', $this->textdomain ),
					'help' => __( 'Ask Gravatar for author image if no local image is found?', $this->textdomain ) ),
		);
	}

	/**
	 * Outputs the body of the widget
	 *
	 * @param array $args Widget args
	 * @param array $instance Widget instance
	 * @param array $settings Widget settings
	 * @return void (Text is echoed.)
	 */
	function widget_body( $args, $instance, $settings ) {
		extract( $args );
		extract( $settings );

		echo '<ul class="c2c_author_images_widget">';
		c2c_wp_list_authors_images( array(
			'exclude_admin'         => $exclude_admin === '1',
			'hide_empty'            => $hide_empty === '1',
			'show_name'             => $show_name === '1',
			'show_fullname'         => $show_fullname === '1',
			'show_name_if_no_image' => $show_name_if_no_image === '1',
			'use_gravatar'          => $use_gravatar === '1'
		) );
		echo '</ul>';
	}

	/**
	 * Validates widget instance values
	 *
	 * @param array $instance Array of widget instance values
	 * @return array The filtered array of widget instance values
	 */
	function validate( $instance ) {
		return $instance;
	}

} // end class

add_action( 'widgets_init', create_function('', 'register_widget(\'c2c_AuthorImagesWidget\');') );

endif;
?>
<?php
/**
 * @package Author_Images
 * @author Scott Reilly
 * @version 3.6
 */
/*
Plugin Name: Author Image(s)
Version: 3.6
Plugin URI: http://coffee2code.com/wp-plugins/author-images/
Author: Scott Reilly
Author URI: http://coffee2code.com/
Text Domain: author-images
Domain Path: /lang/
Description: Display image (if present) and/or name for the author of a post, or for all authors on the blog.

Compatible with WordPress 3.1+, 3.2+, 3.3+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/author-images/

TODO:
	* Author upload of image
	* Author Image metabox akin to featured post image metabox
	* Support defining custom before/after/between/none text and markup for authors listings
	* Show author image on profile page (at least the image in the default location -- plugin doesn't
	  know about images elsewhere until display-time)
	* Finish making all plugin options overridable in direct calls to functions
	* Allow widget to override all options as well (such as blank image)
	* Reference actual wp-content dir name rather than assuming "wp-content"

*/

/*
Copyright (c) 2005-2012 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( ! class_exists( 'c2c_AuthorImages' ) ) :

require_once( 'c2c-plugin.php' );
require_once( dirname( __FILE__ ) . '/author-images.widget.php' );

class c2c_AuthorImages extends C2C_Plugin_034 {

	public static $instance;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->c2c_AuthorImages();
	}

	public function c2c_AuthorImages() {
		// Be a singleton
		if ( ! is_null( self::$instance ) )
			return;

		parent::__construct( '3.6', 'author-images', 'c2c', __FILE__, array(  'settings_page' => 'users' ) );
		register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
		self::$instance = $this;
	}

	/**
	 * Handle plugin upgrades.
	 *
	 * Intended to be used for updating plugin options, etc.
	 *
	 * @since 3.5
	 *
	 * @param string $old_version The version number of the old version of
	 *        the plugin. '0.0' if version number wasn't previously stored
	 */
	protected function handle_plugin_upgrade( $old_version, $options ) {
		// 3.1 introduced requirement for images to be relative to wp-content.
		// So image_dir already specifying it should have it removed.
		if ( version_compare( '3.1', $old_version ) === 1 )
			$options['image_dir'] = str_replace( 'wp-content/', '', $options['image_dir'] );

		update_option( $this->admin_options_name, $options );
		$this->options = $options;
	}

	/**
	 * Handles activation tasks, such as registering the uninstall hook.
	 *
	 * @since 3.5
	 *
	 * @return void
	 */
	public function activation() {
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Handles uninstallation tasks, such as deleting plugin options.
	 *
	 * @since 3.5
	 *
	 * @return void
	 */
	public function uninstall() {
		delete_option( 'c2c_author_images' );
	}

	/**
	 * Initializes the plugin's config data array.
	 *
	 * @return void
	 */
	public function load_config() {
		$this->name      = __( 'Author Images', $this->textdomain );
		$this->menu_name = __( 'Author Images', $this->textdomain );

		$this->config = array(
			'show_name' => array( 'input' => 'checkbox', 'default' => true,
					'label' => __( 'Show author name as well?', $this->textdomain ),
					'help' => __( 'Should the author\'s name be shown in addition to the author\'s image? By default this is their configured display name.', $this->textdomain ) ),
			'show_fullname' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Force use of author\'s full name when displaying name?', $this->textdomain ),
					'help' => __( 'If showing the user\'s name, force display of their full name instead of their configured display name (which may be a nickname or first name)? <em>NOTE: "Show author name as well?" must be checked for this to take effect.)</em>', $this->textdomain ) ),
			'show_name_if_no_image' => array( 'input' => 'checkbox', 'default' => true,
					'label' => __( 'Show author name if no image is found?', $this->textdomain ),
					'help' => __( 'Should the author\'s name be shown if the author\'s image can\'t be found?', $this->textdomain ) ),
			'link_type' => array( 'input' => 'select', 'default' => 'posts',
					'options' => array( 'posts', 'site', 'none' ),
					'label' => __( 'Image linking', $this->textdomain ),
					'help' => __( 'How should the author\'s image be linked?<br />posts : link to the archive of the author\'s posts<br />site : link to the author\'s website (if defined for the author)<br />none : don\'t link the author image', $this->textdomain ) ),
			'width' => array( 'input' => 'short_text',
					'label' => __( 'Image width', $this->textdomain ),
					'help' => __( 'Specify this to force the browser to scale the width of the image to this size.  If blank, then the image\'s original width will be left intact (or scaled in proportion to a specified height).', $this->textdomain ) ),
			'height' => array( 'input' => 'short_text',
					'label' => __( 'Image height', $this->textdomain ),
					'help' => __( 'Specify this to force the browser to scale the height of the image to this size.  If blank, then the image\'s original height will be left intact (or scaled in proportion to a specified width).', $this->textdomain ) ),
			'image_extensions' => array( 'input' => 'text', 'default' => 'png gif jpg',
					'label' => __( 'Supported image extensions', $this->textdomain ),
					'help' => __( 'Space-separated list of possible image extensions for image. More efficient if you only include extensions you\'ll actually use.', $this->textdomain ) ),
			'image_dir' => array( 'input' => 'text', 'default' => 'images/authors/',
					'label' => __( 'Image directory', $this->textdomain ),
					'help' => __( 'Directory, relative to the wp-content/ directory of your site, containing the author images.', $this->textdomain ) ),
			'allow_gravatar' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Use Gravatar image if possible?', $this->textdomain ),
					'help' => __( 'If the plugin is unable to find an image for the author, should it try to find a Gravatar for the author?', $this->textdomain ) ),
			'blank_image' => array( 'input' => 'text', 'default' => '',
					'label' => __( 'Blank image', $this->textdomain ),
					'help' => __( 'Image to use if absolutely no author-specific image could be found.  This is the final fallback.', $this->textdomain ) ),
			'custom_field' => array( 'input' => 'text', 'default' => 'author_image',
					'label' => __( 'Custom field name for overriding author image', $this->textdomain ),
					'help' => __( 'If this custom field is specified for a post, its value will be given preference as the potential author image, should the image file exist.', $this->textdomain ) )
		);
	}

	/**
	 * Hack to expose get_options() publicly since it is protected. This is
	 * used by the template tags which are defined outside of the class.
	 * Solution is to define those functions without the class and merely
	 * have a public wrapper to call the object's version of the function.
	 *
	 * HACK!
	 *
	 * @since 3.5
	 *
	 * @return array The plugin's options
	 */
	public function get_options() {
		return parent::get_options();
	}

	/**
	 * Help tabs.
	 *
	 * @since 3.6
	 *
	 * @param WP_Screen $screen WP_Screen instance
	 */
	public function help_tabs_content( $screen ) {

		$template_tag_help = <<<HTML
		<div><a name='templatefuncs'></a>
			<h3>Template functions</h3>
			<p>There are three template functions made available by this plugins.</p>
			<ul>
			<li><code>c2c_get_author_image( \$args = array() )</code>
			Gets the image and/or name for an author.</li>

			<li><code>c2c_the_author_image( \$before = '', \$after = '', \$image_dir = '', \$width = '', \$height = '' )</code>
			A drop-in replacement for WordPress's <code>the_author()</code> , allowing the author for the post to have an image displayed in lieu of the name (if an image can be found).
			</li>
			<li><code>c2c_wp_list_authors_images( \$args = '' )</code>
			A drop-in replacement for WordPress's <code>wp_list_authors()</code>, allowing all authors for a blog to be listed with an image (if present).
			</li>
		</ul>

		<h4>Arguments:</h4>

		<dl class="percentfuncs">
		<dt>\$before</dt>
		<dd><em>Optional.</em>  The text and/or HTML to appear before the author image/text, if any such text would be returned..</dd>
		<dd>Default value: <code>''</code></dd>

		<dt>\$after</dt>
		<dd><em>Optional.</em>  The text and/or HTML to appear after the author image/text, if any such text would be returned.</dd>
		<dd>Default value: <code>''</code></dd>

		<dt>\$image_dir</dt>
		<dd><em>Optional.</em> The directory, relative to the root of your blog, in which to find the author images.  If not set, it defaults to the value configured via the plugin's admin options page.</dd>
		<dd>Default value: <code>''</code></dd>

		<dt>\$width</dt>
		<dd><em>Optional.</em> The forced width of the image (will cause browser to resize if image is of different width). Leave blank to retain image's original width (or for the width to be scaled in proportion to a specified height). It is recommended that images exist at the desired size.</dd>
		<dd>Default value: <code>''</code></dd>

		<dt>\$height</dt>
		<dd><em>Optional.</em> The forced height of the image (will cause browser to resize if image is of different height). Leave blank to retain image's original height (or for the height to be scaled in proportion to a specified width). It is recommended that images exist at the desired size.</dd>
		<dd>Default value: <code>''</code></dd>

		<dt>\$args (as used in <code>c2c_get_author_image()</code>)</dt>
		<dd><em>Optional.</em> An array of configuration options..
		<ul>
			<li>author_id : default of current post author; the id of the author to get the image for</li>
			<li>before : default of <code>''</code>; text to show before each author</li>
			<li>after : default of <code>''</code>; text to show after each author</li>
			<li>image_dir : default of <code>''</code>; directory containing author images, relative to wp-content directory</li>
			<li>width : default of <code>''</code>; width to display image</li>
			<li>height : default of <code>''</code>; height to display image</li>
			<li>show_name : default of <code>''</code> which means it'll abide by the plugin's setting value; should the name of the author be shown in addition to the image?</li>
			<li>show_fullname : default of false; should the user's first and last name be shown instead of the author's configured display name? (be sure to set 'show_name' to true if you want the name to appear in the first place)</li>
			<li>show_name_if_no_image : default of <code>''</code> which means it'll abide by the plugin's setting value; should the author's name be shown if the author doesn't have an image?</li>
			<li>class : default of <code>''</code>; array or string of classes to apply to author image tag</li>
			<li>use_gravatar : default of plugin settings; should Gravatar be consulted for an author image if no local image for the author was found?</li>
		</ul>
		<dt>\$args (as used in <code>c2c_wp_list_authors_images()</code>)</dt>
		<dd><em>Optional.</em> An array of configuration options.  All but the last two match up with the supported arguments of the <code>wp_list_authors()</code> function.
		<ul>
			<li>optioncount : default of false;</li>
			<li>exclude_admin : default of true; should the admin user be excluded from the listing?</li>
			<li>hide_empty : default of true; should authors who have not made any posts be excluded from the listings?</li>
			<li>feed : default of <code>''</code></li>
			<li>feed_image : default of <code>''</code></li>
			<li>echo : default of true; should the listing be echoed to the page?</li>
			<li>show_name : default of <code>''</code> which means it'll abide by the plugin's setting value; should the name of the author be shown in addition to the image?</li>
			<li>show_fullname : default of false; should the user's first and last name be shown instead of the author's configured display name? (be sure to set 'show_name' to true if you want the name to appear in the first place)</li>
			<li>show_name_if_no_image : default of <code>''</code> which means it'll abide by the plugin's setting value; should the author's name be shown if the author doesn't have an image?</li>
			<li>before : default of <code>''</code>; text to show before each author</li>
			<li>after : default of <code>''</code>; text to show after each author</li>
			<li>image_dir : default of <code>''</code>; directory containing author images, relative to wp-content directory</li>
			<li>width : default of <code>''</code>; width to display image</li>
			<li>height : default of <code>''</code>; height to display image</li>
			<li>class : default of <code>''</code>; array or string of classes to apply to author image tag</li>
			<li>use_gravatar : default of plugin settings; should Gravatar be consulted for an author image if no local image for the author was found?</li>
		</ul>
		</dd>

		</dl>
	</div>

HTML;


		$screen->add_help_tab( array(
			'id'      => 'c2c-ai',
			'title'   => __( 'Template Functions', $this->textdomain ),
			'content' => $template_tag_help
		) );

		parent::help_tabs_content( $screen );
	}

	/**
	 * Finds the URL for the author image associated with the specified author.
	 *
	 * @param int $author_id The author ID
	 * @param string $image_dir (optional) The directory containing the author images. If '', then use the value configured in the plugin's settings.
	 * @param bool $check_custom Should the post's custom field be checked for the custom field containing the filename of the author's image?
	 * @param null|bool $use_gravatar Should Gravatar be used if no images are found locally? null means use plugin's configured settings
	 * @return string URL to author image
	 */
	public function find_author_image( $author_id, $image_dir = '', $check_custom = false, $use_gravatar = null ) {
		$options = $this->get_options();
		$image_dir = trim( ( $image_dir ? $image_dir : $options['image_dir'] ), '/' ) . '/';
		$img_path = content_url( $image_dir );
		$image_dir = WP_CONTENT_DIR . '/' . $image_dir;
		$image_extensions = explode( ' ', $options['image_extensions'] );
		$output = '';

		// Check to see if user specified image filename to use as author image
		$custom = '';
		if ( $check_custom && $options['custom_field'] ) {
			$custom = get_post_custom_keys( $options['custom_field'] );
			$custom = trim( $custom[0], '/' );
		};
		if ( ! empty( $custom ) ) {
			if ( file_exists( $image_dir . $custom ) )
				$output = $img_path . $custom;
			else {
				foreach ( $image_extensions as $image_extension ) {
					if ( file_exists( $image_dir . $custom . '.' . $image_extension ) ) {
						$output = $img_path . $custom . '.' . $image_extension;
						break;
					}
				}
			}
		}

		// If no author image by this point, look for image file based on user login or user id
		if ( empty( $output ) ) {
			foreach ( $image_extensions as $image_extension ) {
				$authordata = get_userdata( $author_id );
				if ( file_exists( $image_dir . $authordata->user_login . '.' . $image_extension ) ) {
					$output = $img_path . $authordata->user_login . '.' . $image_extension;
					break;
				}
				elseif ( file_exists( $image_dir . $author_id . '.' . $image_extension ) ) {
					$output = $img_path . $author_id . '.' . $image_extension;
					break;
				}
			}
		}

		// If no author image by this point, find blank image since it is used by subsequent steps
		if ( empty( $output ) ) {
			if ( strpos( $options['blank_image'], '/' ) === false )
				$blank_image = $img_path . $options['blank_image'];
			else
				$blank_image = $options['blank_image'];
		}

		// If no author image by this point, check for Gravatar
		if ( empty( $output ) && ( ( is_bool( $use_gravatar ) && $use_gravatar ) || ( is_null( $use_gravatar ) && $options['allow_gravatar'] ) ) ) {
			$output = get_avatar( $author_id, $options['width'], $blank_image );
			// get_avatar() returns an <img> tag, but we really just want URL
			if ( preg_match( '/src=\'(.+)\'/U', $output, $matches ) )
				$output = $matches[1];
		}

		// If no author image by this point, use fallback image
		if ( empty( $output ) && ! empty( $options['blank_image'] ) )
			$output = $blank_image;

		return $output;
	} // end function find_author_image()

	/**
	 * Returns the formatted author image markup.
	 *
	 * @param string $before (optional) Text to display before the image. Default is ''.
	 * @param string $after (optional) Text to display after the image. Default is ''.
	 * @param string $image_dir (optional) The directory containing the author images. If '', then use the value configured in the plugin's settings.
	 * @param string $width (optional) The forced width of the image (will cause browser to resize if image is of different width). Leave blank to retain image's original width (or for the width to be scaled in proportion to a specified height). It is recommended that images exist at the desired size.
	 * @param string $height (optional) The forced height of the image (will cause browser to resize if image is of different height). Leave blank to retain image's original height (or for the height to be scaled in proportion to a specified width). It is recommended that images exist at the desired size.
	 * @param int|null $author_id (optional) The id of the author to get the image for. Send null to get the image for the current author.
	 * @return void (Text is echoed)
	 */
	public function get_the_author_image( $before = '', $after = '', $image_dir = '', $width = '', $height = '', $author_id = null ) {
		return $this->get_author_image( array( 'before' => $before, 'after' => $after, 'image_dir' => $image_dir, 'height' => $height, 'author_id' => $author_id ) );
	} // end function get_the_author_image()

	/**
	 * List authors
	 *
	 * @since 3.5
	 *
	 * @param array $args Array of settings to configure listing and display of authors
	 * @return string The author listing
	 */
	function get_author_image( $args = array() ) {
		$defaults = array(
			'author_id'    => null,
			'before'       => '',
			'after'        => '',
			'image_dir'    => '',
			'width'        => '',
			'use_gravatar' => null,
			'class'        => array(),
			'show_name'    => null,
			'show_fullname'         => false,
			'show_name_if_no_image' => null
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		if ( $author_id )
			$authordata = get_userdata( (int) $author_id );
		else
			global $authordata;

		$options = $this->get_options();

		if ( is_array( $class ) )
			$class = implode( ' ', $class );
		$class .= ' author-image';

		// Get the link to the image, if there is one
		if ( empty( $options['image_extensions'] ) )
			$output = '';
		else
			$output = $this->find_author_image( $authordata->ID, $image_dir, true, $use_gravatar );

		$show_fullname = empty( $options['show_fullname'] ) ? $show_fullname : $options['show_fullname'];
		if ( is_object( $authordata ) )
			$author_name = $show_fullname ? trim( $authordata->first_name . ' ' . $authordata->last_name ) : $authordata->display_name;
		else
			$author_name = null;
		$author_name = apply_filters( 'the_author', $author_name );

		if ( $output ) {
			$output = "<img src='$output' alt='" . esc_attr( $author_name ) . "' title='" . esc_attr( $author_name ) . "' class='$class'";
			$style = '';
			$width = empty( $width ) ? $options['width'] : $width;
			if ( $width )
				$style .= 'width:' . intval( $width ) . 'px;';
			$height = empty( $height ) ? $options['height'] : $height;
			if ( $height )
				$style .= 'height:' . intval( $height ) . 'px;';
			if ( ! empty( $style ) )
				$output .= " style='$style'";
			$output .= " />";
			if ( ( is_bool( $show_name ) && $show_name ) || ( is_null( $show_name) && $options['show_name'] ) )
				$output .= esc_html( $author_name );
		} else {
			if ( ( is_bool( $show_name_if_no_image ) && ! $show_name_if_no_image ) || ( is_null( $show_name_if_no_image ) && ! $options['show_name_if_no_image'] ) )
				return;
			$output = esc_html( $author_name );
		}

		// Hyperlink the author image/name, if requested to do so
		if ( 'posts' == $options['link_type'] )
			$output = '<a href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="Posts by ' . esc_attr( $author_name ) . '">' . $output . '</a>';
		elseif ( ('site' == $options['link_type']) && $authordata->user_url )
			$output = '<a href="' . $authordata->user_url . '" title="Visit ' . esc_attr( $author_name ) . '\'s site">' . $output . '</a>';

		return $before . $output . $after . "\n";
	} //end function get_author_image()

}

// To access plugin object instance use: c2c_AuthorImages::$instance
new c2c_AuthorImages();

endif;


if ( ! function_exists( 'c2c_get_author_image' ) ) :
/**
 * Returns the formatted author image markup.
 *
 * @param array $args (optional) Array of settings
 * @return void (Text is echoed)
 */
function c2c_get_author_image( $args = array() ) {
	return c2c_AuthorImages::$instance->get_author_image( $args );
}
add_filter( 'c2c_get_author_image', 'c2c_get_author_image' );
endif;


if ( ! function_exists( 'c2c_get_the_author_image' ) ) :
/**
 * Returns the formatted author image markup.
 *
 * @param string $before (optional) Text to display before the image. Default is ''.
 * @param string $after (optional) Text to display after the image. Default is ''.
 * @param string $image_dir (optional) The directory containing the author images. If '', then use the value configured in the plugin's settings.
 * @param string $width (optional) The forced width of the image (will cause browser to resize if image is of different width). Leave blank to retain image's original width (or for the width to be scaled in proportion to a specified height). It is recommended that images exist at the desired size.
 * @param string $height (optional) The forced height of the image (will cause browser to resize if image is of different height). Leave blank to retain image's original height (or for the height to be scaled in proportion to a specified width). It is recommended that images exist at the desired size.
 * @param int|null $author_id (optional) The id of the author to get the image for. Send null to get the image for the current author.
 * @return void (Text is echoed)
 */
function c2c_get_the_author_image( $before = '', $after = '', $image_dir = '', $width = '', $height = '', $author_id = null ) {
	return c2c_AuthorImages::$instance->get_the_author_image( $before, $after, $image_dir, $width, $height, $author_id );
}
add_filter( 'c2c_get_the_author_image', 'c2c_get_the_author_image', 10, 6 );
endif;


if ( ! function_exists( 'c2c_the_author_image' ) ) :
/**
 * Echoes the result of c2c_get_the_author_image()
 *
 * @param string $before (optional) Text to display before the image. Default is ''.
 * @param string $after (optional) Text to display after the image. Default is ''.
 * @param string $image_dir (optional) The directory containing the author images. If '', then use the value configured in the plugin's settings.
 * @param string $width (optional) The forced width of the image (will cause browser to resize if image is of different width). Leave blank to retain image's original width (or for the width to be scaled in proportion to a specified height). It is recommended that images exist at the desired size.
 * @param string $height (optional) The forced height of the image (will cause browser to resize if image is of different height). Leave blank to retain image's original height (or for the height to be scaled in proportion to a specified width). It is recommended that images exist at the desired size.
 * @return void (Text is echoed)
 */
function c2c_the_author_image( $before = '', $after = '', $image_dir = '', $width = '', $height = '' ) {
	echo c2c_get_the_author_image( $before, $after, $image_dir, $width, $height );
}
add_action( 'c2c_the_author_image', 'c2c_the_author_image', 10, 5 );
endif;


if ( ! function_exists( 'c2c_wp_list_authors_images' ) ) :
/**
 * List all the authors of the blog, with several options available.
 *
 * <ul>
 * <li>optioncount (boolean) (false): Show the count in parenthesis next to the
 * author's name.</li>
 * <li>exclude_admin (boolean) (true): Exclude the 'admin' user that is
 * installed bydefault.</li>
 * <li>show_fullname (boolean) (false): Show their full names. (you probably
 * want to set show_name to true as well so that the name appears)</li>
 * <li>hide_empty (boolean) (true): Don't show authors without any posts.</li>
 * <li>feed (string) (''): If isn't empty, show links to author's feeds.</li>
 * <li>feed_image (string) (''): If isn't empty, use this image to link to
 * feeds.</li>
 * <li>echo (boolean) (true): Set to false to return the output, instead of
 * echoing.</li>
 * <li>style (string) ('list'): Whether to display list of authors in list form
 * or as a string.</li>
 * <li>html (bool) (true): Whether to list the items in html for or plaintext.
 * </li>
 * <li>show_name (bool): Whether to show the name along with author image</li>
 * <li>show_name_if_no_image (bool): Whether to show name if not author image
 * was found for author</li>
 * </ul>
 *
 * @param array|string $args (optional) The arguments array
 * @return null|string The output, if echo is set to false.
 */
function c2c_wp_list_authors_images( $args = '' ) {
	global $wpdb, $c2c_author_images;
	$c2c_author_images = c2c_AuthorImages::$instance;
	$options = $c2c_author_images->get_options();

	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);

	$defaults = array(
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
		'style' => 'list', 'html' => true,
		'show_name' => false, 'show_name_if_no_image' => false, 'use_gravatar' => null,
		'before' => '', 'after' => '', 'image_dir' => null, 'width' => '', 'height' => '', 'class' => '' );
	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);
	$return = '';

	/** @todo Move select to get_authors(). */
	$users = function_exists( 'get_users' ) ? get_users() : get_users_of_blog();

	$author_ids = array();
	foreach ( (array) $users as $user )
		$author_ids[] = $user->ID;
	if ( count($author_ids) > 0  ) {
		$author_ids = implode(',', $author_ids );
		$authors = $wpdb->get_results( "SELECT ID, user_nicename from $wpdb->users WHERE ID IN($author_ids) " . ($exclude_admin ? "AND user_login <> 'admin' " : '') . "ORDER BY display_name" );
	} else {
		$authors = array();
	}

	$author_count = array();
 	foreach ((array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row) {
		$author_count[$row->post_author] = $row->count;
	}

	foreach ( (array) $authors as $author ) {

		$link = '';

		$author = get_userdata( $author->ID );
		$posts = (isset($author_count[$author->ID])) ? $author_count[$author->ID] : 0;
		$name = $author->display_name;

		if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') )
			$name = "$author->first_name $author->last_name";

		if( !$html ) {
			if ( $posts == 0 ) {
				if ( ! $hide_empty )
					$return .= $name . ', ';
			} else
				$return .= $name . ', ';

			// No need to go further to process HTML.
			continue;
		}

		// First determine what to show (author image or text of author name)
		$image = $c2c_author_images->get_author_image( array(
			'before' => $before, 'after' => $after, 'image_dir' => $image_dir,
			'width' => $width, 'height' => $height, 'author_id' => $author->ID, 'use_gravatar' => $use_gravatar,
			'class' => $class, 'show_name' => $show_name, 'show_name_if_no_image' => $show_name_if_no_image,
			'show_fullname' => $show_fullname
		) );

		if ( strpos( $image, '<img' ) === false ) // Ignore if the name is return but not the image
			$image = '';

		if ( empty( $image ) )
			continue;

//		// Wrap $image in link, if applicable
//		if ( 'posts' == $options['link_type'] && $posts != 0 )
//			$link = '<a href="' . get_author_posts_url($author->ID, $author->user_nicename) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $image . '</a>';
//		elseif ( ('site' == $options['link_type']) && $author->user_url )
//			$link = '<a href="' . $author->user_url . '" title="Visit ' . $name . '\'s site">' . $image . '</a>';
//		if ( empty( $link ) )
			$link = $image;

		if ( !($posts == 0 && $hide_empty) && 'list' == $style )
			$return .= '<li>';
		if ( $posts == 0 ) {
			if ( $hide_empty )
				$link = '';
		} else {
			if ( (! empty($feed_image)) || (! empty($feed)) ) {
				$link .= ' ';
				if (empty($feed_image))
					$link .= '(';
				$link .= '<a href="' . get_author_feed_link($author->ID)  . '"';

				if (! empty($feed)) {
					$title =  ' title="' . esc_attry($feed) . '"';
					$alt = ' alt="' . esc_attr($feed) . '"';
					$name = $feed;
					$link .= $title;
				}

				$link .= '>';

				if (! empty($feed_image))
					$link .= "<img src=\"" . esc_url($feed_image) . "\" border=\"0\"$alt$title" . ' />';
				else
					$link .= $name;

				$link .= '</a>';

				if ( empty($feed_image) )
					$link .= ')';
			}

			if ( $optioncount )
				$link .= ' (' . $posts .  ')';

		}

		if ( $posts || ! $hide_empty )
			$return .= $link . ( ( 'list' == $style ) ? '</li>' : ', ' );

	}

	$return = trim($return, ', ');

	if ( ! $echo )
		return $return;
	echo $return;
} // end function c2c_wp_list_authors_images()
add_action( 'c2c_wp_list_authors_images', 'c2c_wp_list_authors_images' );
endif;

?>
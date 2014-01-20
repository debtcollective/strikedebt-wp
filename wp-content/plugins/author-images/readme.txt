=== Author Image(s) ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: author, authors, image, avatar, widget, icon, post, list, coffee2code
Requires at least: 3.1
Tested up to: 3.3.1
Stable tag: 3.6
Version: 3.6

Display image (if present) and/or name for the author of a post, or for all authors on the blog.


== Description ==

Display image (if present) and/or name for the author of a post, or for all authors on the blog.

Use `<?php c2c_the_author_image(); ?>` as a replacement for `<?php the_author() ?>` or `<?php get_avatar(); ?>` in index.php (and/or any other post templates) to display an image for a post's author (inside "the loop")

Use `<?php c2c_wp_list_authors_images(); ?>` as a replacement for `<?php wp_list_authors(); ?>` in the sidebar section of your site to list all authors for the blog using an image and/or text.

The plugin also provides a simple widget for listing authors.

Process by which the image is located and/or text used:

1. If a post has an 'author_image' custom field defined, the plugin checks if the value is the valid name of an image in the defined image directory.  If not, it appends each of the defined image extensions, in turn, to the custom field's value, then checks if an image can be found.
1. If no image has been found yet, it looks in the image directory for a file with a name that is the author's login name with a file extension matching one of the ones defined in image extensions.
1. If no image has been found yet, it looks in the image directory for a file with a name that is the author's ID with a file extension matching one of the ones defined in image extensions.
1. If no image has been found yet and Gravatar support is enabled, it then asks Gravatar for the avatar associated with the author (based on author's email address).
1. If no image has been found yet and a blank/generic image has been defined, then the blank image is used as the author's avatar.
1. If an image has been found and the "Show author name as well?" setting is true, or if no author image has been found and "Show author name if image is found?" setting is true, then the author's name is appended/used.

Additional notes:

* The plugins admin options page allows you to control if the author's name should appear alongside the author image or not, if the author name should be shown in the event no author image could be found, the image directory, the support image extensions, and if and what you want the author image to link to.
* Images output by `c2c_the_author_image()` are defined with class="author_image" for stylesheet manipulation
* Images output by `c2c_wp_list_authors_images()` are defined with class="list_author_image" for stylesheet manipulation

Tip:: You can take advantage of the $image_dir argument to display different author images under different contexts, i.e. locate your images in different directories 'wp-content/images/authors/small/' and 'wp-content/images/authors/large/' and decide on context where to get the image(s) from.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/author-images/) | [Plugin Directory Page](http://wordpress.org/extend/plugins/author-images/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Whether installing or updating, whether this plugin or any other, it is always advisable to back-up your data before starting
1. Unzip `author-images.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Go to the Users -> Author Images admin options page.  Optionally customize the options.
1. Create the directory(s) that will contain author image(s) (path must be relative to wp-content/ directory) (by default this would be /wp-content/images/authors/)
1. Put images into the specified image directory, using the author login name or the author ID as the filename, 
with whatever extension you plan to support, i.e. admin.gif or 1.gif
1. (optional) Use the provided "Author Image(s)" widget, if so inclined.
1. (optional) Modify your index.php and/or other template files to include calls to `<?php c2c_the_author_image(); ?>` and/or
`<?php c2c_wp_list_authors_images(); ?>`.  (Read the rest of these notes for more info.)
1. (optional) Add the custom field 'author_image' to posts to explicitly define an image for the author for just that post.  Otherwise, the plugin will proceed to attempt to find the author image.
1. (optional) Add the class "author_image" to your CSS file to control the display of the image located by `c2c_the_author_image()`, and/or add the class "list_author_image" to your CSS file to control the display of the images listed by `c2c_wp_list_authors_images()`.


== Screenshots ==

1. A screenshot of the plugin's admin options page.
2. A screenshot of the plugin's widget configuration.


== Frequently Asked Questions ==

= Where do I go to upload the author images? =

Currently this plugin does not facilitate the uploading of images.  It assumes you've already managed to get the author images onto your server into the appropriate directories.

= Does this have a widget? =

Yes, called "Author Image(s)".


== Template Tags ==

The plugin provides three optional template tags for use in your theme templates.

= Functions =

* `function c2c_get_author_image( $args = array() )`
Gets the image and/or name for an author.

* `function c2c_the_author_image( $before = '', $after = '', $image_dir = '', $width = '', $height = '' )`
A drop-in replacement for WordPress's `the_author()` , allowing the author for the post to have an image displayed in lieu of the name (if an image can be found).

* `function c2c_wp_list_authors_images( $args = '' )`
A drop-in replacement for WordPress's `wp_list_authors()`, allowing all authors for a blog to be listed with an image (if present).

This displays the image associated with a post's categories.

= Arguments =

* `$before`
Optional argument.  The text and/or HTML to appear before the author image/text, if any such text would be returned.

* `$after`
Optional argument.  The text and/or HTML to appear after the author image/text, if any such text would be returned.

* `$image_dir`
Optional argument.  The directory, relative to the root of your blog, in which to find the author images.  If not set, it defaults to the value configured via the plugin's admin options page.

* `$width`
Optional argument.  The forced width of the image (will cause browser to resize if image is of different width). Leave blank to retain image's original width (or for the width to be scaled in proportion to a specified height). It is recommended that images exist at the desired size.

* `$height`
Optional argument.  The forced height of the image (will cause browser to resize if image is of different height). Leave blank to retain image's original height (or for the height to be scaled in proportion to a specified width). It is recommended that images exist at the desired size.

* `$author_id`
Optional argument. The id of the author. If null, then gets the author for the current post. Default is null.

* `$args` (as used in `c2c_get_author_image()`)
Optional argument.  An array of configuration options.
    * author_id : default of current post author; the id of the author to get the image for
    * before : default of ''; text to show before each author
    * after : default of ''; text to show after each author
    * image_dir : default of ''; directory containing author images, relative to wp-content directory
    * width : default of ''; width to display image
    * height : default of ''; height to display image
    * show_name : default of '' which means it'll abide by the plugin's setting value; should the name of the author be shown in addition to the image?
    * show_fullname : default of false; should the user's first and last name be shown instead of the author's configured display name? (be sure to set 'show_name' to true if you want the name to appear in the first place)
    * show_name_if_no_image : default of '' which means it'll abide by the plugin's setting value; should the author's name be shown if the author doesn't have an image?
    * class : default of ''; array or string of classes to apply to author image tag
    * use_gravatar : default of plugin settings; should Gravatar be consulted for an author image if no local image for the author was found?

* `$args` (as used in `c2c_wp_list_authors_images`)
Optional argument.  An array of configuration options.  All but the last two match up with the supported arguments of the `wp_list_authors()` function.
    * optioncount : default of false;
    * exclude_admin : default of true; should the admin user be excluded from the listing?
    * hide_empty : default of true; should authors who have not made any posts be excluded from the listings?
    * feed : default of ''
    * feed_image : default of ''
    * echo : default of true; should the listing be echoed to the page?
    * show_name : default of '' which means it'll abide by the plugin's setting value; should the name of the author be shown in addition to the image?
    * show_fullname : default of false; should the user's first and last name be shown instead of the author's configured display name? (be sure to set 'show_name' to true if you want the name to appear in the first place)
    * show_name_if_no_image : default of `''` which means it'll abide by the plugin's setting value; should the author's name be shown if the author doesn't have an image?
    * before : default of ''; text to show before each author
    * after : default of ''; text to show after each author
    * image_dir : default of ''; directory containing author images, relative to wp-content directory
    * width : default of ''; width to display image
    * height : default of ''; height to display image
    * class : default of ''; array or string of classes to apply to author image tag
    * use_gravatar : default of plugin settings; should Gravatar be consulted for an author image if no local image for the author was found?


== Examples ==

* Show the author image for the current post's author (must be "in the loop")

`<?php c2c_the_author_image(); ?>`

* Get the author image from a different directory when on a post's permalink page (for instance, show a larger image on the permalink page)

`<?php c2c_the_author_image( '', '', (is_single() ? 'wp-content/images/authors/large' : '') ); ?>`

* List all authors in the sidebar

`<ul>
  <?php c2c_wp_list_authors_image(); ?>
</ul>`

* Change some default options when listing authors

`<ul>
  <?php c2c_wp_list_authors_image(array('exclude_admin' => false, 'show_name_if_no_image' => true)); ?>
</ul>`


== Filters ==

The plugin exposes two filters and two actions for hooking.  Typically, customizations utilizing these hooks would be put into your active theme's functions.php file, or used by another plugin.

= c2c_get_author_image (filter) =

The 'c2c_get_author_image' hook allows you to use an alternative approach to safely invoke `c2c_get_author_image()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_get_author_image()`

Example:

Instead of:

    `<?php $image = c2c_get_author_image( array( 'show_name' => false ) ); ?>`

Do:

    `<?php $image = apply_filters( 'c2c_get_author_image', array( 'show_name' => false ) ); ?>`

= c2c_get_the_author_image (filter) =

The 'c2c_get_the_author_image' hook allows you to use an alternative approach to safely invoke `c2c_get_the_author_image()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_get_the_author_image()`

Example:

Instead of:

    `<?php $image = c2c_get_the_author_image(); ?>`

Do:

    `<?php $image = apply_filters( 'c2c_get_the_author_image', ''); ?>`

= c2c_the_author_image (action) =

The 'c2c_the_author_image' hook allows you to use an alternative approach to safely invoke `c2c_the_author_image()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for `c2c_the_author_image()`

Example:

Instead of:

    `<?php c2c_the_author_image( '<span class="author">', '</span>', '/images' ); ?>`

Do:

    `<?php echo do_action( 'c2c_the_author_image', '<span class="author">', '</span>', '/images' ); ?>`

= c2c_wp_list_authors_images (action) =

The 'c2c_wp_list_authors_images' hook allows you to use an alternative approach to safely invoke `c2c_wp_list_authors_images()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.

Arguments:

* same as for c2c_wp_list_authors_images()

Example:

Instead of:

    `<?php echo c2c_wp_list_authors_images( array( 'hide_empty' => false ) ); ?>`

Do:

    `<?php echo do_action( 'c2c_wp_list_authors_images', array( 'hide_empty' => false ) ); ?>`


== Changelog ==

= 3.6 =
* Fix bug in c2c_wp_list_authors_images() where 'show_fullname' value was ignored
* Add new setting 'show_fullname' to force use of author full name instead of display name
* Add new widget setting 'show_fullname' to force use of author full name instead of display name
* For get_author_image(), add support for 'show_fullname' setting (default of false)
* Move template function docs into help tabs (for WP 3.3+)
* Add help_tabs_content()
* Remove register_filters()
* Update plugin framework to 034
* Remove support for 'c2c_author_images' global
* Note compatibility through WP 3.3+
* Drop compatibility with versions of WP older than 3.1
* Change parent constructor invocation
* Create 'lang' subdirectory and move .pot file into it
* Regenerate .pot
* Add more FAQs
* Minor code reformatting (spacing)
* Minor phpDoc reformatting
* Add 'Domain Path' directive to top of main plugin file
* Add link to plugin directory page to readme.txt
* Tweak installation instructions in readme.txt
* Update screenshots for WP 3.3
* Update copyright date (2012)

= 3.5.2 =
* Fix to change parent class constructor invocation

= 3.5.1 =
* Fix fatal shortcode bug by updating widget framework to v005 to make a protected class variable public
* Create 'lang' subdirectory and move .pot file into it
* Update plugin framework to version 027
* Update widget version to 002

= 3.5 =
* Add 'Author Images' widget, which allows listing authors by image (and also, optionally, name)
* Add class method get_author_image() which takes $args array to configure various options
* Add template tag c2c_get_author_image() which invokes class's get_author_image()
* Add filter 'c2c_get_author_image'
* Add support for Gravatar, to be used if no local author image is discovered
* Add support for blank image, to be used if no local author image is discovered and (if enabled) no Gravatar image is found
* Add options for enabling Gravatar support and for defining location for blank image
* Add support to c2c_wp_list_authors_images() to configure: before, after, image_dir, width, and height
* Add $author_id argument (optional) to class function get_the_author_image() to allow getting the author image for a specified author
* Add $author_id argument (optional) to c2c_get_the_author_image() to allow getting the author image for a specified author
* Add $use_gravatar argument (optional) to class function find_author_image()
* Move admin options page to under "Users"
* Require images to be relative to content_url and not root of blog
* Change c2c_wp_list_authors_images() to call get_the_author_image() instead of find_author_image()
* Add __construct(), activation(), and uninstall()
* Update plugin framework to version 025
* Save a static version of itself in class variable $instance
* Deprecate use of global variable $c2c_author_images to store instance
* Note compatibility through WP 3.2+
* Drop compatibility with versions of WP older than 3.0
* Update screenshot-1.png
* Add screenshot-2.png (of widget)
* Explicitly declare all functions as public
* Minor code formatting changes (spacing)
* Update copyright date (2011)
* Add plugin homepage and author links in description in readme.txt
* Improve some readme formatting
* Regenerate .pot
* Add changelog info for pre-3.0 releases

= 3.0 =
* Re-implementation by extending C2C_Plugin_012, which among other things adds support for:
    * Reset of options to default values
    * Better sanitization of input values
    * Offload of core/basic functionality to generic plugin framework
    * Additional hooks for various stages/places of plugin operation
    * Easier localization support
* Add setting 'height' to allow for forced browser-scaling of the height of the author image (better if the original image is of desired size)
* Add setting 'width' to allow for forced browser-scaling of the width of the author image (better if the original image is of desired size)
* Add setting 'custom_field' to allow easier configuration of the post custom field for defining a specific author image to use for the post (default is 'author_image')
* For get_the_author_image(), c2c_get_the_author_image(), and c2c_the_author_image(), add optional $width and $height arguments to force image width/height
* Add filters 'c2c_get_the_author_image', 'c2c_the_author_image', and 'c2c_wp_list_authors_images' to respond to the function of the same name so that users can use the do_action('c2c_the_author_image') notation for invoking template tags
* For c2c_wp_list_authors_images(), add support in $args for 'feed_type', 'style', and 'html'
* Rename class from 'AuthorImages' to 'c2c_AuthorImages'
* Rename the global instance variable from 'author_images' to 'c2c_author_images'
* Trim leading and trailing forward slashes from the custom field value before use
* Change to make leading and trailing forward slashes optional for $image_dir value
* Wrap each global function in function_exists() check
* Use get_options() instead of get_settings()
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Note compatibility with WP 2.8+, 2.9+, 3.0+
* Drop compatibility with versions of WP older than 2.8
* Minor tweaks to code formatting (spacing)
* Regenerate .pot
* Add Changelog and Upgrade Notice sections to readme.txt
* Add PHPDoc documentation
* Add package info to top of file
* Update copyright date
* Remove trailing whitespace
* Add screenshot
* Adding to WP plugin repository

= 2.0 =
* Wrapped into its own class
* Added admin options page under Options -> Author Images (or in WP 2.5: Settings -> Author Images). Options are now saved to database, negating need to customize code within the plugin source file.
* Now looks for user image based on user login name first, then user ID.
* Changed/removed the arguments to most of the functions. $images_extensions and $images_dir are now plugin options.
* Used get_author_posts_url() instead of get_author_link()
* Fixed bug that prevented the custom field override of the author image from working as expected
* Numerous compatibility updates
* c2c_the_author_image() now just directly echoes the return value of c2c_get_the_author_image();
* c2c_the_author_image() and c2c_get_the_author_image() take as optional arguments $before, $after, and $image_dir
* c2c_wp_list_authors_images() now takes 'show_name' and 'show_name_if_no_image' as part of optional arguments array; both are defaulted to the respective values configured via the plugin's admin
* Changed description; updated installation instructions
* Added compatibility note
* Updated copyright date and version to 2.0
* Moved into its own subdirectory; added readme.txt
* Tested compatibility with WP 2.3.3 and 2.5

= 1.0 =
* (unknown at present)

= 0.9 =
* Initial release


== Upgrade Notice ==

= 3.6 =
Recommended update. Highlights: fix bug in which 'show_fullname' was ignored; support 'show_fullname' with setting and widget setting; noted compatibility with WP 3.3+; updated plugin framework; and more.

= 3.5.2 =
Bugfix release: fixed typo

= 3.5.1 =
Critical bugfix release (if using shortcode): fixed fatal shortcode bug; created 'lang' subdirectory and moved .pot file into it

= 3.5 =
Recommended update.  Added widget; added Gravatar support; moved menu location; noted WP 3.2 compatibility; dropped support for versions of WP older than 3.0; updated plugin framework; and more.

= 3.0 =
Recommended update. Highlights: re-implementation; added more settings and hooks for customization; misc improvements; verified WP 3.0 compatibility; dropped compatibility with WP older than 2.8; added to WP plugin repository.
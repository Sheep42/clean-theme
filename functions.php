<?php

function cleantheme_init() {

	// Example simple post type registration
	// cleantheme_register_post_type( 'Book', 'Books', 'book', 5, 'book-listing' );
	
	/**
	** 	Render a virtual page
	** 
	**  This is useful if you need to create a url
	**  outside of the context of WordPress which has to
	**  render content. 
	** 
	**  For example, a dynamically generated pdf download 
	**  located at https://example.com/my-pdf?first_name=John&last_name=Smith
	**  
	**  To use this, uncomment below and replace 'virtual-page-slug' with
	**  your own page slug.
	
		function cleantheme_query_vars( $query_vars ) {
			$query_vars[] = 'virtual-page-slug';
			
		    return $query_vars;
		}
		add_filter( 'query_vars', 'cleantheme_query_vars' );

		function cleantheme_template_redirect() {
			global $wp_query;

		    if ( array_key_exists( 'virtual-page-slug', $wp_query->query_vars ) ) {
		        
	            // Render the page contents
	            // Ex: __cleantheme_render_virtual_page(); 
	           	// get_template_part( 'template-parts/page/content', 'virtual' );
		        
		        // must end with a call to exit
		        exit;
			}
			
		    return;
		}
		add_action( 'template_redirect', 'cleantheme_template_redirect' );

		add_rewrite_rule( 'virtual-page-slug$', 'index.php?virtual-page-slug=1', 'top' );

	**
	**/

}
add_action( 'init', 'cleantheme_init' );

function cleantheme_admin_init() {

}
add_action( 'admin_init', 'cleantheme_admin_init' );

function cleantheme_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'cleantheme' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'cleantheme-featured-image', 2000, 1200, true );
	add_image_size( 'cleantheme-thumbnail-avatar', 100, 100, true );

	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'cleantheme' ),
		'social'    => __( 'Social Menu', 'cleantheme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	cleantheme_front_page_template( 'front-page.php' );

}
add_action( 'after_setup_theme', 'cleantheme_setup' );

/**
 *  Abstraction for SIMPLE post type registration, to override arguments
 *  or change post capability type you should use register_post_type directly.
 *
 *  Remember to flush permalinks after registering a new post type
 *
 * @param 	string 	$singular 			The singular display name for the post type
 * @param 	string 	$plural 			The plural display name for the post type
 * @param   string 	$slug 	 			The post type slug
 * @param   int 	$menu_position 	 	The menu position for the post type - defaults to 5
 * @param   string 	$rewrite 	 		Override the archive slug for this post type - defaults to $slug
 * @param   bool 	$archive 	 		True / False - Create an archive for this post type
 * @param   bool 	$hierarchical 		True / False - Is this post type hierarchical? (Does it have parent / child relationships)
 * @param 	array 	$supports 			The supports array for this post type - See codex for details
 */
function cleantheme_register_post_type( 
	$singular, 
	$plural, 
	$slug, 
	$menu_position = 5, 
	$rewrite = '', 
	$archive = true, 
	$hierarchical = true, 
	$supports = array( 'title', 'editor', 'thumbnail' ) 
) {

	// Bail if missing any of the 3 absolute requirements
	if( empty( $singular ) || empty( $plural ) || empty( $slug ) ) {
		return;
	}

	$rewrite = empty( $rewrite ) ? $slug : $rewrite;

	$labels = array(
        'name'                  => _x( $plural, '', 'cleantheme' ),
        'singular_name'         => _x( $singular, '', 'cleantheme' ),
        'menu_name'             => _x( $plural, '', 'cleantheme' ),
        'name_admin_bar'        => _x( $singular, '', 'cleantheme' ),
        'add_new'               => __( 'Add New', 'cleantheme' ),
        'add_new_item'          => __( 'Add New ' . $singular, 'cleantheme' ),
        'new_item'              => __( 'New ' . $singular, 'cleantheme' ),
        'edit_item'             => __( 'Edit ' . $singular, 'cleantheme' ),
        'view_item'             => __( 'View ' . $singular, 'cleantheme' ),
        'all_items'             => __( 'All '. $plural, 'cleantheme' ),
        'search_items'          => __( 'Search ' . $plural, 'cleantheme' ),
        'parent_item_colon'     => __( 'Parent ' . $plural . ':', 'cleantheme' ),
        'not_found'             => __( 'No ' . $plural .' found.', 'cleantheme' ),
        'not_found_in_trash'    => __( 'No ' . $plural . ' found in Trash.', 'cleantheme' ),
        'featured_image'        => _x( $singular . ' Featured Image', '', 'cleantheme' ),
        'set_featured_image'    => _x( 'Set featured image', '', 'cleantheme' ),
        'remove_featured_image' => _x( 'Remove featured image', '', 'cleantheme' ),
        'use_featured_image'    => _x( 'Use as featured image', '', 'cleantheme' ),
        'archives'              => _x( $singular . ' archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'cleantheme' ),
        'insert_into_item'      => _x( 'Insert into ' . $singular, '', 'cleantheme' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this ' . $singular, '', 'cleantheme' ),
        'filter_items_list'     => _x( 'Filter ' . $plural . ' list', '', 'cleantheme' ),
        'items_list_navigation' => _x( $plural . ' list navigation', '', 'cleantheme' ),
        'items_list'            => _x( $plural . ' list', '', 'cleantheme' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => ( $rewrite ) ),
        'capability_type'    => 'post',
        'has_archive'        => $archive,
        'hierarchical'       => $hierarchical,
        'menu_position'      => $menu_position,
        'supports'           => $supports,
    );
 
    register_post_type( $slug, $args );
}

/**
 * Register custom fonts.
 */
function cleantheme_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'cleantheme' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since cleantheme 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function cleantheme_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'cleantheme-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'cleantheme_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cleantheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'cleantheme' ),
		'id'            => 'footer-widgets',
		'description'   => __( 'Add widgets here to appear in your footer', 'cleantheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'cleantheme_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function cleantheme_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'cleantheme' ), get_the_title( get_the_ID() ) )
	);

	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'cleantheme_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since cleantheme 1.0
 */
function cleantheme_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'cleantheme_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function cleantheme_enqueue_scripts() {
	// TODO: Add caching version
	
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'cleantheme-fonts', cleantheme_fonts_url(), array(), null );

	// Theme base stylesheet.
	wp_enqueue_style( 'cleantheme-style', get_stylesheet_uri() );

	// enqueue main.min.js
	wp_enqueue_script( 'cleantheme-main-scripts', get_theme_file_uri( '/assets/js/build/theme/main.min.js' ), array( 'jquery' ), '1.0', true );
	wp_script_add_data( 'cleantheme-main-scripts', 'conditional', 'lt IE 9' );

	/**
	 *  Move scripts to the footer
	 */
	foreach( wp_scripts()->registered as $script ) {
		// don't defer jquery

		$dont_defer = array( 'jquery' );

		if( in_array( $script->handle, $dont_defer ) ) {
			wp_script_add_data( $script->handle, 'group', 0 );
		} else {
			wp_script_add_data( $script->handle, 'group', 1 );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'cleantheme_enqueue_scripts' );

/**
 * Enqueue Admin scripts and styles
 */
function cleantheme_admin_enqueue_scripts() {
	
	// enqueue admin.min.js
	wp_enqueue_script( 'cleantheme-admin-scripts', get_theme_file_uri( '/assets/js/build/admin/admin.min.js' ), array( 'jquery' ), '1.0', true );

}
add_action( 'admin_enqueue_scripts', 'cleantheme_admin_enqueue_scripts' );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since cleantheme 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function cleantheme_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'cleantheme_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since cleantheme 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function cleantheme_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'cleantheme_widget_tag_cloud_args' );

/**
 * Checks to see if we're on the homepage or not.
 */
function cleantheme_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

function cleantheme_doing_ajax() {
	return function_exists('wp_doing_ajax') ? wp_doing_ajax() : (defined('DOING_AJAX') && DOING_AJAX);
}

function cleantheme_doing_cron() {
	return function_exists('wp_doing_cron') ? wp_doing_cron() : (defined('DOING_CRON') && DOING_CRON);
}

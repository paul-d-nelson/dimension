<?php
/**
 * Dimension functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimension
 */

if ( ! function_exists( 'dimension_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dimension_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Dimension, use a find and replace
	 * to change 'dimension' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dimension', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'dimension' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dimension_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_theme_support('custom-logo');
}
endif;
add_action( 'after_setup_theme', 'dimension_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dimension_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dimension' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'dimension' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dimension_widgets_init' );

function dimension_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/**
 * Wrap the inserted image html with <figure>
 * if the theme supports html5 and the current image has no caption:
 */
add_filter( 'image_send_to_editor',
    function( $html, $id, $caption, $title, $align, $url, $size, $alt )
    {
        if( current_theme_supports( 'html5' )  && ! $caption )
            $html = sprintf( '<figure>%s</figure>', $html ); // Modify to your needs!

        return $html;
    }
, 10, 8 );

/**
 * Add custom image sizes
 */
add_image_size( 'full-width', 1920 );

// Register the new image sizes for use in Add Media modal
add_filter( 'image_size_names_choose', 'dimension_custom_sizes' );
function dimension_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'full-width' => __( 'Full Width' ),
	) );
}

function dimension_allowedtags() {
	// Add custom tags to this string
	return '<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>';
}

if ( ! function_exists( 'dimension_custom_wp_trim_excerpt' ) ) :
/**
 * Custom excerpt that trims after the first paragraph of a post.
 */
	function dimension_custom_wp_trim_excerpt($dimension_excerpt) {
		global $post;
		$raw_excerpt = $dimension_excerpt;
		if ( '' == $dimension_excerpt ) {

			$dimension_excerpt = get_the_content('');
			$dimension_excerpt = strip_shortcodes( $dimension_excerpt );
			$dimension_excerpt = apply_filters('the_content', $dimension_excerpt);
			$dimension_excerpt = substr( $dimension_excerpt, 0, strpos( $dimension_excerpt, '</p>' ) + 4 );
			$dimension_excerpt = str_replace(']]>', ']]&gt;', $dimension_excerpt);
			$dimension_excerpt = strip_tags($dimension_excerpt, dimension_allowedtags());

			// Read more link
			// $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '" class="read-more">' . sprintf(__( 'Read more', 'dimension' )) . '</a>';
			// $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

			// $dimension_excerpt .= $excerpt_end;

			return $dimension_excerpt;

		}
		return apply_filters('dimension_custom_wp_trim_excerpt', $dimension_excerpt, $raw_excerpt);
	}

endif;

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'dimension_custom_wp_trim_excerpt');

if ( ! function_exists( 'dimension_fonts_url' ) ) :
/**
 * Register Google fonts for Dimension.
 *
 * Create your own dimension_fonts_url() function to override in a child theme.
 *
 * @return string Google fonts URL for the theme.
 */
function dimension_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'dimension' ) ) {
		$fonts[] = 'Open+Sans:400,700,400italic,700italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'dimension' ) ) {
		$fonts[] = 'Montserrat';
	}

	/* translators: If there are characters in your language that are not supported by Source Code Pro, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Source Code Pro font: on or off', 'dimension' ) ) {
		$fonts[] = 'Source Code Pro';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 */
function dimension_scripts() {
	// wp_enqueue_style( 'dimension-style', get_stylesheet_uri() );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'dimension-fonts', dimension_fonts_url(), array(), null );

	wp_enqueue_style( 'dimension-style', get_template_directory_uri() . '/public/css/main.css', array(), '20160929');

	// Use a more current version of jQuery.
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js", false, null);
	wp_enqueue_script('jquery');

	// wp_enqueue_script( 'dimension-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'dimension-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'dimension-app', get_template_directory_uri() . '/public/js/app.js', array(), '20161003', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dimension_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

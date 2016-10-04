<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package Dimension
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function dimension_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'dimension_infinite_scroll_render',
		'footer'    => false,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Featured Content.
	add_theme_support( 'featured-content', array(
		'filter'     => 'dimension_get_featured_posts',
		'max_posts'  => 1,
		'post_types' => array( 'post', 'page' ),
	) );
}
add_action( 'after_setup_theme', 'dimension_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function dimension_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/**
 * Custom filter for getting Featured Content.
 */
function dimension_get_featured_posts() {
	return apply_filters( 'dimension_get_featured_posts', array() );
}

/**
 * A helper function for Featured Content.
 */
function dimension_has_featured_posts( $minimum = 1 ) {
	if ( is_paged() )
		return false;

	$minimum = absint( $minimum );
	$featured_posts = apply_filters( 'dimension_get_featured_posts', array() );

	if ( ! is_array( $featured_posts ) )
		return false;

	if ( $minimum > count( $featured_posts ) )
		return false;

	return true;
}
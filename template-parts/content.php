<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dimension
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
			</figure>
		<?php endif; ?>

		<header class="entry-header">
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'dimension' ) );
			if ( $categories_list && dimension_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( '%1$s', 'dimension' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php dimension_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->
	</div><!-- .post-header -->

	<div class="entry-content">
		<?php
		if ( is_single() ):
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'dimension' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

		else:
			the_excerpt();

			echo '<p><a href="' . get_permalink() . '"> Read More...</a></p>';
		endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dimension' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php dimension_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

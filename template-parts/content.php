<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dimension
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('aesop-entry-content'); ?>>

	<div class="post-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<!-- <figure class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
			</figure> -->
			<div class="post-thumb" style="background: url('<?php the_post_thumbnail_url(); ?>') no-repeat center center;background-size: cover;"></div>
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
			<?php if (is_single()):
					echo "<span class='comments-popup-link'>";
					comments_popup_link();
					echo "</span>";
				endif;
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

			// echo "<p class='read-more'><a href='" . get_the_permalink() . "'>Read More</a></p>";
		endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dimension' ),
				'after'  => '</div>',
			) );
		?>

		<!-- Share BEGIN -->
		<?php if ( is_single() ): ?>
			<?php $share_link = urlencode(get_the_permalink()); ?>
			<ul class="share-icons">
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_link; ?>" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
				<li><a href="https://twitter.com/intent/tweet/?url=<?php echo $share_link; ?>&via=Paul_D_Nelson" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
				<li><a href="https://plus.google.com/share?url=<?php echo $share_link; ?>" target="_blank"><i class="fa fa-google-plus-square"></i></a></li>
			</ul>
		<?php endif; ?>
		<!-- Share END -->
	</div><!-- .entry-content -->

	<?php if (is_single()) : ?>
		<footer class="entry-footer">
			<?php dimension_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->

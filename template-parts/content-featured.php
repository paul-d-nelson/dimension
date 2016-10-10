<?php
/**
 * Include for Jetpack Featured Content.
 *
 * @package Dimension
 */
?>

<div class="featured-content">

	<?php
		$featured_posts = dimension_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );
	?>

		<a href="<?php the_permalink(); ?>" rel="bookmark">
		<?php if ( has_post_thumbnail() ) : ?>
			<!-- <figure class="featured-thumb">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
			</figure> -->
			<div class="featured-thumb" style="background: url('<?php the_post_thumbnail_url(); ?>') no-repeat center center;background-size: cover;"></div>
		<?php endif; ?>
			<header class="featured-header">
				<h2>Featured</h2>
				<h1><?php the_title(); ?></h1>
				<?php the_excerpt(); ?>
			</header>
		</a>

	<?php
		endforeach;
		wp_reset_postdata();
	?>
</div>
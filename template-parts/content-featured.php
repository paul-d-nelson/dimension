<?php
/**
 * Include for Jetpack Featured Content.
 *
 * @package Dimension
 */
?>

<div class="featured">

	<?php
		$featured_posts = dimension_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );
	?>

		<a href="<?php the_permalink(); ?>" rel="bookmark"></a>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-thumb" style="background: url('<?php the_post_thumbnail_url(); ?>') no-repeat center center;background-size: cover;"></div>
		<?php endif; ?>

		<header class="featured-header">
			<h2>Featured</h2>
			<h1><?php the_title(); ?></h1>
			<?php the_excerpt(); ?>
		</header>

	<?php
		endforeach;
		wp_reset_postdata();
	?>
</div>
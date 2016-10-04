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
			<figure class="featured-thumb">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
			</figure>
			<header class="featured-header">
				<!-- <h2>Featured</h2> -->
				<h1><?php the_title(); ?></h1>
				<p><?php the_excerpt(); ?></p>
			</header>
		</a>

	<?php
		endforeach;
		wp_reset_postdata();
	?>
</div>
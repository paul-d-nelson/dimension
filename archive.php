<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dimension
 */

// Get the category image src if it exists
if (function_exists('category_image_src')) {
	$category_image = category_image_src( array( 'size' => 'full' ) , false );
} else {
	$category_image = '';
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

		<?php if ($category_image) : ?>

			<!-- category featured image -->
			<!-- <img src="<?php echo $category_image; ?>" alt="<?php single_cat_title();?>" desc="<?php echo wp_strip_all_tags( category_description() );?>"/> -->
			<div class="category-image" style="background: url('<?php echo $category_image; ?>') no-repeat center center;background-size: cover;"></div>

		<?php else : ?>

			<?php $background_image = get_template_directory_uri() . '/public/img/black_mamba.png'; ?>

			<div class="category-image" style="background: url('<?php echo $background_image; ?>') repeat;"></div>

		<?php endif; ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			// the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();

<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php

$cat_id = get_query_var( 'cat' );

$the_query = new WP_Query( 'tag=featured&cat='.$cat_id );

if ($the_query->have_posts()) {
	$the_query->the_post();
	?>
	<div class="featured-area">
		<div class="alignleft feature-image"><?php the_post_thumbnail("thumbnail"); ?></div>
		<div class="featured-post"><?php get_template_part( 'content', get_post_format() ); ?></div>
	</div>
	<?php
}

wp_reset_query(); 

?>
	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="entry-header">
				<h1 class="entry-title"><?php printf( __( '%s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
			</header>
			<?php

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				
				if (!has_tag( 'featured')) {
					get_template_part( 'content', get_post_format() );
				}

			endwhile;

			kriesi_pagination();

			// twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php 	
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );

				$the_query = new WP_Query( 'category_name=covering-islamic-law');

			    // The Loop
			    while ( $the_query->have_posts() ) :
			        $the_query->the_post();
			        get_template_part( 'content', get_post_format());
			    endwhile;

	    		wp_reset_query(); 
			endwhile; // end of the loop. 
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
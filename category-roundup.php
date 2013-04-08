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

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<div class="entry-header-text">
				<p>We round up stories involving Islamic law as they appear in American news media. We are an impartial, academic entity; we provide readers with objective information, and we always clearly identify the commentary we publish. We avoid publishing pieces favoring only one side of a debate or case, and instead aim to publish a diversity of expert opinions on a given topic. To submit articles for consideration, email <a href="mailto:submissions@islawmix.com?Subject=Submissions to islawmix" target="_blanks">submissions@islawmix.com</a>.</p>
			</div>

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
				
				get_template_part( 'content', get_post_format() );

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
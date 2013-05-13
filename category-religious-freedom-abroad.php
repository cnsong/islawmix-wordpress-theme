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

$the_query = new WP_Query( 'tag=feature-religious-freedom-abroad&cat='.$cat_id );

if ($the_query->have_posts()) {
	$the_query->the_post();

	$origpostdate = get_the_date($d, $the_post->post_parent);
	$origposttime = get_the_time($d, $the_post->post_parent);
	$dateline = $origpostdate.' '.$origposttime;

	?>
	<div class="featured-area">
		<?php 
		if ( has_post_thumbnail() ) { ?>
			<div class="alignleft feature-image"><?php the_post_thumbnail("thumbnail"); ?></div>
		<?php } ?>
		<div class="featured-post">
			<header class="entry-header">
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
				<div class="entry-date"><?php echo $dateline; ?></div>
			</header>
			<div class="entry-content"><?php the_excerpt(); ?></div>
		</div>
	</div>

	<?php
}

wp_reset_query(); 

?>
	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php
		
		$tag = get_term_by('slug', 'feature-religious-freedom-abroad', 'post_tag');
		$tag_id =  $tag->term_id; 

		$args = array(
			'cat' => $cat_id,
			'tag__not_in' => array( $tag_id  ),
			'paged' => $paged
		);

		$the_query = new WP_Query( $args );

		?>

		<?php if ( $the_query->have_posts() ) : ?>
			<header class="entry-header">
				<h1 class="entry-title"><?php printf( __( '%s', 'twentytwelve' ), '<div class="title-bold-upp">' . single_cat_title( '', false ) . '</div>' ); ?></h1>
			</header>
			<div class="scholar_related_posts">
				<h1>Recent Related Posts:</h1>
			
			<?php

			/* Start the Loop */
			while ( $the_query->have_posts() ) :
					$the_query->the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				
				get_template_part( 'content', get_post_format() );

			endwhile;

			?>

			</div>

			<?php

			kriesi_pagination($the_query->max_num_pages);

			// twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		<?php
		$test_query = new WP_Query( 'page_id=8125' );
		$test_query->the_post();
		?>
		<div class="entry-content add-info">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
		</div>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
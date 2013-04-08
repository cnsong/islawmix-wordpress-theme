<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<div class="breadcrumbs">
				<?php if(function_exists('bcn_display'))
				{
				    bcn_display();
				}?>
			</div>

			<?php while ( have_posts() ) : the_post(); ?>

				<header class="entry-header">
					<?php if ( is_single() ) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php else : ?>
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
					<?php endif; // is_single() ?>
				</header>
				<div class="entry-content-scholar">
					<?php
					/* Retrieve custom fields from Scholar posts */
					$image_key_values = get_post_custom_values('scholar_image');
					$image_url = $image_key_values[0];

					$affiliation_key_values = get_post_custom_values('scholar_affiliation');
					$affiliation = $affiliation_key_values[0];

					$position_key_values = get_post_custom_values('scholar_position');
					$position = $position_key_values[0];
					?>
			   
					<img class="scholar_image" src="<?php echo $image_url ?>" alt="" />
					<div class="scholar_affiliation"><?php echo $affiliation ?></div>
					<div class="scholar_position"><?php echo $position ?></div>
					<div><?php echo apply_filters( 'the_content', get_the_content() ); ?></div>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
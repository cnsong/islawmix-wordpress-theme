<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php
$the_query = new WP_Query( 'tag=home-feature' );

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

	<div id="primary" class="site-content">
		<div id="content" role="main">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php 

			while ( have_posts() ) : the_post();

				if ( !has_tag( 'home-feature') ) {
					get_template_part( 'content', get_post_format() );
				}

			endwhile; 

			?>

			<?php kriesi_pagination(); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar( 'main' ); ?>
<?php get_footer(); ?>
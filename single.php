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

				<?php get_template_part( 'content', get_post_format() ); ?>

				<?php if(has_category()) : ?>
					<div class='category-list-header'>Other categories for this post:</div>
				<?php endif; ?>
				<ul class="category-list">
				<?php
				foreach((get_the_category()) as $category) {
				    if($category->name==$homecat) continue;
				    $category_id = get_cat_ID( $category->cat_name );
				    $category_link = get_category_link( $category_id );

				   echo '<li><span class="cat"><a href="'.$category_link.'">'.$category->cat_name.'</a></span></li>';
				}
				?>
				</ul>
				

				<div id="fb-root"></div>
				<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=216997805091375";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>
				
				<div>
					<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-width="450" data-show-faces="false"></div>				
				</div>
				

				<div class="post-social-share twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="islawmix">Tweet</a>
				</div>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

				<div class="post-social-share tumblr">
					<a href="http://www.tumblr.com/share/link?url=google.com&name=<?php echo urlencode(the_title()) ?>&description=<?php echo urlencode(the_excerpt()) ?>" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:129px; height:20px; background:url('http://platform.tumblr.com/v1/share_3.png') top left no-repeat transparent;">Share on Tumblr</a>
				</div>
				<script src="http://platform.tumblr.com/v1/share.js"></script>

				<div class="post-social-share email">
					<a href="mailto: ?subject=islawmix | <?php echo urlencode(the_title()) ?>&body=Shared article from islawmix: <?php echo urlencode(the_permalink()) ?>" target="_blank">
						<img src="<?php bloginfo('url'); ?>/wp-content/themes/islawmix/images/content/email.png" alt="Email" id="email"></a>
				</div>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
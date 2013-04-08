<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<a href="http://cyber.law.harvard.edu/" target="_blank">
			<img src="<?php bloginfo('url'); ?>/wp-content/themes/islawmix/images/footer/berkman_logo.png" alt="Berkman" id="berkman"></a>

		<div class='creative-commons'>
			Unless otherwise noted this site and its contents are licensed 
			<br>under a <a href="http://creativecommons.org/licenses/by/3.0/" target="_blank">Creative Commons Attribution 3.0 Unported</a> license.
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
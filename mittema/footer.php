<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MitTema
 */

?>

	<footer class="site-footer" style="
		background-color: <?php echo esc_attr(get_theme_mod('footer_bg_color', '#989084')); ?>;
		color: <?php echo esc_attr(get_theme_mod('footer_text_color', '#ffffff')); ?>;
	">
		<div class="container">
			<p class="footer-text">
				<?php echo esc_html(get_theme_mod('footer_text', __('© 2024 Your Website. All Rights Reserved.', 'mittema'))); ?>
			</p>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>

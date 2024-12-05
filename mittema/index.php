<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MitTema
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="hero-section">
		<?php
			// Define the default video URL
			$default_hero_video = get_template_directory_uri() . './assest/hero.mp4';

			// Get the hero video URL from the customizer setting
			$hero_video = get_theme_mod( 'hero_video', $default_hero_video );

			$hero_title = get_theme_mod( 'hero_title', __( 'Welcome to My Site', 'mittema' ) );
			$hero_subtitle = get_theme_mod( 'hero_subtitle', __( 'Your Hero Subtitle', 'mittema' ) );
		?>
		<video class="hero-video" autoplay muted loop playsinline>
			<source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
			<?php _e( 'Your browser does not support the video tag.', 'mittema' ); ?>
		</video>
	</div>

	<div class="text-section">
		<?php
		// Fetch customizer values for the text section
		$text_title = get_theme_mod( 'text_section_title', __( 'Your Section Title', 'mittema' ) );
		$text_subtitle = get_theme_mod( 'text_section_subtitle', __( 'Your Section Subtitle', 'mittema' ) );
		$text_content = get_theme_mod( 'text_section_content', __( 'Your content goes here. Customize this text in the Customizer.', 'mittema' ) );
		?>
		<div class="text-container">
			<h1 class="text-title"><?php echo esc_html( $text_title ); ?></h1>
			<h2 class="text-subtitle"><?php echo esc_html( $text_subtitle ); ?></h2>
			<p class="text-content"><?php echo wp_kses_post( $text_content ); ?></p>
		</div>
	</div>

    <?php
    if ( have_posts() ) :

        if ( is_home() && ! is_front_page() ) :
            ?>
            <header>
                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
            </header>
            <?php
        endif;

        /* Start the Loop */
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content', get_post_type() );

        endwhile;

        the_posts_navigation();

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif;
    ?>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();

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
            // Get the hero video and image URLs from the customizer
            $hero_video = get_theme_mod( 'hero_video', get_template_directory_uri() . '/assest/hero.mp4' ); // Default to placeholder video
            $hero_image = get_theme_mod( 'hero_image' );
            $hero_title = get_theme_mod( 'hero_title', __( 'Welcome to My Site', 'mittema' ) );
            $hero_subtitle = get_theme_mod( 'hero_subtitle', __( 'Your Hero Subtitle', 'mittema' ) );

            // Check if a video URL exists, otherwise show an image
            if ( ! empty( $hero_video ) && empty( $hero_image ) ) : ?>
                <video class="hero-video" autoplay muted loop playsinline>
                    <source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
                    <?php _e( 'Your browser does not support the video tag.', 'mittema' ); ?>
                </video>
            <?php elseif ( ! empty( $hero_image ) ) : ?>
                <div class="hero-image" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"></div>
            <?php endif; ?>

        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
            <h2 class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></h2>
        </div>
    </div>

        <!-- Chevron -->
        <div class="chevron-wrapper">
            <i class="fas fa-chevron-down chevron"></i>
        </div>

	<div class="text-section">
		<?php
		// Fetch customizer values for the text section
		$text_title = get_theme_mod( 'text_section_title', __( 'Your Title', 'mittema' ) );
		$text_subtitle = get_theme_mod( 'text_section_subtitle', __( 'Your Subtitle', 'mittema' ) );
		$text_content = get_theme_mod( 'text_section_content', __( 'Your content goes here. Customize this text in the Customizer. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ', 'mittema' ) );
		?>
		<div class="text-container">
			<h1 class="text-title"><?php echo esc_html( $text_title ); ?></h1>
			<h2 class="text-subtitle"><?php echo esc_html( $text_subtitle ); ?></h2>
			<p class="text-content"><?php echo wp_kses_post( $text_content ); ?></p>
		</div>
	</div>

	<div class="cards-container">
    <?php for ($i = 1; $i <= 3; $i++) : ?>
        <div class="card">
            <?php 
                $image = get_theme_mod("card_{$i}_image", ''); 
                $placeholder = get_template_directory_uri() . '/assest/ballon.jpg';
            ?>
            <img src="<?php echo esc_url($image ? $image : $placeholder); ?>" alt="<?php echo esc_attr(get_theme_mod("card_{$i}_title", '')); ?>" class="card-image">
            <div class="card-content">
                <h3 class="card-title"><?php echo esc_html(get_theme_mod("card_{$i}_title", __("Card Title {$i}", 'mittema'))); ?></h3>
                <p class="card-text"><?php echo esc_html(get_theme_mod("card_{$i}_text", __("This is the description for card {$i}.", 'mittema'))); ?></p>
                <a href="<?php echo esc_url(get_theme_mod("card_{$i}_button_url", '#')); ?>" class="card-button">
                    <?php echo esc_html(get_theme_mod("card_{$i}_button_text", __('Learn More', 'mittema'))); ?>
                </a>
            </div>
        </div>
    <?php endfor; ?>
</div>

<div class="gallery-section">
    <h2 class="index-title"><?php _e('Gallery', 'mittema'); ?></h2>
    <div class="gallery-grid">
        <?php
        for ($i = 1; $i <= 6; $i++) {
            $gallery_image = get_theme_mod("gallery_image_$i", get_template_directory_uri() . "/assest/cabin.jpg");
            if ($gallery_image) {
                echo '<div class="gallery-item">';
                echo '<img src="' . esc_url($gallery_image) . '" alt="' . esc_attr__("Gallery Image $i", 'mittema') . '">';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<div class="posts-container">
    <h2 class="index-title"><?php _e('Posts', 'mittema'); ?></h2>
    <div class="posts">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <div class="post">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="post-content">
                        <h3 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                            <span class="post-author"><?php _e('By', 'mittema'); ?> <?php the_author(); ?></span>
                        </div>
                        <p class="post-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'mittema'); ?></a>
                    </div>
                </div>
                <?php
            endwhile;
        else :
            ?>
            <p><?php _e( 'No posts found', 'mittema' ); ?></p>
        <?php
        endif;
        ?>
    </div>
</div>



</main>

<?php
get_footer();

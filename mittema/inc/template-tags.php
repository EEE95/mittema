<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package MitTema
 */

 if ( ! function_exists( 'mittema_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function mittema_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        $published_date = get_the_date( DATE_W3C );
        $modified_date = get_the_modified_date( DATE_W3C );

        if ( $published_date !== $modified_date ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( $published_date ),
            esc_html( get_the_date() ),
            esc_attr( $modified_date ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'mittema' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>';
    }
endif;

if ( ! function_exists( 'mittema_post_thumbnail' ) ) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function mittema_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                    the_post_thumbnail(
                        'post-thumbnail',
                        array(
                            'alt' => the_title_attribute(
                                array(
                                    'echo' => false,
                                )
                            ),
                        )
                    );
                ?>
            </a>
        <?php
        endif;
    }
endif;


if ( ! function_exists( 'mittema_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function mittema_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'mittema' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'mittema_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function mittema_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'mittema' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mittema' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mittema' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mittema' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mittema' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'mittema' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'mittema_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function mittema_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

function mittema_enqueue_styles() {
    // Tilføj Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );
}
add_action( 'wp_enqueue_scripts', 'mittema_enqueue_styles' );

if ( ! function_exists( 'mittema_social_sharing' ) ) :
    /**
     * Displays social sharing buttons with icons for Facebook, Instagram, LinkedIn, and Pinterest.
     */
    function mittema_social_sharing() {
        $url   = urlencode( get_permalink() );
        $title = urlencode( get_the_title() );
        $image = urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ); // Bruger post thumbnail som Pinterest-image

        echo '<div class="social-sharing">';

        // Facebook
        echo '<a href="https://www.facebook.com/sharer.php?u=' . $url . '" target="_blank" rel="nofollow" title="' . esc_attr__( 'Share on Facebook', 'mittema' ) . '">';
        echo '<i class="fab fa-facebook-f"></i>'; // Font Awesome Facebook icon
        echo '</a>';

        // Instagram
		echo '<a href="https://www.instagram.com/sharer.php" target="_blank" rel="nofollow" title="' . esc_attr__( 'Share on Instagram', 'mittema' ) . '">';
        echo '<i class="fab fa-instagram"></i>'; // Font Awesome Instagram icon
        echo '</a>';

        // LinkedIn
        echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title . '" target="_blank" rel="nofollow" title="' . esc_attr__( 'Share on LinkedIn', 'mittema' ) . '">';
        echo '<i class="fab fa-linkedin-in"></i>'; // Font Awesome LinkedIn icon
        echo '</a>';

        // Pinterest
        echo '<a href="https://pinterest.com/pin/create/button/?url=' . $url . '&media=' . $image . '&description=' . $title . '" target="_blank" rel="nofollow" title="' . esc_attr__( 'Share on Pinterest', 'mittema' ) . '">';
        echo '<i class="fab fa-pinterest"></i>'; // Font Awesome Pinterest icon
        echo '</a>';

        echo '</div>';
    }
endif;


if ( ! function_exists( 'mittema_back_to_top' ) ) :
    /**
     * Displays a "Back to Top" button.
     */
    function mittema_back_to_top() {
        echo '<a href="#top" class="back-to-top" aria-label="' . esc_attr__( 'Back to Top', 'mittema' ) . '">' .
             '<i class="fas fa-chevron-up"></i>' . // Font Awesome icon
             '</a>';
    }
    add_action( 'wp_footer', 'mittema_back_to_top' );
endif;

function mittema_back_to_top_assets() {
    // Custom CSS for the Back to Top button
    wp_enqueue_style( 'mittema-back-to-top', get_template_directory_uri() . '/css/style.css', array(), '1.0' );

    // Add jQuery script for smooth scrolling
    wp_enqueue_script( 'mittema-back-to-top', get_template_directory_uri() . '/js/customizer.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'mittema_back_to_top_assets' );

<?php
/**
 * MitTema functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MitTema
 */

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function mittema_setup() {
    load_theme_textdomain( 'mittema', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array(
            'menu-1' => esc_html__( 'Primary', 'mittema' ),
        )
    );

    add_theme_support(
        'html5',
        array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    add_theme_support(
        'custom-background',
        apply_filters(
            'mittema_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    add_theme_support( 'customize-selective-refresh-widgets' );

    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action( 'after_setup_theme', 'mittema_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function mittema_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'mittema_content_width', 640 );
}
add_action( 'after_setup_theme', 'mittema_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function mittema_scripts() {
    wp_enqueue_style( 'mittema-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_style_add_data( 'mittema-style', 'rtl', 'replace' );

    wp_enqueue_script( 'mittema-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'menu-script', get_template_directory_uri() . '/js/menu.js', array(), '1.0', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mittema_scripts' );

/**
 * Register the customizer settings and controls.
 */
function mittema_customize_register( $wp_customize ) {
    // Common settings and sections
    mittema_customize_general_settings( $wp_customize );
    mittema_customize_hero_section( $wp_customize );
    mittema_customize_text_section( $wp_customize );
    mittema_customize_footer_section( $wp_customize );
    mittema_customize_cards_section( $wp_customize );
    mittema_customize_gallery_section( $wp_customize );
}
add_action( 'customize_register', 'mittema_customize_register' );

/**
 * Add general theme customization options (colors, typography, etc.)
 */
function mittema_customize_general_settings( $wp_customize ) {
    // Color settings
    $wp_customize->add_section( 'theme_colors', array(
        'title'    => __( 'Theme Colors', 'mittema' ),
        'priority' => 30,
    ));

    $colors = array(
        '--color-primary-color'   => '#080808',
        '--color-bg-light' => '#c6bdaf', 
        '--color-bg-dark' => '#989084',
        'accent_color'    => '#F6B176',
    );

    foreach ( $colors as $setting => $default ) {
        $wp_customize->add_setting( $setting, array( 'default' => $default, 'transport' => 'refresh' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting . '_control', array(
            'label'    => __( ucfirst( str_replace( '_', ' ', $setting ) ), 'mittema' ),
            'section'  => 'theme_colors',
            'settings' => $setting,
        )));
    }

    // Background Color
    $wp_customize->add_section( 'colors', array( 'title' => __( 'Farver', 'mittema' ), 'priority' => 30 ));
    $wp_customize->add_setting( 'background_color', array( 'default' => '#ffffff', 'transport' => 'refresh' ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
        'label'    => __( 'Baggrundsfarve', 'mittema' ),
        'section'  => 'colors',
        'settings' => 'background_color',
    )));

    // Typography settings
    $wp_customize->add_section( 'typography', array( 'title' => __( 'Typografi', 'mittema' ), 'priority' => 35 ));
    $wp_customize->add_setting( 'font_family', array( 'default' => 'Arial, sans-serif', 'transport' => 'refresh' ));
    $wp_customize->add_control( 'font_family', array(
        'label'    => __( 'Vælg skrifttype', 'mittema' ),
        'section'  => 'typography',
        'type'     => 'text',
    ));
}

/**
 * Customize Hero Section
 */
function mittema_customize_hero_section( $wp_customize ) {
    $wp_customize->add_section( 'hero_section', array(
        'title'       => __( 'Hero Section', 'mittema' ),
        'priority'    => 30,
        'description' => __( 'Customize the hero section.', 'mittema' ),
    ));

    // Hero background video, title, subtitle
    mittema_customize_text_input( $wp_customize, 'hero_video', '', 'Hero Background Video', 'hero_section', 'esc_url_raw' );
    mittema_customize_text_input( $wp_customize, 'hero_title', __( 'Welcome to My Site', 'mittema' ), 'Hero Title', 'hero_section', 'sanitize_text_field' );
    mittema_customize_text_input( $wp_customize, 'hero_subtitle', __( 'Your Hero Subtitle', 'mittema' ), 'Hero Subtitle', 'hero_section', 'sanitize_text_field' );
}

/**
 * Customize Text Section
 */
function mittema_customize_text_section( $wp_customize ) {
    $wp_customize->add_section( 'text_section', array(
        'title'       => __( 'Text Section', 'mittema' ),
        'priority'    => 31,
        'description' => __( 'Customize the text section below the hero.', 'mittema' ),
    ));

    // Text section title, subtitle, content
    mittema_customize_text_input( $wp_customize, 'text_section_title', __( 'Your Section Title', 'mittema' ), 'Text Section Title', 'text_section', 'sanitize_text_field' );
    mittema_customize_text_input( $wp_customize, 'text_section_subtitle', __( 'Your Section Subtitle', 'mittema' ), 'Text Section Subtitle', 'text_section', 'sanitize_text_field' );
    mittema_customize_textarea( $wp_customize, 'text_section_content', __( 'Your content goes here.', 'mittema' ), 'Text Section Content', 'text_section', 'wp_kses_post' );
}

/**
 * Customize Footer Section
 */
function mittema_customize_footer_section( $wp_customize ) {
    $wp_customize->add_section( 'footer_section', array(
        'title'       => __( 'Footer Settings', 'mittema' ),
        'priority'    => 120,
        'description' => __( 'Customize the footer content.', 'mittema' ),
    ));

    mittema_customize_text_input( $wp_customize, 'footer_text', __( '© 2024 Your Website. All Rights Reserved.', 'mittema' ), 'Footer Text', 'footer_section', 'sanitize_text_field' );
    mittema_customize_color_input( $wp_customize, 'footer_bg_color', '#989084', 'Footer Background Color', 'footer_section' );
    mittema_customize_color_input( $wp_customize, 'footer_text_color', '#ffffff', 'Footer Text Color', 'footer_section' );
}

/**
 * Customize Cards Section
 */
function mittema_customize_cards_section( $wp_customize ) {
    $wp_customize->add_section( 'home_cards_section', array(
        'title'       => __( 'Homepage Cards', 'mittema' ),
        'priority'    => 110,
        'description' => __( 'Customize the cards on the homepage.', 'mittema' ),
    ));

    // Loop for card settings
    for ( $i = 1; $i <= 3; $i++ ) {
        mittema_customize_text_input( $wp_customize, "card_{$i}_title", __("Card Title {$i}", 'mittema'), "Card {$i} Title", 'home_cards_section', 'sanitize_text_field' );
        mittema_customize_textarea( $wp_customize, "card_{$i}_text", __("This is the description for card {$i}.", 'mittema'), "Card {$i} Text", 'home_cards_section', 'sanitize_textarea_field' );
        mittema_customize_image_input( $wp_customize, "card_{$i}_image", '', "Card {$i} Image", 'home_cards_section' );
        mittema_customize_text_input( $wp_customize, "card_{$i}_button_url", '#', "Card {$i} Button URL", 'home_cards_section', 'esc_url_raw' );
    }
}

/**
 * Customize Gallery Section
 */
function mittema_customize_gallery_section( $wp_customize ) {
    $wp_customize->add_section( 'gallery_section', array(
        'title'       => __( 'Gallery Section', 'mittema' ),
        'priority'    => 120,
        'description' => __( 'Customize your gallery section.', 'mittema' ),
    ));

    // Gallery Settings
    mittema_customize_gallery_input( $wp_customize, 'gallery_images', array(), 'Gallery Images', 'gallery_section' );
}

/**
 * Helper function to add a text input
 */
function mittema_customize_text_input( $wp_customize, $setting, $default, $label, $section, $sanitize_callback ) {
    $wp_customize->add_setting( $setting, array(
        'default'           => $default,
        'sanitize_callback' => $sanitize_callback,
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control( $setting, array(
        'label'   => __( $label, 'mittema' ),
        'section' => $section,
        'type'    => 'text',
    ));
}

/**
 * Helper function to add a textarea input
 */
function mittema_customize_textarea( $wp_customize, $setting, $default, $label, $section, $sanitize_callback ) {
    $wp_customize->add_setting( $setting, array(
        'default'           => $default,
        'sanitize_callback' => $sanitize_callback,
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control( $setting, array(
        'label'   => __( $label, 'mittema' ),
        'section' => $section,
        'type'    => 'textarea',
    ));
}

/**
 * Helper function to add color input
 */
function mittema_customize_color_input( $wp_customize, $setting, $default, $label, $section ) {
    $wp_customize->add_setting( $setting, array(
        'default' => $default,
        'transport' => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
        'label'    => __( $label, 'mittema' ),
        'section'  => $section,
        'settings' => $setting,
    )));
}

/**
 * Helper function to add an image input
 */
function mittema_customize_image_input( $wp_customize, $setting, $default, $label, $section ) {
    $wp_customize->add_setting( $setting, array(
        'default' => $default,
        'transport' => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, array(
        'label'    => __( $label, 'mittema' ),
        'section'  => $section,
        'settings' => $setting,
    )));
}

/**
 * Helper function to add a gallery input
 */
function mittema_customize_gallery_input( $wp_customize, $setting, $default, $label, $section ) {
    $wp_customize->add_setting( $setting, array(
        'default' => $default,
        'transport' => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting, array(
        'label'    => __( $label, 'mittema' ),
        'section'  => $section,
        'settings' => $setting,
     )));
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function mittema_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        esc_html_x( 'Posted on %s', 'post date', 'mittema' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}

/**
 * Prints HTML with meta information for the current author.
 */
function mittema_posted_by() {
    $byline = sprintf(
        esc_html_x( 'by %s', 'post author', 'mittema' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}

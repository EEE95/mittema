<?php
/**
 * MitTema Theme Customizer
 *
 * @package MitTema
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * Add custom settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mittema_customize_register( $wp_customize ) {
    // PostMessage support
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'mittema_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'mittema_customize_partial_blogdescription',
            )
        );
    }

    // Hero Section
    $wp_customize->add_section( 'hero_section', array(
        'title'       => __( 'Hero Section', 'mittema' ),
        'priority'    => 30,
        'description' => __( 'Customize the hero section.', 'mittema' ),
    ) );

    $wp_customize->add_setting( 'hero_video', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'hero_video', array(
        'label'   => __( 'Hero Background Video', 'mittema' ),
        'section' => 'hero_section',
    ) ) );

    $wp_customize->add_setting( 'hero_title', array(
        'default'           => __( 'Welcome to My Site', 'mittema' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_title', array(
        'label'   => __( 'Hero Title', 'mittema' ),
        'section' => 'hero_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'hero_subtitle', array(
        'default'           => __( 'Your Hero Subtitle', 'mittema' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'mittema' ),
        'section' => 'hero_section',
        'type'    => 'text',
    ) );

    // Text Section
    $wp_customize->add_section( 'text_section', array(
        'title'       => __( 'Text Section', 'mittema' ),
        'priority'    => 31,
        'description' => __( 'Customize the text section below the hero.', 'mittema' ),
    ) );

    $wp_customize->add_setting( 'text_section_title', array(
        'default'           => __( 'Your Section Title', 'mittema' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'text_section_title', array(
        'label'   => __( 'Text Section Title', 'mittema' ),
        'section' => 'text_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'text_section_subtitle', array(
        'default'           => __( 'Your Section Subtitle', 'mittema' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'text_section_subtitle', array(
        'label'   => __( 'Text Section Subtitle', 'mittema' ),
        'section' => 'text_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'text_section_content', array(
        'default'           => __( 'Your content goes here. Customize this text in the Customizer.', 'mittema' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'text_section_content', array(
        'label'   => __( 'Text Section Content', 'mittema' ),
        'section' => 'text_section',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'mittema_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mittema_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mittema_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mittema_customize_preview_js() {
    wp_enqueue_script( 'mittema-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'mittema_customize_preview_js' );
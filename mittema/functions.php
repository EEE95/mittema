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
            'search-form',
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
 * Customizer additions.
 */
function mittema_customize_register($wp_customize) {
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

    // Farveindstillinger
    $wp_customize->add_setting('primary_color', array(
        'default'   => '#404668',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('secondary_color', array(
        'default'   => '#6282ff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('accent_color', array(
        'default'   => '#F6B176',
        'transport' => 'refresh',
    ));

    // Sektion til farver
    $wp_customize->add_section('theme_colors', array(
        'title'    => __('Theme Colors', 'mittema'),
        'priority' => 30,
    ));

    // Kontroller for farver
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
        'label'    => __('Primary Color', 'mittema'),
        'section'  => 'theme_colors',
        'settings' => 'primary_color',
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color_control', array(
        'label'    => __('Secondary Color', 'mittema'),
        'section'  => 'theme_colors',
        'settings' => 'secondary_color',
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color_control', array(
        'label'    => __('Accent Color', 'mittema'),
        'section'  => 'theme_colors',
        'settings' => 'accent_color',
    )));

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

    // Footer Section
    $wp_customize->add_section('footer_section', array(
        'title'       => __('Footer Settings', 'mittema'),
        'priority'    => 120,
        'description' => __('Customize the footer content.', 'mittema'),
    ));

    // Footer Text Setting
    $wp_customize->add_setting('footer_text', array(
        'default'           => __('© 2024 Your Website. All Rights Reserved.', 'mittema'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    // Footer Text Control
    $wp_customize->add_control('footer_text_control', array(
        'label'    => __('Footer Text', 'mittema'),
        'section'  => 'footer_section',
        'settings' => 'footer_text',
        'type'     => 'text',
    ));

    // Footer Background Color Setting
    $wp_customize->add_setting('footer_bg_color', array(
        'default'           => '#989084',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    // Footer Background Color Control
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_bg_color_control',
            array(
                'label'    => __('Footer Background Color', 'mittema'),
                'section'  => 'footer_section',
                'settings' => 'footer_bg_color',
            )
        )
    );

    // Footer Text Color Setting
    $wp_customize->add_setting('footer_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    // Footer Text Color Control
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_text_color_control',
            array(
                'label'    => __('Footer Text Color', 'mittema'),
                'section'  => 'footer_section',
                'settings' => 'footer_text_color',
            )
        )
    );
}
add_action('customize_register', 'mittema_customize_register');

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

/**
 * Custom CSS for the theme customizer.
 */
function mittema_customize_css() {
    ?>
    <style type="text/css">
        .site-title a {
            color: #<?php echo get_theme_mod( 'header_textcolor' ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'mittema_customize_css' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}
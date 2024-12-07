<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package MitTema
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mittema_body_classes( $classes ) {
    // Tilføj klasse, hvis brugeren er administrator
    if ( current_user_can( 'administrator' ) ) {
        $classes[] = 'user-admin';
    }

    // Tilføj klasse for ikke-singulære sider
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Tilføj klasse for homepage
    if ( is_front_page() ) {
        $classes[] = 'home-page';
    }

    return $classes;
}
add_filter( 'body_class', 'mittema_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mittema_pingback_header() {
    if ( is_singular() && pings_open() ) {
        $pingback_url = get_bloginfo( 'pingback_url' );
        // Tilføj sikkerhed for kun at tillade pingbacks fra tilladte domæner
        if ( strpos( $pingback_url, 'mittema.dk' ) !== false ) {
            printf( '<link rel="pingback" href="%s">', esc_url( $pingback_url ) );
        }
    }
}
add_action( 'wp_head', 'mittema_pingback_header' );

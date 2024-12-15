<?php
/**
 * The header for our theme
 *
 * @package MitTema
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
<div id="top"></div>

    <!-- Sidebar Navigation -->
    <div id="sidebar-nav" class="sidebar">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<div class="line-one"></div>
        	<div class="line-two"></div>
        </button>
        <div class="logo">
            <?php the_custom_logo(); ?>
        </div>
        <!-- The sliding menu -->
        <nav id="sliding-menu" class="sliding-menu">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                )
            );
            ?>
        </nav>
    </div>
</div>

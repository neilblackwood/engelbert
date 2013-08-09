<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery-ui-1.10.3.custom.min.css" />
<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.carouFredSel-6.2.1-packed.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.07016.js"></script>
<script>
$(function() {
$( "#tabs, #storeTabs" ).tabs();
});
</script>
<style type="text/css">
/*
This CSS resource incorporates links to font software which is the valuable copyrighted
property of Monotype and/or its suppliers. You may not attempt to copy, install,
redistribute, convert, modify or reverse engineer this font software. Please contact Monotype
with any questions regarding Web Fonts:  http://www.linotype.com
*/
@import url("http://fast.fonts.net/lt/1.css?apiType=css&c=b822275d-7d7b-48fc-9ddc-0f7462194927&fontids=706787");
@font-face{
font-family:"Perpetua";
src:url("<?php echo get_template_directory_uri(); ?>/Fonts/706787/640e04bf-5082-42d9-b3c5-ee73d7b4acc2.eot?#iefix");
src:url("<?php echo get_template_directory_uri(); ?>/Fonts/706787/640e04bf-5082-42d9-b3c5-ee73d7b4acc2.eot?#iefix") format("eot"),url("<?php echo get_template_directory_uri(); ?>/Fonts/706787/80398ad4-b81d-4d11-962e-a5789b20b6a3.woff") format("woff"),url("<?php echo get_template_directory_uri(); ?>/Fonts/706787/50adb340-70d0-4c89-9c96-c19f88402b2b.ttf") format("truetype"),url("<?php echo get_template_directory_uri(); ?>/Fonts/706787/8a9ab553-0bd1-4d83-baa7-959b52510415.svg#8a9ab553-0bd1-4d83-baa7-959b52510415") format("svg");
}

			.list_carousel {
				width: 960px;
			}
			.list_carousel ul {
				margin: 0;
				padding: 0;
				list-style: none;
				display: block;
			}
			.list_carousel li {
				display: block;
				float: left;
				margin: 0;
			}
			.list_carousel.responsive {
				width: auto;
				margin-left: 0;
			}
			.clearfix {
				float: none;
				clear: both;
			}
            .pager {
                text-align: center;
                position: absolute;
                margin: -2% 31.75%;
                z-index: 3;
            }
            .pager a {
                background: url('<?php echo get_template_directory_uri(); ?>/css/images/carousel_sprite.png') 0 -1px no-repeat transparent;
                width: 15px;
                height: 15px;
                margin: 0 3px 0 3px;
                display: inline-block;
            }
            .pager a.selected {
                background-position: -25px -1px;
                cursor: default;
            }
            .pager a span {
                display: none;
            }
</style>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="/wp-content/uploads/2013/08/engelbertLogo.png" alt="<?php bloginfo( 'name' ); ?> <?php bloginfo( 'description' ); ?>" title="<?php bloginfo( 'name' ); ?> <?php bloginfo( 'description' ); ?>" /></a></h1>
        <?php // Put the sidebar in here ?>
        <?php get_sidebar(); ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<!--<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			 <a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>-->
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">
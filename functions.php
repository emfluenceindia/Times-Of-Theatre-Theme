<?php
/**
 * Times of Theatre theme functions and definitions.
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TIMESOFTHEATRE_VERSION', '1.0.0' );

if ( ! function_exists( 'timesoftheatre_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for WordPress features.
	 */
	function timesoftheatre_setup() {
		load_theme_textdomain( 'timesoftheatre', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'customize-selective-refresh-widgets' );
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
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 275,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'timesoftheatre' ),
				'social'  => esc_html__( 'Social Links', 'timesoftheatre' ),
				'footer'  => esc_html__( 'Footer Menu', 'timesoftheatre' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'timesoftheatre_setup' );

require get_template_directory() . '/inc/class-tot-nav-walker.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/home-images.php';

/**
 * Sets the content width in pixels.
 */
function timesoftheatre_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'timesoftheatre_content_width', 1200 );
}
add_action( 'after_setup_theme', 'timesoftheatre_content_width', 0 );

/**
 * Returns a cache-busting version for one of the theme's own assets: the
 * file's modification time, so browsers reload it whenever it changes.
 *
 * @param string $path Path relative to the theme root, with a leading slash.
 * @return string
 */
function timesoftheatre_asset_version( $path ) {
	$file = get_template_directory() . $path;

	return file_exists( $file ) ? (string) filemtime( $file ) : TIMESOFTHEATRE_VERSION;
}

/**
 * Enqueues theme styles and scripts.
 */
function timesoftheatre_scripts() {
	$assets = get_template_directory_uri() . '/assets';

	wp_enqueue_style( 'timesoftheatre-bootstrap-grid', $assets . '/vendor/bootstrap/bootstrap-grid.min.css', array(), '5.3.8' );
	wp_enqueue_style( 'timesoftheatre-fontawesome', $assets . '/vendor/fontawesome/css/all.min.css', array(), '7.3.1' );

	// style.css only carries the theme header; all styles live in totmain.css.
	wp_enqueue_style(
		'timesoftheatre-totmain',
		$assets . '/css/totmain.css',
		array( 'timesoftheatre-bootstrap-grid', 'timesoftheatre-fontawesome' ),
		timesoftheatre_asset_version( '/assets/css/totmain.css' )
	);

	wp_enqueue_script(
		'timesoftheatre-main',
		$assets . '/js/main.js',
		array(),
		timesoftheatre_asset_version( '/assets/js/main.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'timesoftheatre_scripts' );

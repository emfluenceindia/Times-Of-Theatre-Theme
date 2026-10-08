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
				'footer'  => esc_html__( 'Footer Menu', 'timesoftheatre' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'timesoftheatre_setup' );

/**
 * Sets the content width in pixels.
 */
function timesoftheatre_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'timesoftheatre_content_width', 1200 );
}
add_action( 'after_setup_theme', 'timesoftheatre_content_width', 0 );

/**
 * Enqueues theme styles and scripts.
 */
function timesoftheatre_scripts() {
	wp_enqueue_style(
		'timesoftheatre-style',
		get_stylesheet_uri(),
		array(),
		TIMESOFTHEATRE_VERSION
	);

	wp_enqueue_script(
		'timesoftheatre-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		TIMESOFTHEATRE_VERSION,
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

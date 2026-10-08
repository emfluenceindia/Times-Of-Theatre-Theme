<?php
/**
 * Homepage images: slot registry, Customizer controls and output helper.
 *
 * Every image on the homepage is a "slot". Each slot has a bundled default
 * (a licensed photo in assets/images/) that can be replaced from the
 * dashboard: Appearance > Customize > Homepage Images.
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the image sizes used by the homepage slots.
 */
function timesoftheatre_image_sizes() {
	add_image_size( 'tot-hero', 1600, 700, true );
	add_image_size( 'tot-wide', 1600, 520, true );
	add_image_size( 'tot-quick', 800, 450, true );
	add_image_size( 'tot-card', 640, 360, true );
}
add_action( 'after_setup_theme', 'timesoftheatre_image_sizes' );

/**
 * Returns the homepage image slots.
 *
 * @return array[] key => array( label, group, default file, image size ).
 */
function timesoftheatre_home_slots() {
	return array(
		'hero-1'            => array( __( 'Slide 1: Times of Theatre', 'timesoftheatre' ), 'hero', 'hero/hero-stage.jpg', 'tot-hero' ),
		'hero-2'            => array( __( 'Slide 2: TOT Radio & Audio Theatre', 'timesoftheatre' ), 'hero', 'hero/hero-audio.jpg', 'tot-hero' ),
		'hero-3'            => array( __( 'Slide 3: TOT School of Drama', 'timesoftheatre' ), 'hero', 'hero/hero-school.jpg', 'tot-hero' ),

		'quick-school'      => array( __( 'TOT School of Drama', 'timesoftheatre' ), 'quick', 'home/quick-school.jpg', 'tot-quick' ),
		'quick-space'       => array( __( 'The TOT Space', 'timesoftheatre' ), 'quick', 'home/quick-space.jpg', 'tot-quick' ),
		'quick-studio'      => array( __( 'The TOT Studio', 'timesoftheatre' ), 'quick', 'home/quick-studio.jpg', 'tot-quick' ),

		'what-radio'        => array( __( 'TOT Radio & Audio Theatre', 'timesoftheatre' ), 'what', 'home/what-radio.jpg', 'tot-card' ),
		'what-school'       => array( __( 'TOT School of Drama', 'timesoftheatre' ), 'what', 'home/what-school.jpg', 'tot-card' ),
		'what-club'         => array( __( 'TOT Radio Drama Club', 'timesoftheatre' ), 'what', 'home/what-club.jpg', 'tot-card' ),
		'what-events'       => array( __( 'Events & Competitions', 'timesoftheatre' ), 'what', 'home/what-events.jpg', 'tot-card' ),

		'band'              => array( __( 'Wide image band', 'timesoftheatre' ), 'band', 'home/band.jpg', 'tot-wide' ),

		'explore-about'     => array( __( 'About TOT', 'timesoftheatre' ), 'explore', 'home/explore-about.jpg', 'tot-card' ),
		'explore-school'    => array( __( 'TOT School of Drama', 'timesoftheatre' ), 'explore', 'home/explore-school.jpg', 'tot-card' ),
		'explore-space'     => array( __( 'The TOT Space', 'timesoftheatre' ), 'explore', 'home/explore-space.jpg', 'tot-card' ),
		'explore-studio'    => array( __( 'The TOT Studio', 'timesoftheatre' ), 'explore', 'home/explore-studio.jpg', 'tot-card' ),
		'explore-workshops' => array( __( 'Workshops', 'timesoftheatre' ), 'explore', 'home/explore-workshops.jpg', 'tot-card' ),
		'explore-youtube'   => array( __( 'TOT on YouTube', 'timesoftheatre' ), 'explore', 'home/explore-youtube.jpg', 'tot-card' ),
		'explore-gallery'   => array( __( 'Gallery', 'timesoftheatre' ), 'explore', 'home/explore-gallery.jpg', 'tot-card' ),
		'explore-contact'   => array( __( 'Contact', 'timesoftheatre' ), 'explore', 'home/explore-contact.jpg', 'tot-card' ),
	);
}

/**
 * Returns the <img> HTML for a homepage slot: the image chosen in the
 * Customizer, or the bundled default. Images are decorative (empty alt).
 *
 * @param string $key  Slot key.
 * @param string $args Optional. Extra attributes: class, loading, fetchpriority.
 * @return string
 */
function timesoftheatre_home_image( $key, $args = array() ) {
	$slots = timesoftheatre_home_slots();

	if ( ! isset( $slots[ $key ] ) ) {
		return '';
	}

	$args = wp_parse_args(
		$args,
		array(
			'class'         => '',
			'loading'       => 'lazy',
			'decoding'      => 'async',
			'fetchpriority' => '',
		)
	);

	$attachment_id = absint( get_theme_mod( 'tot_img_' . $key, 0 ) );

	if ( $attachment_id && wp_attachment_is_image( $attachment_id ) ) {
		$attr = array(
			'class'   => $args['class'],
			'alt'     => '',
			'loading' => $args['loading'],
		);

		if ( $args['decoding'] ) {
			$attr['decoding'] = $args['decoding'];
		}

		if ( $args['fetchpriority'] ) {
			$attr['fetchpriority'] = $args['fetchpriority'];
		}

		$html = wp_get_attachment_image( $attachment_id, $slots[ $key ][3], false, $attr );

		if ( $html ) {
			return $html;
		}
	}

	$file = get_template_directory() . '/assets/images/' . $slots[ $key ][2];
	$size = file_exists( $file ) ? wp_getimagesize( $file ) : false;

	if ( ! $size ) {
		return '';
	}

	return sprintf(
		'<img src="%1$s" width="%2$d" height="%3$d" class="%4$s" alt="" loading="%5$s"%6$s%7$s>',
		esc_url( get_template_directory_uri() . '/assets/images/' . $slots[ $key ][2] ),
		(int) $size[0],
		(int) $size[1],
		esc_attr( $args['class'] ),
		esc_attr( $args['loading'] ),
		$args['decoding'] ? ' decoding="' . esc_attr( $args['decoding'] ) . '"' : '',
		$args['fetchpriority'] ? ' fetchpriority="' . esc_attr( $args['fetchpriority'] ) . '"' : ''
	);
}

/**
 * Default text of the wide image band.
 *
 * @return string
 */
function timesoftheatre_band_text_default() {
	return __( 'A creative hub for theatre enthusiasts, performers, voice artists and radio play listeners.', 'timesoftheatre' );
}

/**
 * Registers the Customizer section, image pickers and band text.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function timesoftheatre_customize_register( $wp_customize ) {
	$groups = array(
		'hero'    => __( 'Hero slides', 'timesoftheatre' ),
		'quick'   => __( 'Quick links', 'timesoftheatre' ),
		'what'    => __( 'What We Do', 'timesoftheatre' ),
		'band'    => __( 'Wide image band', 'timesoftheatre' ),
		'explore' => __( 'Explore', 'timesoftheatre' ),
	);

	$wp_customize->add_panel(
		'tot_home',
		array(
			'title'       => __( 'Homepage Images', 'timesoftheatre' ),
			'description' => __( 'Replace any homepage image. Leave a slot empty to use the bundled photo. Recommended: landscape images at least 1600 pixels wide; they are cropped to fit.', 'timesoftheatre' ),
			'priority'    => 30,
		)
	);

	foreach ( $groups as $group => $title ) {
		$wp_customize->add_section(
			'tot_home_' . $group,
			array(
				'title' => $title,
				'panel' => 'tot_home',
			)
		);
	}

	foreach ( timesoftheatre_home_slots() as $key => $slot ) {
		$wp_customize->add_setting(
			'tot_img_' . $key,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'tot_img_' . $key,
				array(
					'label'     => $slot[0],
					'section'   => 'tot_home_' . $slot[1],
					'mime_type' => 'image',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'tot_band_text',
		array(
			'default'           => timesoftheatre_band_text_default(),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'tot_band_text',
		array(
			'label'   => __( 'Text over the wide image', 'timesoftheatre' ),
			'section' => 'tot_home_band',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'timesoftheatre_customize_register' );

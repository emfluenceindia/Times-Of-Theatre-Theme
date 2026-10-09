<?php
/**
 * Fluent Forms integration.
 *
 * Field icons are set per field in the form builder's "Container Class"
 * setting by prefixing Font Awesome classes with "tot-", for example
 * "tot-fa-solid tot-fa-user" or "tot-fa-brands tot-fa-whatsapp". The field's
 * control is then wrapped together with an icon block (see .tot-ff-control in
 * totmain.css).
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the Font Awesome classes requested by a field's container class.
 *
 * @param array $data Fluent Forms field data.
 * @return string Space-separated Font Awesome classes, or '' if none.
 */
function timesoftheatre_ff_field_icon( $data ) {
	$container_class = isset( $data['settings']['container_class'] ) ? (string) $data['settings']['container_class'] : '';
	$icon            = array();

	foreach ( preg_split( '/\s+/', $container_class, -1, PREG_SPLIT_NO_EMPTY ) as $class_name ) {
		if ( 0 === strpos( $class_name, 'tot-fa-' ) ) {
			$icon[] = sanitize_html_class( substr( $class_name, 4 ) );
		}
	}

	return implode( ' ', $icon );
}

/**
 * Wraps a field's input or textarea with its icon block.
 *
 * @param string $html Field markup.
 * @param array  $data Fluent Forms field data.
 * @return string
 */
function timesoftheatre_ff_add_field_icon( $html, $data ) {
	$icon = timesoftheatre_ff_field_icon( $data );

	if ( '' === $icon ) {
		return $html;
	}

	$open = '<div class="tot-ff-control"><span class="tot-ff-control__icon" aria-hidden="true"><i class="' . esc_attr( $icon ) . '"></i></span>';

	return preg_replace(
		'#(<textarea\b.*?</textarea>|<input\b[^>]*\bff-el-form-control\b[^>]*>)#s',
		$open . '$1</div>',
		$html,
		1
	);
}

foreach ( array( 'input_text', 'input_email', 'input_date', 'textarea' ) as $timesoftheatre_ff_element ) {
	add_filter( 'fluentform/rendering_field_html_' . $timesoftheatre_ff_element, 'timesoftheatre_ff_add_field_icon', 10, 2 );
}
unset( $timesoftheatre_ff_element );

/**
 * Validates phone numbers entered in text fields of type "tel".
 *
 * @param string|array $error     Existing error.
 * @param array        $field     Field being validated.
 * @param array        $form_data Submitted values.
 * @return string|array
 */
function timesoftheatre_ff_validate_phone( $error, $field, $form_data ) {
	if ( 'tel' !== ( $field['raw']['attributes']['type'] ?? '' ) ) {
		return $error;
	}

	$value = trim( (string) ( $form_data[ $field['name'] ] ?? '' ) );

	if ( '' !== $value && ! preg_match( '/^\+?[0-9][0-9\s\-().]{6,19}$/', $value ) ) {
		return array( __( 'Please enter a valid phone number.', 'timesoftheatre' ) );
	}

	return $error;
}
add_filter( 'fluentform/validate_input_item_input_text', 'timesoftheatre_ff_validate_phone', 10, 3 );

/**
 * Returns the reCAPTCHA keys configured in the Advanced Google reCAPTCHA
 * plugin, in the shape Fluent Forms stores its own reCAPTCHA settings.
 *
 * @return array|false Fluent Forms reCAPTCHA details, or false when that
 *                     plugin is inactive or not set to a reCAPTCHA with keys.
 */
function timesoftheatre_ff_agr_recaptcha_details() {
	if ( ! class_exists( 'WPCaptcha_Setup' ) ) {
		return false;
	}

	$options  = WPCaptcha_Setup::get_options();
	$versions = array(
		'recaptchav2' => 'v2_visible',
		'recaptchav3' => 'v3_invisible',
	);

	if ( ! isset( $versions[ $options['captcha'] ] ) || empty( $options['captcha_site_key'] ) || empty( $options['captcha_secret_key'] ) ) {
		return false;
	}

	return array(
		'siteKey'     => $options['captcha_site_key'],
		'secretKey'   => $options['captcha_secret_key'],
		'api_version' => $versions[ $options['captcha'] ],
	);
}

/**
 * Makes Fluent Forms' reCAPTCHA field use the keys and version set in
 * Advanced Google reCAPTCHA (Settings > Advanced Google reCAPTCHA), so the
 * site's reCAPTCHA is configured in one place. Fluent Forms then renders the
 * widget and verifies the token on submission with those keys.
 *
 * @param mixed $pre Short-circuit value.
 * @return mixed
 */
function timesoftheatre_ff_use_agr_recaptcha_keys( $pre ) {
	$details = timesoftheatre_ff_agr_recaptcha_details();

	return $details ? $details : $pre;
}
add_filter( 'pre_option__fluentform_reCaptcha_details', 'timesoftheatre_ff_use_agr_recaptcha_keys' );

/**
 * Skips reCAPTCHA verification while no keys are configured anywhere, so
 * forms keep working instead of rejecting every submission (the field is not
 * rendered without a site key, so it could never pass).
 *
 * @param bool   $disable Whether to skip the check.
 * @param object $form    Form being submitted.
 * @param string $type    Captcha type.
 * @return bool
 */
function timesoftheatre_ff_skip_unconfigured_recaptcha( $disable, $form, $type ) {
	if ( 'recaptcha' !== $type || $disable ) {
		return $disable;
	}

	$details = get_option( '_fluentform_reCaptcha_details' );

	return empty( $details['siteKey'] ) || empty( $details['secretKey'] );
}
add_filter( 'fluentform/disable_captcha', 'timesoftheatre_ff_skip_unconfigured_recaptcha', 10, 3 );

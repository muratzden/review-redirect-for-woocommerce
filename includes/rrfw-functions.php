<?php
/**
 * Shared helper functions.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default settings.
 *
 * @return array
 */
function rrfw_get_default_settings() {
	return array(
		'enabled'              => 0,
		'google_review_url'    => '',
		'popup_title'          => __( 'How did we do?', 'review-redirect-for-woocommerce' ),
		'popup_message'        => __( 'Your opinion helps us improve and helps other customers choose with confidence.', 'review-redirect-for-woocommerce' ),
		'positive_threshold'   => 4,
		'notification_email'   => get_option( 'admin_email' ),
		'completed_email'      => 0,
	);
}

/**
 * Returns merged plugin settings.
 *
 * @return array
 */
function rrfw_get_settings() {
	$settings = get_option( 'rrfw_settings', array() );

	if ( ! is_array( $settings ) ) {
		$settings = array();
	}

	return wp_parse_args( $settings, rrfw_get_default_settings() );
}

/**
 * Returns a single plugin setting.
 *
 * @param string $key     Setting key.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function rrfw_get_setting( $key, $default = null ) {
	$settings = rrfw_get_settings();

	return array_key_exists( $key, $settings ) ? $settings[ $key ] : $default;
}

/**
 * Sanitizes plugin settings.
 *
 * @param array $input Raw settings.
 * @return array
 */
function rrfw_sanitize_settings( $input ) {
	$input    = is_array( $input ) ? $input : array();
	$defaults = rrfw_get_default_settings();
	$output   = array();

	$output['enabled']            = empty( $input['enabled'] ) ? 0 : 1;
	$output['google_review_url']  = isset( $input['google_review_url'] ) ? rrfw_sanitize_google_review_url( $input['google_review_url'] ) : '';
	$output['popup_title']        = isset( $input['popup_title'] ) ? sanitize_text_field( wp_unslash( $input['popup_title'] ) ) : $defaults['popup_title'];
	$output['popup_message']      = isset( $input['popup_message'] ) ? sanitize_textarea_field( wp_unslash( $input['popup_message'] ) ) : $defaults['popup_message'];
	$output['positive_threshold'] = isset( $input['positive_threshold'] ) ? absint( wp_unslash( $input['positive_threshold'] ) ) : $defaults['positive_threshold'];
	$output['notification_email'] = isset( $input['notification_email'] ) ? sanitize_email( wp_unslash( $input['notification_email'] ) ) : $defaults['notification_email'];
	$output['completed_email']    = empty( $input['completed_email'] ) ? 0 : 1;

	if ( $output['positive_threshold'] < 1 || $output['positive_threshold'] > 5 ) {
		$output['positive_threshold'] = $defaults['positive_threshold'];
	}

	if ( empty( $output['notification_email'] ) || ! is_email( $output['notification_email'] ) ) {
		$output['notification_email'] = $defaults['notification_email'];
	}

	return $output;
}

/**
 * Sanitizes and validates the Google review URL.
 *
 * @param string $url Raw URL.
 * @return string
 */
function rrfw_sanitize_google_review_url( $url ) {
	$url          = sanitize_text_field( wp_unslash( $url ) );
	$sanitized    = esc_url_raw( $url );
	$allowed_hosts = array(
		'google.com',
		'www.google.com',
		'g.page',
		'maps.app.goo.gl',
		'search.google.com',
	);

	if ( empty( $sanitized ) ) {
		return '';
	}

	$host = wp_parse_url( $sanitized, PHP_URL_HOST );
	$host = is_string( $host ) ? strtolower( $host ) : '';

	if ( ! in_array( $host, $allowed_hosts, true ) ) {
		add_settings_error(
			'rrfw_settings',
			'rrfw_invalid_google_review_url',
			__( 'Google review URL must use an allowed Google reviews host.', 'review-redirect-for-woocommerce' ),
			'error'
		);

		return '';
	}

	return $sanitized;
}

/**
 * Checks whether WooCommerce is active.
 *
 * @return bool
 */
function rrfw_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

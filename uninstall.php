<?php
/**
 * Uninstall cleanup.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'rrfw_settings' );

if ( function_exists( 'wc_get_orders' ) ) {
	do {
		$rrfw_orders = wc_get_orders(
			array(
				'limit'    => 100,
				'return'   => 'objects',
				'meta_key' => '_rrfw_feedback',
			)
		);

		foreach ( $rrfw_orders as $rrfw_order ) {
			if ( is_a( $rrfw_order, 'WC_Order' ) ) {
				$rrfw_order->delete_meta_data( '_rrfw_feedback' );
				$rrfw_order->save();
			}
		}
	} while ( ! empty( $rrfw_orders ) );

	return;
}

do {
	$rrfw_orders = get_posts(
		array(
			'post_type'      => 'shop_order',
			'post_status'    => 'any',
			'posts_per_page' => 100,
			'fields'         => 'ids',
			'meta_key'       => '_rrfw_feedback',
		)
	);

	foreach ( $rrfw_orders as $rrfw_order_id ) {
		delete_post_meta( absint( $rrfw_order_id ), '_rrfw_feedback' );
	}
} while ( ! empty( $rrfw_orders ) );

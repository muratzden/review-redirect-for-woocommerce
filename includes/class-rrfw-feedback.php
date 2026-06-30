<?php
/**
 * Low-rating feedback handling.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feedback class.
 */
class RRFW_Feedback {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_rrfw_submit_feedback', array( $this, 'submit_feedback' ) );
		add_action( 'wp_ajax_nopriv_rrfw_submit_feedback', array( $this, 'submit_feedback' ) );
	}

	/**
	 * Handles AJAX feedback submissions.
	 *
	 * @return void
	 */
	public function submit_feedback() {
		check_ajax_referer( 'rrfw_submit_feedback', 'nonce' );

		$settings = rrfw_get_settings();

		if ( empty( $settings['enabled'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Feedback is currently disabled.', 'review-redirect-for-woocommerce' ) ), 403 );
		}

		$order_id  = isset( $_POST['order_id'] ) ? absint( wp_unslash( $_POST['order_id'] ) ) : 0;
		$order_key = isset( $_POST['order_key'] ) ? sanitize_text_field( wp_unslash( $_POST['order_key'] ) ) : '';
		$rating    = isset( $_POST['rating'] ) ? absint( wp_unslash( $_POST['rating'] ) ) : 0;
		$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

		if ( $order_id <= 0 || empty( $order_key ) || $rating < 1 || $rating > 5 || empty( $message ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Missing required feedback fields.', 'review-redirect-for-woocommerce' ) ), 400 );
		}

		if ( $rating >= absint( $settings['positive_threshold'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'This rating does not require private feedback.', 'review-redirect-for-woocommerce' ) ), 400 );
		}

		if ( ! function_exists( 'wc_get_order' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'WooCommerce is unavailable.', 'review-redirect-for-woocommerce' ) ), 500 );
		}

		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Order not found.', 'review-redirect-for-woocommerce' ) ), 404 );
		}

		if ( ! hash_equals( (string) $order->get_order_key(), $order_key ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid order key.', 'review-redirect-for-woocommerce' ) ), 403 );
		}

		if ( $order->get_meta( '_rrfw_feedback', true ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Feedback was already submitted for this order.', 'review-redirect-for-woocommerce' ) ), 409 );
		}

		$feedback = array(
			'rating'       => $rating,
			'message'      => $message,
			'submitted_at' => current_time( 'mysql' ),
		);

		$order->update_meta_data( '_rrfw_feedback', $feedback );
		$order->save();

		$this->send_notification_email( $order, $feedback, $settings );

		wp_send_json_success( array( 'message' => esc_html__( 'Feedback submitted.', 'review-redirect-for-woocommerce' ) ) );
	}

	/**
	 * Sends the admin feedback email.
	 *
	 * @param WC_Order $order    WooCommerce order.
	 * @param array    $feedback Feedback data.
	 * @param array    $settings Plugin settings.
	 * @return void
	 */
	private function send_notification_email( $order, $feedback, $settings ) {
		$to = sanitize_email( $settings['notification_email'] );

		if ( empty( $to ) || ! is_email( $to ) ) {
			return;
		}

		$subject = sprintf(
			/* translators: %s: order number. */
			__( 'Low review feedback for order %s', 'review-redirect-for-woocommerce' ),
			$order->get_order_number()
		);

		$body = sprintf(
			/* translators: 1: order number, 2: rating, 3: message. */
			__( "Order: %1\$s\nRating: %2\$d/5\nFeedback:\n%3\$s", 'review-redirect-for-woocommerce' ),
			$order->get_order_number(),
			absint( $feedback['rating'] ),
			$feedback['message']
		);

		wp_mail( $to, $subject, $body );
	}
}

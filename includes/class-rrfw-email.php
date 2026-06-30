<?php
/**
 * WooCommerce email integration.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Email class.
 */
class RRFW_Email {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_email_after_order_table', array( $this, 'add_completed_order_review_request' ), 20, 4 );
	}

	/**
	 * Adds review request content to completed order emails.
	 *
	 * @param WC_Order $order         Order object.
	 * @param bool     $sent_to_admin Whether sent to admin.
	 * @param bool     $plain_text    Whether plain text email.
	 * @param WC_Email $email         Email object.
	 * @return void
	 */
	public function add_completed_order_review_request( $order, $sent_to_admin, $plain_text, $email ) {
		$settings = rrfw_get_settings();

		if ( empty( $settings['enabled'] ) || empty( $settings['completed_email'] ) || empty( $settings['google_review_url'] ) || $sent_to_admin ) {
			return;
		}

		if ( ! is_a( $order, 'WC_Order' ) || ! is_a( $email, 'WC_Email' ) || 'customer_completed_order' !== $email->id ) {
			return;
		}

		if ( $plain_text ) {
			echo "\n" . esc_html__( 'How was your experience?', 'review-redirect-for-woocommerce' ) . "\n";
			echo esc_html__( 'We would love to hear your thoughts about your order.', 'review-redirect-for-woocommerce' ) . "\n";
			echo esc_url( $settings['google_review_url'] ) . "\n";
			return;
		}
		?>
		<div class="rrfw-email-review-request">
			<h2><?php echo esc_html__( 'How was your experience?', 'review-redirect-for-woocommerce' ); ?></h2>
			<p><?php echo esc_html__( 'We would love to hear your thoughts about your order.', 'review-redirect-for-woocommerce' ); ?></p>
			<p>
				<a href="<?php echo esc_url( $settings['google_review_url'] ); ?>">
					<?php echo esc_html__( 'Leave a Google review', 'review-redirect-for-woocommerce' ); ?>
				</a>
			</p>
		</div>
		<?php
	}
}

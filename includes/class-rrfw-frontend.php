<?php
/**
 * Frontend review prompt.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Frontend class.
 */
class RRFW_Frontend {
	/**
	 * Current order ID.
	 *
	 * @var int
	 */
	private $order_id = 0;

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_thankyou', array( $this, 'render_prompt' ), 20 );
	}

	/**
	 * Renders the order received prompt.
	 *
	 * @param int $order_id Order ID.
	 * @return void
	 */
	public function render_prompt( $order_id ) {
		$settings = rrfw_get_settings();

		if ( empty( $settings['enabled'] ) || empty( $order_id ) || empty( $settings['google_review_url'] ) || ! function_exists( 'wc_get_order' ) ) {
			return;
		}

		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			return;
		}

		$this->order_id = absint( $order_id );
		$this->enqueue_assets( $settings );
		?>
		<div class="rrfw-popup" data-rrfw-popup data-rrfw-order-id="<?php echo esc_attr( $this->order_id ); ?>" hidden>
			<div class="rrfw-popup__overlay" data-rrfw-close></div>
			<div class="rrfw-popup__dialog" role="dialog" aria-modal="true" aria-labelledby="rrfw-popup-title" tabindex="-1">
				<div class="rrfw-popup__header">
					<span class="rrfw-popup__badge"><span class="rrfw-popup__badge-icon" aria-hidden="true">&#9733;</span><?php echo esc_html__( 'Order Feedback', 'review-redirect-for-woocommerce' ); ?></span>
					<button class="rrfw-popup__close" type="button" data-rrfw-close aria-label="<?php echo esc_attr__( 'Close review prompt', 'review-redirect-for-woocommerce' ); ?>">&times;</button>
				</div>

				<section class="rrfw-state rrfw-state--rating" data-rrfw-state="rating">
					<h2 id="rrfw-popup-title"><?php echo esc_html__( 'How did we do?', 'review-redirect-for-woocommerce' ); ?></h2>
					<p><?php echo esc_html__( 'Your feedback helps us improve and helps other customers shop with confidence.', 'review-redirect-for-woocommerce' ); ?></p>
					<div class="rrfw-stars" role="radiogroup" aria-label="<?php echo esc_attr__( 'Select a rating', 'review-redirect-for-woocommerce' ); ?>">
						<?php for ( $rating = 1; $rating <= 5; $rating++ ) : ?>
							<?php
							/* translators: %d: star rating. */
							$star_label = sprintf( _n( '%d star', '%d stars', $rating, 'review-redirect-for-woocommerce' ), $rating );
							?>
							<button type="button" class="rrfw-star" data-rrfw-rating="<?php echo esc_attr( $rating ); ?>" role="radio" aria-checked="false" aria-label="<?php echo esc_attr( $star_label ); ?>">&#9733;</button>
						<?php endfor; ?>
					</div>
					<p class="rrfw-rating-helper"><span class="rrfw-rating-helper__desktop"><?php echo esc_html__( 'Click a star to continue', 'review-redirect-for-woocommerce' ); ?></span><span class="rrfw-rating-helper__mobile"><?php echo esc_html__( 'Tap a star to continue', 'review-redirect-for-woocommerce' ); ?></span></p>
				</section>

				<section class="rrfw-state rrfw-state--google" data-rrfw-state="google" hidden>
					<div class="rrfw-state-icon rrfw-state-icon--success" aria-hidden="true">&#9786;</div>
					<div class="rrfw-confirm-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<h2><?php echo esc_html__( 'Great! Thank you!', 'review-redirect-for-woocommerce' ); ?></h2>
					<p><?php echo esc_html__( 'We\'re glad you had a great experience.', 'review-redirect-for-woocommerce' ); ?></p>
					<a class="rrfw-button rrfw-button--google" href="<?php echo esc_url( $settings['google_review_url'] ); ?>" target="_blank" rel="noopener noreferrer" data-rrfw-google-link>
						<span class="rrfw-google-mark" aria-hidden="true">G</span>
						<?php echo esc_html__( 'Leave a review on Google', 'review-redirect-for-woocommerce' ); ?>
					</a>
					<p class="rrfw-state-helper"><?php echo esc_html__( 'It only takes a few seconds', 'review-redirect-for-woocommerce' ); ?></p>
					<button class="rrfw-button rrfw-button--secondary" type="button" data-rrfw-close><?php echo esc_html__( 'Maybe later', 'review-redirect-for-woocommerce' ); ?></button>
				</section>

				<form class="rrfw-state rrfw-state--feedback" data-rrfw-state="feedback" data-rrfw-feedback hidden>
					<div class="rrfw-state-icon rrfw-state-icon--danger" aria-hidden="true">&#9785;</div>
					<h2><?php echo esc_html__( 'We\'re sorry to hear that', 'review-redirect-for-woocommerce' ); ?></h2>
					<p><?php echo esc_html__( 'Please let us know what we could have done better.', 'review-redirect-for-woocommerce' ); ?></p>
					<label for="rrfw-feedback-message"><?php echo esc_html__( 'Your feedback', 'review-redirect-for-woocommerce' ); ?></label>
					<textarea id="rrfw-feedback-message" name="message" rows="4" placeholder="<?php echo esc_attr__( 'Tell us what went wrong...', 'review-redirect-for-woocommerce' ); ?>" required></textarea>
					<input type="hidden" name="order_id" value="<?php echo esc_attr( $this->order_id ); ?>" />
					<input type="hidden" name="order_key" value="<?php echo esc_attr( $order->get_order_key() ); ?>" />
					<input type="hidden" name="rating" value="" data-rrfw-selected-rating />
					<button class="rrfw-button rrfw-button--submit" type="submit"><?php echo esc_html__( 'Send Feedback', 'review-redirect-for-woocommerce' ); ?></button>
					<p class="rrfw-private-note"><span aria-hidden="true">&#128274;</span><?php echo esc_html__( 'Your feedback is private and confidential', 'review-redirect-for-woocommerce' ); ?></p>
					<p class="rrfw-message" data-rrfw-response aria-live="polite"></p>
				</form>

				<section class="rrfw-state rrfw-state--success" data-rrfw-state="success" hidden>
					<div class="rrfw-state-icon rrfw-state-icon--success rrfw-state-icon--large" aria-hidden="true">&#10003;</div>
					<h2><?php echo esc_html__( 'Thank you!', 'review-redirect-for-woocommerce' ); ?></h2>
					<p data-rrfw-success-message><?php echo esc_html__( 'Your feedback has been received.', 'review-redirect-for-woocommerce' ); ?></p>
					<button class="rrfw-button rrfw-button--close" type="button" data-rrfw-close><?php echo esc_html__( 'Close', 'review-redirect-for-woocommerce' ); ?></button>
				</section>

				<section class="rrfw-state rrfw-state--error" data-rrfw-state="error" hidden>
					<div class="rrfw-state-icon rrfw-state-icon--danger" aria-hidden="true">!</div>
					<h2><?php echo esc_html__( 'Something went wrong', 'review-redirect-for-woocommerce' ); ?></h2>
					<p data-rrfw-error-message aria-live="polite"><?php echo esc_html__( 'Please try again.', 'review-redirect-for-woocommerce' ); ?></p>
					<button class="rrfw-button rrfw-button--submit" type="button" data-rrfw-state-target="rating"><?php echo esc_html__( 'Back to rating', 'review-redirect-for-woocommerce' ); ?></button>
				</section>

				<section class="rrfw-state rrfw-state--loading" data-rrfw-state="loading" hidden>
					<div class="rrfw-state-icon rrfw-state-icon--neutral" aria-hidden="true">...</div>
					<h2><?php echo esc_html__( 'Sending', 'review-redirect-for-woocommerce' ); ?></h2>
					<p><?php echo esc_html__( 'Please wait a moment.', 'review-redirect-for-woocommerce' ); ?></p>
				</section>
			</div>
		</div>
		<?php
	}

	/**
	 * Enqueues frontend assets.
	 *
	 * @param array $settings Plugin settings.
	 * @return void
	 */
	private function enqueue_assets( $settings ) {
		wp_enqueue_style(
			'rrfw-frontend',
			RRFW_PLUGIN_URL . 'assets/css/frontend.css',
			array(),
			RRFW_VERSION
		);

		wp_enqueue_script(
			'rrfw-frontend',
			RRFW_PLUGIN_URL . 'assets/js/frontend.js',
			array(),
			RRFW_VERSION,
			true
		);

		wp_localize_script(
			'rrfw-frontend',
			'rrfwFrontend',
			array(
				'ajaxUrl'           => admin_url( 'admin-ajax.php' ),
				'nonce'             => wp_create_nonce( 'rrfw_submit_feedback' ),
				'threshold'         => absint( $settings['positive_threshold'] ),
				'feedbackError'     => esc_html__( 'Please add a short message before sending.', 'review-redirect-for-woocommerce' ),
				'feedbackSuccess'   => esc_html__( 'Your feedback has been received.', 'review-redirect-for-woocommerce' ),
				'feedbackFail'      => esc_html__( 'We could not send your feedback. Please try again.', 'review-redirect-for-woocommerce' ),
				'googleSuccess'     => esc_html__( 'Thank you for supporting our business!', 'review-redirect-for-woocommerce' ),
				'storageKeyPrefix'  => 'rrfw_review_prompt_done_',
			)
		);
	}
}
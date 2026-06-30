<?php
/**
 * Admin settings.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin class.
 */
class RRFW_Admin {
	/**
	 * Settings page slug.
	 *
	 * @var string
	 */
	const PAGE_SLUG = 'review-redirect-for-woocommerce';

	/**
	 * WooCommerce Marketing parent slug.
	 *
	 * @var string
	 */
	const MARKETING_PARENT_SLUG = 'woocommerce-marketing';

	/**
	 * WordPress Marketing parent slug.
	 *
	 * @var string
	 */
	const WP_MARKETING_PARENT_SLUG = 'marketing';

	/**
	 * Settings page capability.
	 *
	 * @var string
	 */
	private $capability = 'manage_woocommerce';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'register_menu' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_filter( 'plugin_action_links_' . RRFW_PLUGIN_BASENAME, array( $this, 'add_plugin_action_links' ) );
	}

	/**
	 * Registers settings.
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting(
			'rrfw_settings_group',
			'rrfw_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => 'rrfw_sanitize_settings',
				'default'           => rrfw_get_default_settings(),
			)
		);
	}

	/**
	 * Registers the settings page under Marketing where possible.
	 *
	 * @return void
	 */
	public function register_menu() {
		$parent_slug = $this->get_marketing_parent_slug();
		$this->capability = rrfw_is_woocommerce_active() ? 'manage_woocommerce' : 'manage_options';

		add_submenu_page(
			$parent_slug,
			esc_html__( 'Review Redirect', 'review-redirect-for-woocommerce' ),
			esc_html__( 'Review Redirect', 'review-redirect-for-woocommerce' ),
			$this->capability,
			self::PAGE_SLUG,
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Determines a Marketing-compatible parent menu.
	 *
	 * @return string
	 */
	private function get_marketing_parent_slug() {
		global $menu, $submenu;

		if ( $this->admin_menu_exists( self::MARKETING_PARENT_SLUG ) ) {
			return self::MARKETING_PARENT_SLUG;
		}

		if ( $this->admin_menu_exists( self::WP_MARKETING_PARENT_SLUG ) ) {
			return self::WP_MARKETING_PARENT_SLUG;
		}

		if ( is_array( $submenu ) ) {
			foreach ( $submenu as $parent_slug => $submenu_items ) {
				if ( false !== strpos( (string) $parent_slug, 'marketing' ) && ! empty( $submenu_items ) ) {
					return (string) $parent_slug;
				}
			}
		}

		if ( class_exists( 'WooCommerce' ) ) {
			return 'woocommerce';
		}

		return 'options-general.php';
	}

	/**
	 * Checks whether an admin menu parent exists.
	 *
	 * @param string $slug Parent menu slug.
	 * @return bool
	 */
	private function admin_menu_exists( $slug ) {
		global $menu, $submenu;

		if ( is_array( $menu ) ) {
			foreach ( $menu as $menu_item ) {
				if ( isset( $menu_item[2] ) && $slug === $menu_item[2] ) {
					return true;
				}
			}
		}

		return is_array( $submenu ) && isset( $submenu[ $slug ] );
	}

	/**
	 * Enqueues admin assets.
	 *
	 * @param string $hook Current admin hook.
	 * @return void
	 */
	public function enqueue_assets( $hook ) {
		if ( false === strpos( $hook, self::PAGE_SLUG ) ) {
			return;
		}

		wp_enqueue_style(
			'rrfw-admin',
			RRFW_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			RRFW_VERSION
		);
	}

	/**
	 * Adds Settings link to the Plugins screen.
	 *
	 * @param array $links Existing action links.
	 * @return array
	 */
	public function add_plugin_action_links( $links ) {
		$settings_url  = $this->get_settings_url();
		$settings_link = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( $settings_url ),
			esc_html__( 'Settings', 'review-redirect-for-woocommerce' )
		);

		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Returns the settings page URL.
	 *
	 * @return string
	 */
	private function get_settings_url() {
		return admin_url( 'admin.php?page=' . self::PAGE_SLUG );
	}

	/**
	 * Renders the settings page.
	 *
	 * @return void
	 */
	public function render_settings_page() {
		if ( ! current_user_can( $this->capability ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'review-redirect-for-woocommerce' ) );
		}

		$settings = rrfw_get_settings();
		?>
		<div class="wrap rrfw-admin-wrap">
			<h1><?php echo esc_html__( 'Review Redirect', 'review-redirect-for-woocommerce' ); ?></h1>
			<?php settings_errors( 'rrfw_settings' ); ?>
			<?php if ( ! rrfw_is_woocommerce_active() ) : ?>
				<div class="notice notice-warning">
					<p><?php echo esc_html__( 'WooCommerce is required for the frontend prompt and completed order email content.', 'review-redirect-for-woocommerce' ); ?></p>
				</div>
			<?php endif; ?>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'rrfw_settings_group' );
				?>
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row"><?php echo esc_html__( 'Enable plugin', 'review-redirect-for-woocommerce' ); ?></th>
							<td>
								<label>
									<input type="checkbox" name="rrfw_settings[enabled]" value="1" <?php checked( 1, absint( $settings['enabled'] ) ); ?> />
									<?php echo esc_html__( 'Show review prompt on the order received page.', 'review-redirect-for-woocommerce' ); ?>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="rrfw_google_review_url"><?php echo esc_html__( 'Google review URL', 'review-redirect-for-woocommerce' ); ?></label></th>
							<td>
								<input class="regular-text" type="url" id="rrfw_google_review_url" name="rrfw_settings[google_review_url]" value="<?php echo esc_url( $settings['google_review_url'] ); ?>" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="rrfw_popup_title"><?php echo esc_html__( 'Popup title', 'review-redirect-for-woocommerce' ); ?></label></th>
							<td>
								<input class="regular-text" type="text" id="rrfw_popup_title" name="rrfw_settings[popup_title]" value="<?php echo esc_attr( $settings['popup_title'] ); ?>" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="rrfw_popup_message"><?php echo esc_html__( 'Popup message', 'review-redirect-for-woocommerce' ); ?></label></th>
							<td>
								<textarea class="large-text" rows="4" id="rrfw_popup_message" name="rrfw_settings[popup_message]"><?php echo esc_textarea( $settings['popup_message'] ); ?></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="rrfw_positive_threshold"><?php echo esc_html__( 'Positive rating threshold', 'review-redirect-for-woocommerce' ); ?></label></th>
							<td>
								<input type="number" min="1" max="5" id="rrfw_positive_threshold" name="rrfw_settings[positive_threshold]" value="<?php echo esc_attr( absint( $settings['positive_threshold'] ) ); ?>" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="rrfw_notification_email"><?php echo esc_html__( 'Feedback notification email', 'review-redirect-for-woocommerce' ); ?></label></th>
							<td>
								<input class="regular-text" type="email" id="rrfw_notification_email" name="rrfw_settings[notification_email]" value="<?php echo esc_attr( $settings['notification_email'] ); ?>" />
							</td>
						</tr>
						<tr>
							<th scope="row"><?php echo esc_html__( 'Completed order email review request', 'review-redirect-for-woocommerce' ); ?></th>
							<td>
								<label>
									<input type="checkbox" name="rrfw_settings[completed_email]" value="1" <?php checked( 1, absint( $settings['completed_email'] ) ); ?> />
									<?php echo esc_html__( 'Add review request content to completed order emails.', 'review-redirect-for-woocommerce' ); ?>
								</label>
							</td>
						</tr>
					</tbody>
				</table>
				<?php submit_button( esc_html__( 'Save settings', 'review-redirect-for-woocommerce' ) ); ?>
			</form>
		</div>
		<?php
	}
}

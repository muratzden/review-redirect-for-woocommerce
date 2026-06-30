<?php
/**
 * Main plugin coordinator.
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
final class RRFW_Plugin {
	/**
	 * Singleton instance.
	 *
	 * @var RRFW_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Returns the singleton instance.
	 *
	 * @return RRFW_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->includes();
		$this->hooks();
	}

	/**
	 * Loads class files.
	 *
	 * @return void
	 */
	private function includes() {
		require_once RRFW_PLUGIN_DIR . 'includes/class-rrfw-admin.php';
		require_once RRFW_PLUGIN_DIR . 'includes/class-rrfw-frontend.php';
		require_once RRFW_PLUGIN_DIR . 'includes/class-rrfw-feedback.php';
		require_once RRFW_PLUGIN_DIR . 'includes/class-rrfw-email.php';
	}

	/**
	 * Registers hooks.
	 *
	 * @return void
	 */
	private function hooks() {
		if ( is_admin() ) {
			new RRFW_Admin();
		}

		new RRFW_Frontend();
		new RRFW_Feedback();
		new RRFW_Email();
	}
}

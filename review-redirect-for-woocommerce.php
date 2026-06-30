<?php
/**
 * Plugin Name: Review Redirect for WooCommerce
 * Description: Collect customer ratings after WooCommerce orders and guide happy customers to leave a Google review.
 * Version: 0.1.7
 * Author: Murat Ãƒâ€“zden
 * Text Domain: review-redirect-for-woocommerce
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * WC requires at least: 7.0
 * WC tested up to: 9.0
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package Review_Redirect_For_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RRFW_VERSION', '0.1.7' );
define( 'RRFW_PLUGIN_FILE', __FILE__ );
define( 'RRFW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RRFW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RRFW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);

require_once RRFW_PLUGIN_DIR . 'includes/rrfw-functions.php';
require_once RRFW_PLUGIN_DIR . 'includes/class-rrfw-plugin.php';

/**
 * Bootstraps the plugin.
 *
 * @return RRFW_Plugin
 */
function rrfw() {
	return RRFW_Plugin::instance();
}

add_action( 'plugins_loaded', 'rrfw' );



<?php
/**
 * Plugin Name: Customize My Account Page For WooCommerce
 * Description: Allows you to register custom WooCommerce tabs on my-account page and customize the design.
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * Author: ThemeGrill
 * Author URI: https://themegrill.com
 * Version: 1.0.0
 * Text Domain: customize-my-account-page
 * Domain Path: /languages
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * WC requires at least: 3.5.0
 * WC tested up to: 9.9.5
 *
 * @package ThemeGrill\WoocommerceCustomizer
 */

use ThemeGrill\WoocommerceCustomizer\WoocommerceCustomizer;

defined( 'ABSPATH' ) || exit;

/**
 * Deactivate free plugin if pro is installed.
 *
 * @since 1.0.0
 */
if ( in_array( 'customize-my-account-page-for-woocommerce/customize-my-account-page-for-woocommerce.php', get_option( 'active_plugins', array() ), true ) ) {
	return;
}

if ( ! defined( 'TGWC_PLUGIN_FILE' ) ) {
	define( 'TGWC_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'TGWC_VERSION' ) ) {
	define( 'TGWC_VERSION', '1.0.0' );
}

if ( ! defined( 'TGWC_ABSPATH' ) ) {
	define( 'TGWC_ABSPATH', dirname( TGWC_PLUGIN_FILE ) . '/' );
}

if ( ! defined( 'TGWC_PLUGIN_BASENAME' ) ) {
	define( 'TGWC_PLUGIN_BASENAME', dirname( TGWC_PLUGIN_FILE ) );
}

if ( ! defined( 'TGWC_TEMPLATE_PATH' ) ) {
	define( 'TGWC_TEMPLATE_PATH', dirname( TGWC_PLUGIN_FILE ) . '/templates/' );
}

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Returns the main instance of Themegrill WooCommerce Customizer.
 *
 * @since 1.0.0
 * @return ThemeGrill\WoocommerceCustomizer\WoocommerceCustomizer
 */
// phpcs:ignore
if(!function_exists('TGWC')) {
	function TGWC() {
		return WoocommerceCustomizer::instance();
	}

	TGWC();
}

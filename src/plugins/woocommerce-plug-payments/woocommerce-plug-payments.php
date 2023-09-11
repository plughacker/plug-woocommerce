<?php
/**
 * Plugin Name: Malga
 * Plugin URI: https://www.malga.io/wocommerce
 * Description: Take credit card payments on your store using Malga.
 * Author: Malga Team
 * Author URI: https://www.malga.io/
 * Version: 1.4.0
 * Requires at least: 5.6
 * Tested up to: 5.9
 * WC requires at least: 3.3
 * WC tested up to: 5.8.3
 * Text Domain: plug-payments-gateway
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit;

// Plugin constants.
define( 'WC_PLUGPAYMENTS_VERSION', '1.3.0' );
define( 'WC_PLUGPAYMENTS_PLUGIN_FILE', __FILE__ );
require_once dirname( __FILE__ ) . '/includes/constants/payments-types.php';

class WC_Plug_Payments {
	public static function init() {				
		// Checks with WooCommerce is installed.
		if ( class_exists( 'WC_Payment_Gateway' ) ) {
			require_once dirname( __FILE__ ) . '/sdk/plug-payments.php';
			require_once dirname( __FILE__ ) . '/includes/class-wc-plug-api.php';
			require_once dirname( __FILE__ ) . '/includes/class-wc-plug-gateway.php';
			require_once dirname( __FILE__ ) . '/includes/class-plug-charges-adapter.php';

			add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'add_gateway' ) );
		} else {
			add_action( 'admin_notices', array( __CLASS__, 'woocommerce_missing_notice' ) );
		}	
	}

	public static function woocommerce_missing_notice() {
		include dirname( __FILE__ ) . '/templates/notice/missing-woocommerce.php';
	}

	public static function add_gateway( $methods ) {
		$methods[] = 'WC_Plug_Gateway';

		return $methods;
	}	
	
	public static function get_templates_path() {
		return plugin_dir_path( WC_PLUGPAYMENTS_PLUGIN_FILE ) . 'templates/';
	}	

	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'plug-payments-gateway', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}	
}   

add_action( 'plugins_loaded', array( 'WC_Plug_Payments', 'init' ) );
add_action( 'plugins_loaded', array( 'WC_Plug_Payments', 'load_plugin_textdomain' ) );

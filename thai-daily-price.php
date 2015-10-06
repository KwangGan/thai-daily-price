<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              kwanggan.me
 * @since             1.0.0
 * @package           Thai_Daily_Price
 *
 * @wordpress-plugin
 * Plugin Name:       Thai daily price
 * Plugin URI:        kwanggan.me
 * Description:       ก็ทำไว้ใช้เองครับแต่คิดว่าอาจจะมีประโยชน์ก็แจก ขอบคุณครับ
 * Version:           1.0.0
 * Author:            KwangGan
 * Author URI:        kwanggan.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       thai-daily-price
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-thai-daily-price-activator.php
 */
function activate_thai_daily_price() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-thai-daily-price-activator.php';
	Thai_Daily_Price_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-thai-daily-price-deactivator.php
 */
function deactivate_thai_daily_price() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-thai-daily-price-deactivator.php';
	Thai_Daily_Price_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_thai_daily_price' );
register_deactivation_hook( __FILE__, 'deactivate_thai_daily_price' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-thai-daily-price.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_thai_daily_price() {

	$plugin = new Thai_Daily_Price();
	$plugin->run();

}
run_thai_daily_price();

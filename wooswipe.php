<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thriveweb.com.au/
 * @since             1.0.0
 * @package           Wooswipe
 *
 * @wordpress-plugin
 * Plugin Name:       WooSwipe
 * Plugin URI:        https://thriveweb.com.au/the-lab/wooswipe/
 * Description:       WooCommerce product gallery built with PhotoSwipe and Slick carousel. Responsive, touch-friendly, with lightbox and optional main-image slider.
 * Version:           3.0.9
 * Author:            Thrive Website Design
 * Author URI:        https://thriveweb.com.au/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wooswipe
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * WC requires at least: 7.0
 * WC tested up to:   10.9
 * Requires Plugins:  woocommerce
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version (SemVer).
 *
 * Keep in sync with the Version header above and readme.txt Stable tag.
 *
 * @since 1.0.0
 */
define( 'WOOSWIPE_VERSION', '3.0.9' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wooswipe-activator.php
 */
function activate_wooswipe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wooswipe.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wooswipe-activator.php';
	Wooswipe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wooswipe-deactivator.php
 */
function deactivate_wooswipe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wooswipe-deactivator.php';
	Wooswipe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wooswipe' );
register_deactivation_hook( __FILE__, 'deactivate_wooswipe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wooswipe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wooswipe() {

	$plugin = new Wooswipe();
	$plugin->run();

}
run_wooswipe();

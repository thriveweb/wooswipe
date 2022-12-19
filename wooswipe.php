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
 * Description:       This is a image gallery plugin for WordPress built using <a href="http://photoswipe.com.au/">photoswipe</a> from Dmitry Semenov and <a href="http://kenwheeler.github.io/slick/">Slick</a> Carousel</a>.
 * Version:           3.0.3
 * Author:            Thrive Website Design
 * Author URI:        https://thriveweb.com.au/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wooswipe
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOSWIPE_VERSION', '3.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wooswipe-activator.php
 */
function activate_wooswipe() {
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

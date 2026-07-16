<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * Removes plugin options from the database. Does not remove product media.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'wooswipe_options' );

if ( is_multisite() ) {
	delete_site_option( 'wooswipe_options' );
}

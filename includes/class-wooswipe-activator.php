<?php

/**
 * Fired during plugin activation
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wooswipe
 * @subpackage Wooswipe/includes
 * @author     Thrive Website Design <dean@thriveweb.com.au>
 */
class Wooswipe_Activator {

	/**
	 * Seed default options on activation.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$existing = get_option( 'wooswipe_options', false );
		if ( false === $existing ) {
			add_option( 'wooswipe_options', Wooswipe::get_default_options() );
			return;
		}

		update_option(
			'wooswipe_options',
			wp_parse_args( (array) $existing, Wooswipe::get_default_options() )
		);
	}

}

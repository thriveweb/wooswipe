<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/admin
 * @author     Thrive Website Design <dean@thriveweb.com.au>
 */
class Wooswipe_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Plugin options.
	 *
	 * @var array
	 */
	protected $wooswipe_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name      = $plugin_name;
		$this->version          = $version;
		$this->wooswipe_options = Wooswipe::get_options();
	}

	/**
	 * Seed default option values when missing.
	 *
	 * @since 1.0.0
	 * @since 3.0.9 Uses manage_options and shared defaults helper.
	 */
	public function wooswipe_save_default_values() {
		$options = get_option( 'wooswipe_options', false );
		if ( false === $options && current_user_can( 'manage_options' ) ) {
			$this->wooswipe_update_settings( Wooswipe::get_default_options() );
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wooswipe-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wooswipe-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register Admin Menu for WooSwipe.
	 *
	 * @since    1.0.0
	 */
	public function wooswipe_admin_menu() {
		add_submenu_page( 'woocommerce', 'WooSwipe', 'WooSwipe', 'manage_options', 'wooswipe-options', array( $this, 'wooswipe_show_admin_settings_form' ) );
	}

	/**
	 * Display Admin Form WooSwipe.
	 *
	 * @since    1.0.0
	 */
	public function wooswipe_show_admin_settings_form() {
		include plugin_dir_path( __FILE__ ) . 'partials/wooswipe-admin-display.php';
	}

	/**
	 * Save / update WooSwipe settings.
	 *
	 * Requires manage_options and a valid nonce. Colours are sanitised with
	 * sanitize_hex_color(); checkbox flags are stored as booleans.
	 *
	 * @since 1.0.0
	 * @since 3.0.9 Hardened nonce/capability checks and input sanitisation.
	 * @return bool
	 */
	public function wooswipe_save_admin_options() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		if ( ! isset( $_POST['wooswipe_nonce_field'] ) ) {
			return false;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['wooswipe_nonce_field'] ) );
		if ( ! wp_verify_nonce( $nonce, 'wooswipe_nonce_action' ) ) {
			return false;
		}

		$options = Wooswipe::get_options();

		$options['white_theme']                   = isset( $_POST['white_theme'] );
		$options['pinterest']                     = isset( $_POST['pinterest'] );
		$options['hide_thumbnails']               = isset( $_POST['hide_thumbnails'] );
		$options['product_main_slider']           = isset( $_POST['product_main_slider'] );
		$options['product_main_slider_nav_arrow'] = isset( $_POST['product_main_slider_nav_arrow'] );
		$options['remove_thumb_slider']           = isset( $_POST['remove_thumb_slider'] );

		if ( isset( $_POST['icon_bg_color'] ) ) {
			$options['icon_bg_color'] = sanitize_hex_color( wp_unslash( $_POST['icon_bg_color'] ) );
			if ( empty( $options['icon_bg_color'] ) ) {
				$options['icon_bg_color'] = '#000000';
			}
		} else {
			$options['icon_bg_color'] = '#000000';
		}

		if ( isset( $_POST['icon_stroke_color'] ) ) {
			$options['icon_stroke_color'] = sanitize_hex_color( wp_unslash( $_POST['icon_stroke_color'] ) );
			if ( empty( $options['icon_stroke_color'] ) ) {
				$options['icon_stroke_color'] = '#ffffff';
			}
		} else {
			$options['icon_stroke_color'] = '#ffffff';
		}

		$this->wooswipe_update_settings( $options );
		$this->wooswipe_options = $options;

		return true;
	}

	/**
	 * Persist settings.
	 *
	 * @param array $options Options array.
	 */
	public function wooswipe_update_settings( $options ) {
		update_option( 'wooswipe_options', $options );
	}
}

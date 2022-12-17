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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/admin
 * @author     Thrive Website Design <dean@thriveweb.com.au>
 */
class Wooswipe_Admin
{

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	/**
	 * Get wooswipe default options
	 */
	protected $wooswipe_options;

	/**
	 * $is_admin will store flag for the admin type user role
	 */
	protected $is_admin;

	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->is_admin = false;
		$this->wooswipe_options = get_option('wooswipe_options');
	}

	/**
	 * Save option data for the wooswipe plugin
	 * 
	 * @since    1.0.0
	 */
	public function wooswipe_save_default_values()
	{

		$options = $this->wooswipe_options;
		$this->is_admin = $this->wooswipe_get_current_user_roles();
		if (!is_array($options) && current_user_can('manage_options') && $this->is_admin) {
			$options['white_theme'] = (bool)false;
			$options['pinterest'] = (bool)false;
			$options['hide_thumbnails'] = (bool)false;
			$options['remove_thumb_slider'] = (bool)false;
			$options['product_main_slider'] = (bool)false;
			$options['product_main_slider_nav_arrow'] = (bool)false;
			$options['icon_bg_color'] = sanitize_text_field("#000000");
			$options['icon_stroke_color'] = sanitize_text_field("#ffffff");
			$this->wooswipe_update_settings($options);
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wooswipe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wooswipe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wooswipe-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wooswipe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wooswipe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wooswipe-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Register Admin Menu for WooSwipe
	 * 
	 * @since    1.0.0
	 */
	public function wooswipe_admin_menu()
	{
		add_submenu_page('woocommerce', 'WooSwipe', 'WooSwipe', 'manage_options', 'wooswipe-options', array($this, 'wooswipe_show_admin_settings_form'));
	}

	/**
	 * Display Admin Form WooSwipe
	 * 
	 * @since    1.0.0
	 */
	public function wooswipe_show_admin_settings_form()
	{
		include plugin_dir_path(__FILE__) .'partials/wooswipe-admin-display.php';
	}

	/**
	 * Save / Update the WooSwipe settings Options
	 * 
	 */
	public function wooswipe_save_admin_options()
	{	
		$this->is_admin = $this->wooswipe_get_current_user_roles();
		
		if (isset($_POST['wooswipe_nonce_field']) && $this->is_admin) {

			$options = get_option('wooswipe_options');

			if (isset($_POST['white_theme'])) {
				$options['white_theme'] = (bool)true;
			} else {
				$options['white_theme'] = (bool)false;
			}

			if (isset($_POST['pinterest'])) {
				$options['pinterest'] = (bool)true;
			} else {
				$options['pinterest'] = (bool)false;
			}

			if (isset($_POST['hide_thumbnails'])) {
				$options['hide_thumbnails'] = (bool)true;
			} else {
				$options['hide_thumbnails'] = (bool)false;
			}

			if (isset($_POST['product_main_slider'])) {
				$options['product_main_slider'] = (bool)true;
			} else {
				$options['product_main_slider'] = (bool)false;
			}

			if (isset($_POST['product_main_slider_nav_arrow'])) {
				$options['product_main_slider_nav_arrow'] = (bool)true;
			} else {
				$options['product_main_slider_nav_arrow'] = (bool)false;
			}


			if (isset($_POST['remove_thumb_slider'])) {
				$options['remove_thumb_slider'] = (bool)true;
			} else {
				$options['remove_thumb_slider'] = (bool)false;
			}

			if (isset($_POST['icon_bg_color'])) {
				$options['icon_bg_color'] = sanitize_text_field($_POST['icon_bg_color']);
			} else {
				$options['icon_bg_color'] = sanitize_text_field('#000000');
			}

			if (isset($_POST['icon_stroke_color'])) {
				$options['icon_stroke_color'] = sanitize_text_field($_POST['icon_stroke_color']);
			} else {
				$options['icon_stroke_color'] = sanitize_text_field('#ffffff');
			}
			if (isset($_POST['wooswipe_nonce_field']) && wp_verify_nonce($_POST['wooswipe_nonce_field'], 'wooswipe_nonce_action') == 1) {
				$this->wooswipe_update_settings($options);
			}
			return true;
		} else {
			return false;
		}
	}

	public function wooswipe_update_settings($options) {
		update_option('wooswipe_options', $options);
	}

	/**
	 * Get current logged in user's role
	 * 
	 */
	public function wooswipe_get_current_user_roles()
	{

		if (is_user_logged_in()) {

			$user = wp_get_current_user();

			$loggedin_userroles = (array) $user->roles;

			if(isset($loggedin_userroles) && in_array('administrator', $loggedin_userroles)) {
				return true; // This will returns an array
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

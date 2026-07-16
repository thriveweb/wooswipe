<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wooswipe
 * @subpackage Wooswipe/includes
 * @author     Thrive Website Design <dean@thriveweb.com.au>
 */
class Wooswipe {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wooswipe_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOOSWIPE_VERSION' ) ) {
			$this->version = WOOSWIPE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wooswipe';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Default plugin options.
	 *
	 * @since 3.0.9
	 * @return array
	 */
	public static function get_default_options() {
		return array(
			'white_theme'                   => false,
			'pinterest'                     => false,
			'hide_thumbnails'               => false,
			'remove_thumb_slider'           => false,
			'product_main_slider'           => false,
			'product_main_slider_nav_arrow' => false,
			'icon_bg_color'                 => '#000000',
			'icon_stroke_color'             => '#ffffff',
		);
	}

	/**
	 * Get plugin options merged with defaults.
	 *
	 * Always use this instead of get_option( 'wooswipe_options' ) directly
	 * so missing keys do not trigger PHP notices.
	 *
	 * @since 3.0.9
	 * @return array
	 */
	public static function get_options() {
		return wp_parse_args( (array) get_option( 'wooswipe_options', array() ), self::get_default_options() );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wooswipe_Loader. Orchestrates the hooks of the plugin.
	 * - Wooswipe_i18n. Defines internationalization functionality.
	 * - Wooswipe_Admin. Defines all hooks for the admin area.
	 * - Wooswipe_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wooswipe-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wooswipe-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wooswipe-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wooswipe-public.php';

		$this->loader = new Wooswipe_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wooswipe_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wooswipe_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wooswipe_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action('plugins_loaded', $plugin_admin,'wooswipe_save_default_values');
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu',$plugin_admin, 'wooswipe_admin_menu', 99 );
		$this->loader->add_action( 'admin_init',$plugin_admin, 'wooswipe_save_admin_options');
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wooswipe_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'setup_theme', $plugin_public, 'remove_woocommerce_theme_support' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'after_setup_theme', $plugin_public, 'wooswipe_theme_setup' );
		$this->loader->add_action( 'wp_print_scripts', $plugin_public, 'wooswipe_deregister_javascript', 100 );
		$this->loader->add_action( 'wp_print_styles', $plugin_public, 'wooswipe_deregister_styles', 100 );
		$this->loader->add_action( 'woocommerce_before_single_product_summary', $plugin_public, 'wooswipe_woocommerce_before_single_product_summary' );
		$this->loader->add_action( 'woocommerce_before_single_product_summary', $plugin_public, 'wooswipe_woocommerce_show_product_thumbnails', 20 );
		// Block themes render the gallery via the product-image-gallery block — replace it so we don't get a double gallery.
		$this->loader->add_filter( 'render_block_woocommerce/product-image-gallery', $plugin_public, 'render_product_image_gallery_block', 10, 2 );
		$this->loader->add_action( 'wp', $plugin_public, 'wooswipe_remove_image_zoom_support' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wooswipe_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

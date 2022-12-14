<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/public
 * @author     Thrive Website Design <dean@thriveweb.com.au>
 */
class Wooswipe_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	public $wooswipe_options;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->wooswipe_options = get_option('wooswipe_options');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		$options = $this->wooswipe_options;
		wp_enqueue_style('wooswipe-pswp-css', plugin_dir_url( __FILE__ ) . 'pswp/photoswipe.css', array(), $this->version, 'all');
		if ($options['white_theme']) wp_enqueue_style( 'wooswipe-pswp-skin-white', plugin_dir_url( __FILE__ ) . 'pswp/white-skin/skin.css', array(), $this->version, 'all' );
		else wp_enqueue_style( 'wooswipe-pswp-skin', plugin_dir_url( __FILE__ ) . 'pswp/default-skin/default-skin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wooswipe-slick-css', plugin_dir_url( __FILE__ ) . 'slick/slick.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wooswipe-slick-theme', plugin_dir_url( __FILE__ ) . 'slick/slick-theme.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wooswipe-css', plugin_dir_url( __FILE__ ) . 'css/wooswipe.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		$options = $this->wooswipe_options;
		$wooswipe_wp_plugin_path =  plugins_url() . '/wooswipe';
		wp_enqueue_script( 'wooswipe-pswp', plugin_dir_url( __FILE__ ) . 'pswp/photoswipe.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wooswipe-pswp-ui', plugin_dir_url( __FILE__ ) . 'pswp/photoswipe-ui-default.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wooswipe-slick', plugin_dir_url( __FILE__ ) . 'slick/slick.min.js', array( 'jquery' ), $this->version, false );
		$wooswipe_data = array();
		$template_Url = array('templateUrl' => $wooswipe_wp_plugin_path);
        if ($options['pinterest']) {
            $wooswipe_data = array('addpin' => true);
        } else {
            $wooswipe_data = array('addpin' => false);
        }

        if (!empty($options['icon_bg_color'])) {
            $wooswipe_data['icon_bg_color'] = sanitize_text_field($options['icon_bg_color']);
        } else {
            $wooswipe_data['icon_bg_color'] = sanitize_text_field('#000000');
        }

        if (!empty($options['icon_stroke_color'])) {
            $wooswipe_data['icon_stroke_color'] = sanitize_text_field($options['icon_stroke_color']);
        } else {
            $wooswipe_data['icon_stroke_color'] = sanitize_text_field('#ffffff');
        }

        
        if ($options['product_main_slider'] == true) {
            if ($options['product_main_slider_nav_arrow'] == true) {
                $wooswipe_data['product_main_slider_nav_arrow'] = true;
            }
            $wooswipe_data['product_main_slider'] =  true;
			wp_enqueue_script('wooswipe-main-image-swipe-js', plugin_dir_url( __FILE__ ) . 'js/wooswipe-main_image_swipe.js', null, null, true);
            wp_localize_script('wooswipe-main-image-swipe-js', 'wooswipe_wp_plugin_path', $template_Url);
            wp_localize_script('wooswipe-main-image-swipe-js', 'wooswipe_data', $wooswipe_data);
            
        } else {
            $wooswipe_data['product_main_slider'] =  false;
            wp_enqueue_script('wooswipe-js', plugin_dir_url( __FILE__ ) . 'js/wooswipe.js', null, null, true);
            wp_localize_script('wooswipe-js', 'wooswipe_wp_plugin_path', $template_Url);
            wp_localize_script('wooswipe-js', 'wooswipe_data', $wooswipe_data);
        }
		
	}

	public function remove_woocommerce_theme_support() {
		remove_theme_support('woocommerce', array('thumbnail_image_width', 'gallery_thumbnail_image_width', 'single_image_width'));
	}
	
	/**
	 * Set up the theme support using wooswipe
	 */
	public function wooswipe_theme_setup() {
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
	}

	public function wooswipe_deregister_javascript() {
		wp_deregister_script( 'prettyPhoto' );
		wp_deregister_script( 'prettyPhoto-init' );
	}

	public function wooswipe_deregister_styles() {
		wp_deregister_style( 'woocommerce_prettyPhoto_css' );
	}

	public function wooswipe_woocommerce_before_single_product_summary() {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	}

	public function wooswipe_remove_image_zoom_support() {
		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
		remove_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Build Swiper for the Main Image
	 */
	public function wooswipe_woocommerce_show_product_main_image_swiper($finalArray, $zoomed_image_size){
		include plugin_dir_path(__FILE__) . 'partials/wooswipe-main_image_swiper.php';
	}

	/**
	 * Build to set the placeholder Image
	 */

	public function wooswipe_add_placeholder_image(){
		global $post;
		$dimensions = wc_get_image_size( 'medium' );
		$hwstring   = image_hwstring( $dimensions['width'], $dimensions['height'] );
		$html = sprintf('<img src="%s" alt="%s" class="%s" data-ind="0" title="placeholder" data-title="placeholder" data-hq="%s" %s data-h="%s" data-w="%s"/>', wc_placeholder_img_src(), __('Placeholder', 'woocommerce') , __('wooswipe-placeholder single-product-main-image','woocommerce'),wc_placeholder_img_src(),$hwstring,$dimensions['height'], $dimensions['width']);
		echo apply_filters('woocommerce_single_product_image_html', $html, $post->ID);
	}

	/**
	* Build Swiper
	*/
	public function wooswipe_woocommerce_show_product_thumbnails() {
		include plugin_dir_path(__FILE__) . 'partials/wooswipe-public-display.php';
		include_once(plugin_dir_path(__FILE__) . 'partials/inc-photoswipe-footer.php');
	}

}

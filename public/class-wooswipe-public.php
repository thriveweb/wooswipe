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
	 * Plugin options.
	 *
	 * @var array
	 */
	public $wooswipe_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name      = $plugin_name;
		$this->version          = $version;
		$this->wooswipe_options = Wooswipe::get_options();
	}

	/**
	 * Whether frontend gallery assets should load.
	 *
	 * Limited to single product pages and content that embeds [product_page]
	 * so PhotoSwipe/Slick are not loaded site-wide.
	 *
	 * @since 3.0.9
	 * @return bool
	 */
	private function should_enqueue_assets() {
		if ( is_admin() ) {
			return false;
		}

		if ( function_exists( 'is_product' ) && is_product() ) {
			return true;
		}

		global $post;
		if ( $post instanceof WP_Post && has_shortcode( $post->post_content, 'product_page' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if ( ! $this->should_enqueue_assets() ) {
			return;
		}

		$options = $this->wooswipe_options;
		wp_enqueue_style( 'wooswipe-pswp-css', plugin_dir_url( __FILE__ ) . 'pswp/photoswipe.css', array(), $this->version, 'all' );
		if ( ! empty( $options['white_theme'] ) ) {
			wp_enqueue_style( 'wooswipe-pswp-skin-white', plugin_dir_url( __FILE__ ) . 'pswp/white-skin/skin.css', array(), $this->version, 'all' );
		} else {
			wp_enqueue_style( 'wooswipe-pswp-skin', plugin_dir_url( __FILE__ ) . 'pswp/default-skin/default-skin.css', array(), $this->version, 'all' );
		}
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
		if ( ! $this->should_enqueue_assets() ) {
			return;
		}

		$options                 = $this->wooswipe_options;
		$wooswipe_wp_plugin_path = plugins_url() . '/wooswipe';
		$script_deps             = array( 'jquery', 'wooswipe-pswp', 'wooswipe-pswp-ui', 'wooswipe-slick' );

		wp_enqueue_script( 'wooswipe-pswp', plugin_dir_url( __FILE__ ) . 'pswp/photoswipe.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'wooswipe-pswp-ui', plugin_dir_url( __FILE__ ) . 'pswp/photoswipe-ui-default.min.js', array( 'jquery', 'wooswipe-pswp' ), $this->version, true );
		wp_enqueue_script( 'wooswipe-slick', plugin_dir_url( __FILE__ ) . 'slick/slick.min.js', array( 'jquery' ), $this->version, true );

		$template_Url  = array( 'templateUrl' => $wooswipe_wp_plugin_path );
		$wooswipe_data = array(
			'addpin'         => ! empty( $options['pinterest'] ),
			'icon_bg_color'  => ! empty( $options['icon_bg_color'] ) ? $options['icon_bg_color'] : '#000000',
			'icon_stroke_color' => ! empty( $options['icon_stroke_color'] ) ? $options['icon_stroke_color'] : '#ffffff',
		);

		if ( ! empty( $options['product_main_slider'] ) ) {
			if ( ! empty( $options['product_main_slider_nav_arrow'] ) ) {
				$wooswipe_data['product_main_slider_nav_arrow'] = true;
			}
			$wooswipe_data['product_main_slider'] = true;
			wp_enqueue_script( 'wooswipe-main-image-swipe-js', plugin_dir_url( __FILE__ ) . 'js/wooswipe-main_image_swipe.js', $script_deps, $this->version, true );
			wp_localize_script( 'wooswipe-main-image-swipe-js', 'wooswipe_wp_plugin_path', $template_Url );
			wp_localize_script( 'wooswipe-main-image-swipe-js', 'wooswipe_data', $wooswipe_data );
		} else {
			$wooswipe_data['product_main_slider'] = false;
			wp_enqueue_script( 'wooswipe-js', plugin_dir_url( __FILE__ ) . 'js/wooswipe.js', $script_deps, $this->version, true );
			wp_localize_script( 'wooswipe-js', 'wooswipe_wp_plugin_path', $template_Url );
			wp_localize_script( 'wooswipe-js', 'wooswipe_data', $wooswipe_data );
		}
	}

	/**
	 * Remove theme support for WC image sizes that conflict with gallery rebuild.
	 */
	public function remove_woocommerce_theme_support() {
		remove_theme_support( 'woocommerce', array( 'thumbnail_image_width', 'gallery_thumbnail_image_width', 'single_image_width' ) );
	}

	/**
	 * Set up the theme support using wooswipe.
	 */
	public function wooswipe_theme_setup() {
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Deregister prettyPhoto scripts.
	 */
	public function wooswipe_deregister_javascript() {
		wp_deregister_script( 'prettyPhoto' );
		wp_deregister_script( 'prettyPhoto-init' );
	}

	/**
	 * Deregister prettyPhoto styles.
	 */
	public function wooswipe_deregister_styles() {
		wp_deregister_style( 'woocommerce_prettyPhoto_css' );
	}

	/**
	 * Remove default WooCommerce product images output.
	 */
	public function wooswipe_woocommerce_before_single_product_summary() {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	}

	/**
	 * Remove default WC gallery theme support so WooSwipe owns the gallery.
	 */
	public function wooswipe_remove_image_zoom_support() {
		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
		remove_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Whether an attachment should appear in the WooSwipe gallery.
	 *
	 * Checks (in order):
	 * 1. `wooswipe_include_attachment` — preferred WooSwipe-specific filter
	 * 2. `woocommerce_single_product_image_thumbnail_html` — returning '' for an
	 *    attachment ID excludes it (supports the documented “remove featured
	 *    image” snippet for both main image and thumbnails)
	 *
	 * @since 3.0.9
	 * @param int $attachment_id Attachment ID.
	 * @return bool
	 */
	public static function should_include_attachment( $attachment_id ) {
		$attachment_id = absint( $attachment_id );
		if ( ! $attachment_id ) {
			return false;
		}

		/**
		 * Filter whether WooSwipe should include an attachment in the gallery.
		 *
		 * @param bool $include       Whether to include the attachment. Default true.
		 * @param int  $attachment_id Attachment ID.
		 */
		$include = apply_filters( 'wooswipe_include_attachment', true, $attachment_id );
		if ( ! $include ) {
			return false;
		}

		// Probe the WC thumbnail filter so snippets that return '' for the
		// featured image also exclude it from the main image and image arrays.
		$html = apply_filters( 'woocommerce_single_product_image_thumbnail_html', '1', $attachment_id );
		return '' !== $html && null !== $html;
	}

	/**
	 * Single product image size name (WC 3.3+).
	 *
	 * @since 3.0.9
	 * @return string
	 */
	public static function get_single_image_size() {
		return apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_single' );
	}

	/**
	 * Gallery thumbnail image size name (WC 3.3+).
	 *
	 * @since 3.0.9
	 * @return string
	 */
	public static function get_thumbnail_image_size() {
		return apply_filters( 'single_product_small_thumbnail_size', 'woocommerce_gallery_thumbnail' );
	}

	/**
	 * Build Swiper for the Main Image.
	 *
	 * @param array $finalArray         Attachment IDs.
	 * @param array $zoomed_image_size Zoomed size.
	 */
	public function wooswipe_woocommerce_show_product_main_image_swiper( $finalArray, $zoomed_image_size ) {
		include plugin_dir_path( __FILE__ ) . 'partials/wooswipe-main_image_swiper.php';
	}

	/**
	 * Output a placeholder image.
	 */
	public function wooswipe_add_placeholder_image() {
		global $post;
		$dimensions = wc_get_image_size( 'woocommerce_single' );
		$hwstring   = image_hwstring( $dimensions['width'], $dimensions['height'] );
		$src        = esc_url( wc_placeholder_img_src() );
		$alt        = esc_attr__( 'Placeholder', 'woocommerce' );
		$html       = sprintf(
			'<img src="%s" alt="%s" class="wooswipe-placeholder single-product-main-image" data-ind="0" title="placeholder" data-title="placeholder" data-hq="%s" %s data-h="%s" data-w="%s"/>',
			$src,
			$alt,
			$src,
			$hwstring,
			esc_attr( $dimensions['height'] ),
			esc_attr( $dimensions['width'] )
		);
		echo apply_filters( 'woocommerce_single_product_image_html', $html, $post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Build gallery markup.
	 */
	public function wooswipe_woocommerce_show_product_thumbnails() {
		include plugin_dir_path( __FILE__ ) . 'partials/wooswipe-public-display.php';
		include_once plugin_dir_path( __FILE__ ) . 'partials/inc-photoswipe-footer.php';
	}

}

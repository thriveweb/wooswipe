<?php
/*
Plugin Name: WooSwipe
Plugin URI: http://thriveweb.com.au/the-lab/wooswipe/
Description: This is a image gallery plugin for WordPress built using <a href="http://photoswipe.com.au/">photoswipe</a> from Dmitry Semenov and <a href="http://kenwheeler.github.io/slick/">Slick</a> Carousel</a>.

Author: Thrive Website Design
Author URI: https://thriveweb.com.au/
Version: 1.1.8.6
Text Domain: wooswipe
*/

/*  Copyright 2018  Dean Oakley  (email : dean@thriveweb.com.au)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Illegal Entry');
}

///////////
// Backend options.
require_once(plugin_dir_path(__FILE__) . 'class-options.php');

wooswipe_plugin_options::init();

///////////
// Functions
require_once(plugin_dir_path(__FILE__) . 'inc-functions.php');

function wooswipe_using_woocommerce() {
	return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

//============================== Enque files ==============================//

function wooswipe_scripts_method() {

	$wooswipe_wp_plugin_path =  plugins_url() . '/wooswipe' ;
	$options = get_option('wooswipe_options');

	if ( is_woocommerce() && is_product() ) {
		wp_enqueue_style( 'pswp-css', $wooswipe_wp_plugin_path . '/pswp/photoswipe.css'  );

		if($options['white_theme']) wp_enqueue_style( 'white_theme', $wooswipe_wp_plugin_path . '/pswp/white-skin/skin.css'  );
		else wp_enqueue_style( 'pswp-skin', $wooswipe_wp_plugin_path . '/pswp/default-skin/default-skin.css'  );
		wp_enqueue_style( 'slick-css', $wooswipe_wp_plugin_path . '/slick/slick.css'  );
		wp_enqueue_style( 'slick-theme', $wooswipe_wp_plugin_path . '/slick/slick-theme.css'  );

		wp_enqueue_script( 'pswp', $wooswipe_wp_plugin_path . '/pswp/photoswipe.min.js', null, null, true );
		wp_enqueue_script( 'pswp-ui', $wooswipe_wp_plugin_path . '/pswp/photoswipe-ui-default.min.js', null, null, true );

		wp_enqueue_script( 'slick', $wooswipe_wp_plugin_path .'/slick/slick.min.js', null, null, true );

		wp_enqueue_style( 'wooswipe-css', $wooswipe_wp_plugin_path . '/wooswipe.css' );
		wp_enqueue_script( 'wooswipe-js', $wooswipe_wp_plugin_path .'/wooswipe.js', null, null, true );
		//after wp_enqueue_script
		$template_Url = array( 'templateUrl' => $wooswipe_wp_plugin_path );
		wp_localize_script( 'wooswipe-js', 'wooswipe_wp_plugin_path', $template_Url );
		if($options['pinterest']) {
			$pin = 'true';
		} else {
			$pin = 'false';
		}
		wp_localize_script( 'wooswipe-js', 'addpin', $pin );
	}
}
add_action('wp_enqueue_scripts', 'wooswipe_scripts_method');




function wooswipe_woocommerce_show_product_thumbnails(){
	global $post, $woocommerce, $product; ?>

	<div id="wooswipe" class="images">

		<?php
		//Hook Before Wooswipe
		do_action( 'wooswipe_before_main' );
		$zoomed_image_size = array(1920, 1080);
		if ( has_post_thumbnail() ) {
			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );

			$hq = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'wooswipe_zoomed_image_size', $zoomed_image_size ) );
			$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),
			array(
				'title' => '',
				'data-hq' => $hq[0],
				'data-w' => $hq[1],
				'data-h' => $hq[2],
			)
		);

		if (method_exists($product, 'get_gallery_image_ids')) {
			$attachment_count = count( $product->get_gallery_image_ids() );
		} else {
			$attachment_count = count( $product->get_gallery_attachment_ids() );
		}

		$gallery = $attachment_count > 0 ? '[product-gallery]' : '';

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '
		<div class="woocommerce-product-gallery__image single-product-main-image">
		<a href="%s" alt="%s" class="woocommerce-main-image zoom" >%s</a>
		</div>',
		$image_link, $image_title, $image ), $post->ID );
	} else {
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
	}

	if (method_exists($product, 'get_gallery_image_ids')) {
		$attachment_ids = $product->get_gallery_image_ids();
	} else {
		$attachment_ids = $product->get_gallery_attachment_ids();
	}

	?>
	<div class="thumbnails">
		<ul class="thumbnail-nav">
			<?php
			$productType = $product->get_type();
			$productVariation = new WC_Product_Variable( $post->ID );
			$variations = $productVariation->get_available_variations();



			if(!function_exists('addImageThumbnail')){
				function addImageThumbnail($attachment_id, $zoomed_image_size){
					global $post;
					$image       	= wp_get_attachment_image( $attachment_id, 'shop_thumbnail' );
					$hq       		= wp_get_attachment_image_src( $attachment_id, apply_filters( 'wooswipe_zoomed_image_size', $zoomed_image_size ) );
					$med       		= wp_get_attachment_image_src( $attachment_id, 'shop_single' );

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '
					<li>
					<div class="thumb" data-hq="%s" data-w="%s" data-h="%s" data-med="%s" data-medw="%s" data-medh="%s">%s</div>
					</li>',
					$hq[0], $hq[1], $hq[2], $med[0], $med[1], $med[2], $image ), $attachment_id, $post->ID );
				}
			}



			if($productType == 'variable') {

				$imagesArray = array();
				$variationArray = array();
				$featuredArray = array();

				/// add main image
				if ( has_post_thumbnail() ) {
					$featuredArray[] = get_post_thumbnail_id();
				}

				/// add gallery image
				foreach ( $attachment_ids as $attachment_id ) {
					$imagesArray[] = $attachment_id;
				}

				/// add variation image
				foreach ( $variations as $variation ) {
					$attachment_id = $variation['image_id'];
					$variationArray[] = $attachment_id;
				}

				$result = array_unique(array_merge($featuredArray,$imagesArray,$variationArray));

				$finalArray = array_values(array_filter($result));


				for($i=0;$i<count($finalArray);$i++) {
					$image_link = wp_get_attachment_url( $finalArray[$i] );
					if ( !$image_link ) { continue; }
					addImageThumbnail($finalArray[$i], $zoomed_image_size);
				}

			} else {

				/// add main image
				if ( has_post_thumbnail() ) {
					$attachment_id 	= get_post_thumbnail_id();
					addImageThumbnail($attachment_id, $zoomed_image_size);
				}

				//add thumbnails
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if ( !$image_link ) { continue; }
					addImageThumbnail($attachment_id, $zoomed_image_size);
				}
			}



			?>
		</ul>

	</div>
	<?php do_action( 'wooswipe_after_thumbs' ); ?>
	<?php
	// Hook After Wooswipe
	do_action( 'wooswipe_after_main' );?>
</div>

<?php include_once('inc-photoswipe-footer.php'); ?>

<?php
}

add_action( 'after_setup_theme', 'wooswipe_theme_setup' );

function wooswipe_theme_setup() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

}

?>

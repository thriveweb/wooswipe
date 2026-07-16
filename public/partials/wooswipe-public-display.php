<?php
/**
 * Provide a public-facing view for the plugin.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product;
$wooswipe_options = Wooswipe::get_options();
$main_slider      = ! empty( $wooswipe_options['product_main_slider'] );
$hide_thumbs_opt  = ! empty( $wooswipe_options['hide_thumbnails'] );
$remove_thumbs    = ! empty( $wooswipe_options['remove_thumb_slider'] );
?>

<div id="wooswipe" class="images">
	<input type="hidden" name="main-image-swiper" class="main-image-swiper" id="main_image_swiper" value="<?php echo esc_attr( $main_slider ? '1' : '0' ); ?>" />
	<?php
	do_action( 'wooswipe_before_main' );
	$zoomed_image_size = array( 1920, 1080 );
	$productType       = $product->get_type();
	$single_size       = Wooswipe_Public::get_single_image_size();
	$thumb_size        = Wooswipe_Public::get_thumbnail_image_size();

	$attachment_ids   = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : array();
	$attachment_ids   = is_array( $attachment_ids ) ? array_values( array_filter( array_map( 'absint', $attachment_ids ) ) ) : array();
	$attachment_count = count( $attachment_ids );

	$featured_id      = has_post_thumbnail() ? absint( get_post_thumbnail_id() ) : 0;
	// Featured may be excluded via wooswipe_include_attachment or the WC thumbnail HTML filter.
	$include_featured = $featured_id && Wooswipe_Public::should_include_attachment( $featured_id );

	/**
	 * Render a single main (non-slider) product image by attachment ID.
	 *
	 * @param int   $attachment_id     Attachment ID.
	 * @param array $zoomed_image_size Zoomed size.
	 * @param string $single_size      Image size.
	 * @return bool Whether markup was output.
	 */
	$render_main_image = function ( $attachment_id, $zoomed_image_size, $single_size ) use ( $post ) {
		$image_title = ! empty( get_the_excerpt( $attachment_id ) ) ? esc_attr( get_the_excerpt( $attachment_id ) ) : esc_attr( get_the_title( $attachment_id ) );
		$image_link  = wp_get_attachment_url( $attachment_id );
		$alt         = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		$alt         = ! empty( $alt ) ? esc_attr( $alt ) : esc_attr( get_the_title( $attachment_id ) );
		$hq          = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wooswipe_zoomed_image_size', $zoomed_image_size ) );

		if ( ! $image_link || empty( $hq ) ) {
			return false;
		}

		$image = wp_get_attachment_image(
			$attachment_id,
			$single_size,
			false,
			array(
				'title'   => $image_title,
				'data-hq' => $hq[0],
				'data-w'  => $hq[1],
				'data-h'  => $hq[2],
				'loading' => false,
				'alt'     => $alt,
				'class'   => 'wp-post-image',
			)
		);

		$html = sprintf(
			'<div class="woocommerce-product-gallery__image single-product-main-image">
				<a href="%s" class="woocommerce-main-image zoom">%s</a>
			</div>',
			esc_url( $image_link ),
			$image
		);
		echo apply_filters( 'woocommerce_single_product_image_html', $html, $post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return true;
	};

	if ( ! $main_slider ) {
		$rendered = false;
		if ( $include_featured ) {
			$rendered = $render_main_image( $featured_id, $zoomed_image_size, $single_size );
		} elseif ( ! empty( $attachment_ids ) ) {
			// Featured excluded — fall back to the first includable gallery image.
			foreach ( $attachment_ids as $gallery_id ) {
				if ( Wooswipe_Public::should_include_attachment( $gallery_id ) ) {
					$rendered = $render_main_image( $gallery_id, $zoomed_image_size, $single_size );
					if ( $rendered ) {
						break;
					}
				}
			}
		}
		if ( ! $rendered ) {
			$this->wooswipe_add_placeholder_image();
		}
	}

	if ( ! function_exists( 'addImageThumbnail' ) ) {
		/**
		 * Output a thumbnail list item.
		 *
		 * @param int    $attachment_id     Attachment ID.
		 * @param int    $slideno           Slide index.
		 * @param array  $zoomed_image_size Zoom size.
		 * @param string $single_size       Single image size.
		 * @param string $thumb_size        Thumbnail size.
		 */
		function addImageThumbnail( $attachment_id, $slideno, $zoomed_image_size, $single_size = 'woocommerce_single', $thumb_size = 'woocommerce_gallery_thumbnail' ) {
			global $post;

			if ( ! Wooswipe_Public::should_include_attachment( $attachment_id ) ) {
				return;
			}

			$hq          = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wooswipe_zoomed_image_size', $zoomed_image_size ) );
			$med         = wp_get_attachment_image_src( $attachment_id, $single_size );
			$sizes       = wp_get_attachment_image_sizes( $attachment_id, $single_size );
			$image_title = ! empty( get_the_excerpt( $attachment_id ) ) ? esc_attr( get_the_excerpt( $attachment_id ) ) : esc_attr( get_the_title( $attachment_id ) );
			$alt         = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
			$alt         = ! empty( $alt ) ? esc_attr( $alt ) : esc_attr( get_the_title( $attachment_id ) );

			if ( empty( $hq ) || empty( $med ) ) {
				return;
			}

			$image = wp_get_attachment_image(
				$attachment_id,
				$thumb_size,
				false,
				array(
					'title'   => $image_title,
					'loading' => false,
					'alt'     => $alt,
					'sizes'   => $sizes,
					'width'   => '100',
					'height'  => '100',
				)
			);

			$html  = '<li>';
			$html .= sprintf(
				'<div class="thumb" data-hq="%s" data-w="%s" data-h="%s" data-med="%s" data-medw="%s" data-medh="%s" data-attachment_id="main_image_%s" data-slide="%s">%s</div>',
				esc_url( $hq[0] ),
				esc_attr( $hq[1] ),
				esc_attr( $hq[2] ),
				esc_url( $med[0] ),
				esc_attr( $med[1] ),
				esc_attr( $med[2] ),
				esc_attr( $attachment_id ),
				esc_attr( $slideno ),
				$image
			);
			$html .= '</li>';

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id, $post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Build ordered gallery image IDs, respecting exclude filters.
	 *
	 * @param int   $featured_id      Featured attachment ID.
	 * @param bool  $include_featured Whether featured is allowed.
	 * @param array $attachment_ids   Gallery attachment IDs.
	 * @param array $variations       Variation data.
	 * @return array
	 */
	$build_image_ids = function ( $featured_id, $include_featured, $attachment_ids, $variations = array() ) {
		$allImages = array();

		if ( $include_featured && $featured_id ) {
			$allImages[] = $featured_id;
		}

		foreach ( $attachment_ids as $attachment_id ) {
			if ( Wooswipe_Public::should_include_attachment( $attachment_id ) ) {
				$allImages[] = $attachment_id;
			}
		}

		foreach ( $variations as $variation ) {
			$attachment_id = ! empty( $variation['image_id'] ) ? absint( $variation['image_id'] ) : 0;
			if ( $attachment_id && Wooswipe_Public::should_include_attachment( $attachment_id ) ) {
				$allImages[] = $attachment_id;
			}
		}

		return array_values( array_unique( array_filter( $allImages ) ) );
	};

	$variations = array();
	if ( 'variable' === $productType && $product instanceof WC_Product_Variable ) {
		$variations = $product->get_available_variations();
	}

	$finalArray = $build_image_ids( $featured_id, $include_featured, $attachment_ids, $variations );

	if ( $main_slider ) {
		if ( ! empty( $finalArray ) ) {
			$this->wooswipe_woocommerce_show_product_main_image_swiper( $finalArray, $zoomed_image_size );
		} else {
			$this->wooswipe_add_placeholder_image();
		}
	}

	$show_thumbnails = ( count( $finalArray ) > 1 ) || ! $hide_thumbs_opt;
	if ( $show_thumbnails ) :
		// remove_thumb_slider hides via CSS but keeps markup for JS that expects .thumbnails.
		$thumb_style = $remove_thumbs ? ' style="display:none"' : '';
		?>
		<div class="thumbnails"<?php echo $thumb_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<ul class="thumbnail-nav">
				<?php
				foreach ( $finalArray as $i => $attachment_id ) {
					if ( ! wp_get_attachment_url( $attachment_id ) ) {
						continue;
					}
					addImageThumbnail( $attachment_id, $i, $zoomed_image_size, $single_size, $thumb_size );
				}
				?>
			</ul>
		</div>
	<?php
	endif;

	do_action( 'wooswipe_after_thumbs' );
	do_action( 'wooswipe_after_main' );
	?>
</div>

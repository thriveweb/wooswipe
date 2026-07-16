<?php
/**
 * Main image swiper markup.
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

$single_size = Wooswipe_Public::get_single_image_size();
?>
<div class="single-product-main-image-wrap">
	<input type="hidden" class="woocommerce-product-gallery__image" value="none" />
	<ul class="single-product-main-image single-product-main-image-ul">
		<?php
		foreach ( $finalArray as $i => $attachment_id ) {
			global $post;
			$image_link  = wp_get_attachment_url( $attachment_id );
			$image_title = ! empty( get_the_excerpt( $attachment_id ) ) ? get_the_excerpt( $attachment_id ) : get_the_title( $attachment_id );
			$alt         = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
			$alt         = ! empty( $alt ) ? $alt : get_the_title( $attachment_id );
			$med         = wp_get_attachment_image_src( $attachment_id, $single_size );
			$hq          = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wooswipe_zoomed_image_size', $zoomed_image_size ) );
			$sizes       = wp_get_attachment_image_sizes( $attachment_id, $single_size );

			if ( ! $image_link || empty( $hq ) || empty( $med ) ) {
				continue;
			}

			$image = wp_get_attachment_image(
				$attachment_id,
				$single_size,
				false,
				array(
					'title'     => esc_attr( $image_title ),
					'data-hq'   => $hq[0],
					'data-w'    => $hq[1],
					'data-h'    => $hq[2],
					'loading'   => false,
					'alt'       => esc_attr( $alt ),
					'sizes'     => $sizes,
					'id'        => 'main_image_' . $attachment_id,
					'data-ind'  => $i,
				)
			);

			$main_img_slider_html = sprintf(
				'<li>
					<a href="%1$s" alt="%2$s" data-hq="%3$s" data-w="%4$s" data-h="%5$s" data-med="%6$s" data-medw="%7$s" data-medh="%8$s" class="woocommerce-main-image zoom thumb-big">%9$s</a>
				</li>',
				'javascript:void(0);',
				esc_attr( $alt ),
				esc_url( $hq[0] ),
				esc_attr( $hq[1] ),
				esc_attr( $hq[2] ),
				esc_url( $med[0] ),
				esc_attr( $med[1] ),
				esc_attr( $med[2] ),
				$image
			);
			echo apply_filters( 'woocommerce_single_product_image_html', $main_img_slider_html, $attachment_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</ul>
</div>

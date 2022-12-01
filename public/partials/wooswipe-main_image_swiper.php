<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/public/partials
 */
?>
<div class="single-product-main-image-wrap">
    <input type="hidden" class="woocommerce-product-gallery__image" value="none" />
    <ul class="single-product-main-image single-product-main-image-ul">
        <?php

        for ($i = 0; $i < count($finalArray); $i++) {
            global $post;
            $image_link     = wp_get_attachment_url($finalArray[$i]);
            $image_title    = !empty(get_the_excerpt($finalArray[$i])) ? get_the_excerpt($finalArray[$i]) : esc_attr(get_the_title($finalArray[$i]));
            $alt            = get_post_meta($finalArray[$i], '_wp_attachment_image_alt', true);
            $alt            = !empty($alt) ? esc_attr($alt) : esc_attr(get_the_title($finalArray[$i]));
            $med            = wp_get_attachment_image_src($finalArray[$i], 'shop_single');
            $hq             = wp_get_attachment_image_src($finalArray[$i], apply_filters('wooswipe_zoomed_image_size', $zoomed_image_size));
            $sizes          = wp_get_attachment_image_sizes($finalArray[$i], 'shop_single');
            $image          = wp_get_attachment_image(
                $finalArray[$i],
                'shop_single',
                false,
                array(
                    'title'     => $image_title,
                    'data-hq'   => $hq[0],
                    'data-w'    => $hq[1],
                    'data-h'    => $hq[2],
                    'loading'   => false,
                    'alt'       => $alt,
                    'sizes'     => $sizes,
                    'id'        => "main_image_" . $finalArray[$i],
                    "data-ind"  => $i
                )
            );

            if (!$image_link) {
                continue;
            }
            $main_img_slider_html = sprintf(
                '<li>
                        <a href="%s"  alt="%s" data-hq="%s" data-w="%s" data-h="%s" data-med="%s" data-medw="%s" data-medh="%s" class="woocommerce-main-image zoom thumb-big" >%s</a>
                    </li>',
                "javaScript:void(0);",
                $alt,
                $hq[0],
                $hq[1],
                $hq[2],
                $med[0],
                $med[1],
                $med[2],
                $image
            );
            echo apply_filters('woocommerce_single_product_image_html', $main_img_slider_html, $finalArray[$i]);
        }
        ?>
    </ul>
</div>
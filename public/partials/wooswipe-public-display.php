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
global $post, $woocommerce, $product;
$wooswipe_options = get_option('wooswipe_options');
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="wooswipe" class="images">
    <input type="hidden" name="main-image-swiper" class="main-image-swiper" id="main_image_swiper" value="<?php esc_attr_e($wooswipe_options['product_main_slider'] == false ? 0 : 1); ?>" />
    <?php
    //Hook Before Wooswipe
    do_action('wooswipe_before_main');
    $zoomed_image_size = array(1920, 1080);
    $attachment_count = 0;
    $productType = $product->get_type();

    if (method_exists($product, 'get_gallery_image_ids')) {
        $attachment_count = count($product->get_gallery_image_ids());
    } else {
        $attachment_count = count($product->get_gallery_image_ids());
    }

    if (has_post_thumbnail()) {
        $thumbnail_id   = get_post_thumbnail_id();
        $image_title    = !empty(get_the_excerpt($thumbnail_id)) ? esc_attr(get_the_excerpt($thumbnail_id)) : esc_attr(get_the_title($thumbnail_id));
        $image_link     = wp_get_attachment_url($thumbnail_id);
        $alt    = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
        $alt    = !empty($alt) ? $alt : esc_attr(get_the_title($thumbnail_id));
        $hq     = wp_get_attachment_image_src($thumbnail_id, apply_filters('wooswipe_zoomed_image_size', $zoomed_image_size));

        $image  = get_the_post_thumbnail(
            $post->ID,
            apply_filters('single_product_large_thumbnail_size', 'shop_single'),
            array(
                'title'     => $image_title,
                'data-hq'   => $hq[0],
                'data-w'    => $hq[1],
                'data-h'    => $hq[2],
                'loading'   => false,
                'alt'       => $alt,
            )
        );

        $gallery = $attachment_count > 0 ? '[product-gallery]' : '';

        if ($wooswipe_options['product_main_slider'] == false) :
            $html = sprintf(
                '
                    <div class="woocommerce-product-gallery__image single-product-main-image">
                    <a href="%s" class="woocommerce-main-image zoom" >%s</a>
                </div>',
                $image_link,
                $image
            );
            echo apply_filters('woocommerce_single_product_image_html', $html, $post->ID);
        endif;
    } elseif ($wooswipe_options['product_main_slider'] == false) {
        $this->wooswipe_add_placeholder_image();
    }

    if (method_exists($product, 'get_gallery_image_ids')) {
        $attachment_ids = $product->get_gallery_image_ids();
    } else {
        $attachment_ids = $product->get_gallery_image_ids();
    }

    /* Build Thumbnails */
    $productVariation = new WC_Product_Variable($post->ID);
    $variations = $productVariation->get_available_variations();

    if (!function_exists('addImageThumbnail')) {
        function addImageThumbnail($attachment_id, $slideno, $zoomed_image_size)
        {
            global $post;
            $hq                 = wp_get_attachment_image_src($attachment_id, apply_filters('wooswipe_zoomed_image_size', $zoomed_image_size));
            $med                = wp_get_attachment_image_src($attachment_id, 'shop_single');
            $srcset             = wp_get_attachment_image_srcset($attachment_id);
            $sizes              = wp_get_attachment_image_sizes($attachment_id, 'shop_single');
            $image_title        = !empty(get_the_excerpt($attachment_id)) ? esc_attr(get_the_excerpt($attachment_id)) : esc_attr(get_the_title($attachment_id));
            $alt                = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            $alt                = !empty($alt) ? esc_attr($alt) : esc_attr(get_the_title($attachment_id));
            $image           = wp_get_attachment_image(
                $attachment_id,
                'shop_thumbnail',
                false,
                array(
                    'title'     => $image_title,
                    'loading'   => false,
                    'alt'       => $alt,
                    'sizes'     => $sizes,
                    'width'     => '100',
                    'height'    => '100'
                )
            );



            $html = sprintf('<li>');
            $html .= sprintf(
                '<div class="thumb" data-hq="%s" data-w="%s" data-h="%s" data-med="%s" data-medw="%s" data-medh="%s" data-attachment_id="main_image_%s" data-slide="%s">%s</div>',
                $hq[0],
                $hq[1],
                $hq[2],
                $med[0],
                $med[1],
                $med[2],
                $attachment_id,
                $slideno,
                $image
            );
            $html .= sprintf('</li>');

            echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $attachment_id, $post->ID);
        }
    }

    $hide_thumb_css = ($wooswipe_options['remove_thumb_slider'] == 1)  ? "style=display:none;" : "";

    if ($productType == 'variable') {
        $imagesArray = array();
        $variationArray = array();
        $featuredArray = array();
        $allImages = array();
        $finalArray = array();

        // add main image
        if (has_post_thumbnail()) {
            $featuredArray[] = get_post_thumbnail_id();
            array_push($allImages, $featuredArray[0]);
        }

        // add gallery image
        if (!empty($attachment_ids) && isset($attachment_ids)) {
            foreach ($attachment_ids as $attachment_id) {
                $imagesArray[] = $attachment_id;
                array_push($allImages, $attachment_id);
            }
        }

        // add variation image
        if (!empty($variations) && isset($variations)) {
            foreach ($variations as $variation) {
                $attachment_id = $variation['image_id'];
                $variationArray[] = $attachment_id;
                array_push($allImages, $attachment_id);
            }
        }

        if (!empty($allImages)) {
            $result = array_unique($allImages);
            $finalArray = array_values(array_filter($result));
        }

        if ($wooswipe_options['product_main_slider'] == true && (!empty($finalArray) && isset($finalArray))) :

            $this->wooswipe_woocommerce_show_product_main_image_swiper($finalArray, $zoomed_image_size);

        elseif ($wooswipe_options['product_main_slider'] == true && (empty($finalArray) && isset($finalArray))) :

            $this->wooswipe_add_placeholder_image();

        endif;

        if (count($finalArray) > 1 || !$wooswipe_options['hide_thumbnails']) {
    ?>
            <div class="thumbnails" <?php esc_attr_e($hide_thumb_css); ?>>
                <ul class="thumbnail-nav">
                    <?php for ($i = 0; $i < count($finalArray); $i++) {
                        $image_link = wp_get_attachment_url($finalArray[$i]);
                        if (!$image_link) {
                            continue;
                        }
                        addImageThumbnail($finalArray[$i], $i, $zoomed_image_size);
                    } ?>
                </ul>
            </div>
        <?php }
    } else {
        $featuredArray = array();
        $allImages = array();
        $finalArray = array();
        // add main image
        if (has_post_thumbnail()) {
            $featuredArray[] = get_post_thumbnail_id();
            array_push($allImages, $featuredArray[0]);
        }

        // add gallery image
        if (!empty($attachment_ids) && isset($attachment_ids)) {
            foreach ($attachment_ids as $attachment_id) {
                $imagesArray[] = $attachment_id;
                array_push($allImages, $attachment_id);
            }
        }

        if (!empty($allImages) && isset($allImages)) {
            $result = array_unique($allImages);
            $finalArray = array_values(array_filter($result));
        }

        if ($wooswipe_options['product_main_slider'] == true && (!empty($finalArray) && isset($finalArray))) :
            $this->wooswipe_woocommerce_show_product_main_image_swiper($finalArray, $zoomed_image_size);
        elseif ($wooswipe_options['product_main_slider'] == true && (empty($finalArray) && isset($finalArray))) :
            $this->wooswipe_add_placeholder_image();
        endif;

        if ($attachment_count > 0 || !$wooswipe_options['hide_thumbnails']) { ?>
            <div class="thumbnails" <?php esc_attr_e($hide_thumb_css); ?>>
                <ul class="thumbnail-nav">
                    <?php
                    // add main image
                    if (has_post_thumbnail()) {
                        $i = 0;
                        $attachment_id     = get_post_thumbnail_id();
                        addImageThumbnail($attachment_id, $i, $zoomed_image_size);
                    }

                    // add thumbnails
                    foreach ($attachment_ids as $key => $attachment_id) {
                        $image_link = wp_get_attachment_url($attachment_id);
                        if (!$image_link) continue;
                        addImageThumbnail($attachment_id, $key + 1, $zoomed_image_size);
                    } ?>
                </ul>
            </div>
    <?php }
    }
    do_action('wooswipe_after_thumbs');
    do_action('wooswipe_after_main');
    ?>
</div>
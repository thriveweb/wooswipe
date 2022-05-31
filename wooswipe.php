<?php
/*
Plugin Name: WooSwipe
Plugin URI: http://thriveweb.com.au/the-lab/wooswipe/
Description: This is a image gallery plugin for WordPress built using <a href="http://photoswipe.com.au/">photoswipe</a> from Dmitry Semenov and <a href="http://kenwheeler.github.io/slick/">Slick</a> Carousel</a>.

Author: Thrive Website Design
Author URI: https://thriveweb.com.au/
Version: 1.1.13
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

if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die('Illegal Entry');

remove_theme_support('woocommerce', array('thumbnail_image_width', 'gallery_thumbnail_image_width', 'single_image_width'));

// Backend options
require_once(plugin_dir_path(__FILE__) . 'class-options.php');

wooswipe_plugin_options::init();

// Functions
require_once(plugin_dir_path(__FILE__) . 'inc-functions.php');

function wooswipe_using_woocommerce()
{
    return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
}



/*--------------------------------------------------------------
Enqueue Scripts
--------------------------------------------------------------*/
function wooswipe_scripts_method()
{

    $wooswipe_wp_plugin_path =  plugins_url() . '/wooswipe';
    $options = get_option('wooswipe_options');

    if ((is_woocommerce() && is_product()) || wc_post_content_has_shortcode('product_page')) {
        wp_enqueue_style('wooswipe-pswp-css', $wooswipe_wp_plugin_path . '/pswp/photoswipe.css');

        if ($options['white_theme']) wp_enqueue_style('white_theme', $wooswipe_wp_plugin_path . '/pswp/white-skin/skin.css');
        else wp_enqueue_style('pswp-skin', $wooswipe_wp_plugin_path . '/pswp/default-skin/default-skin.css');
        wp_enqueue_style('wooswipe-slick-css', $wooswipe_wp_plugin_path . '/slick/slick.css');
        wp_enqueue_style('wooswipe-slick-theme', $wooswipe_wp_plugin_path . '/slick/slick-theme.css');

        wp_enqueue_script('wooswipe-pswp', $wooswipe_wp_plugin_path . '/pswp/photoswipe.min.js', null, null, true);
        wp_enqueue_script('wooswipe-pswp-ui', $wooswipe_wp_plugin_path . '/pswp/photoswipe-ui-default.min.js', null, null, true);

        wp_enqueue_script('wooswipe-slick', $wooswipe_wp_plugin_path . '/slick/slick.min.js', null, null, true);

        wp_enqueue_style('wooswipe-css', $wooswipe_wp_plugin_path . '/wooswipe.css');


        //after wp_enqueue_script
        $template_Url = array('templateUrl' => $wooswipe_wp_plugin_path);
        $wooswipe_data = array();
        if ($options['pinterest']) {
            $wooswipe_data = array('addpin' => true);
        } else {
            $wooswipe_data = array('addpin' => false);
        }

        if (!empty($options['icon_bg_color'])) {
            $wooswipe_data['icon_bg_color'] = $options['icon_bg_color'];
        } else {
            $wooswipe_data['icon_bg_color'] = '#000000';
        }

        if (!empty($options['icon_stroke_color'])) {
            $wooswipe_data['icon_stroke_color'] = $options['icon_stroke_color'];
        } else {
            $wooswipe_data['icon_stroke_color'] = '#ffffff';
        }

        
        if ($options['product_main_slider'] == true) {
            if ($options['product_main_slider_nav_arrow'] == true) {
                $wooswipe_data['product_main_slider_nav_arrow'] = true;
            }
            $wooswipe_data['product_main_slider'] =  true;
            wp_enqueue_script('wooswipe-main-image-swipe-js', $wooswipe_wp_plugin_path . '/wooswipe-main_image_swipe.js', null, null, true);
            wp_localize_script('wooswipe-main-image-swipe-js', 'wooswipe_wp_plugin_path', $template_Url);
            wp_localize_script('wooswipe-main-image-swipe-js', 'wooswipe_data', $wooswipe_data);
        } else {
            $wooswipe_data['product_main_slider'] =  false;
            wp_enqueue_script('wooswipe-js', $wooswipe_wp_plugin_path . '/wooswipe.js', null, null, true);
            wp_localize_script('wooswipe-js', 'wooswipe_wp_plugin_path', $template_Url);
            wp_localize_script('wooswipe-js', 'wooswipe_data', $wooswipe_data);
        }
    }
}
add_action('wp_enqueue_scripts', 'wooswipe_scripts_method');



/*--------------------------------------------------------------
Build Swiper
--------------------------------------------------------------*/
function wooswipe_woocommerce_show_product_thumbnails()
{
    global $post, $woocommerce, $product;
    $wooswipe_options = get_option('wooswipe_options'); ?>

    <div id="wooswipe" class="images">
        <input type="hidden" name="main-image-swiper" class="main-image-swiper" id="main_image_swiper" value="<?php esc_attr_e($wooswipe_options['product_main_slider'] == false ? 0 : 1); ?>" />
        <?php
        //Hook Before Wooswipe
        do_action('wooswipe_before_main');
        $zoomed_image_size = array(1920, 1080);
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

            if (method_exists($product, 'get_gallery_image_ids')) {
                $attachment_count = count($product->get_gallery_image_ids());
            } else {
                $attachment_count = count($product->get_gallery_image_ids());
            }

            $gallery = $attachment_count > 0 ? '[product-gallery]' : '';

            if ($wooswipe_options['product_main_slider'] == false) :
                $html = sprintf(
                    '
                    <div class="woocommerce-product-gallery__image single-product-main-image 123">
                    <a href="%s" class="woocommerce-main-image zoom" >%s</a>
                </div>',
                    $image_link,
                    $image
                );
                echo apply_filters('woocommerce_single_product_image_html', $html, $post->ID);
            endif;
        } else {
            $html = sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), __('Placeholder', 'woocommerce'));
            echo apply_filters('woocommerce_single_product_image_html', $html, $post->ID);
        }

        if (method_exists($product, 'get_gallery_image_ids')) {
            $attachment_ids = $product->get_gallery_image_ids();
        } else {
            $attachment_ids = $product->get_gallery_image_ids();
        }

        /* Build Thumbnails */
        $productType = $product->get_type();
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



                $html = "<li>";
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
                $html .= "</li>";

                echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $attachment_id, $post->ID);
            }
        }

        $hide_thumb_css = ($wooswipe_options['remove_thumb_slider'] == 1)  ? "style=display:none;" : "";

        if ($productType == 'variable') {
            $imagesArray = array();
            $variationArray = array();
            $featuredArray = array();

            // add main image
            if (has_post_thumbnail()) {
                $featuredArray[] = get_post_thumbnail_id();
            }

            // add gallery image
            foreach ($attachment_ids as $attachment_id) {
                $imagesArray[] = $attachment_id;
            }

            // add variation image
            foreach ($variations as $variation) {
                $attachment_id = $variation['image_id'];
                $variationArray[] = $attachment_id;
            }

            $result = array_unique(array_merge($featuredArray, $imagesArray, $variationArray));
            $finalArray = array_values(array_filter($result));
            if ($wooswipe_options['product_main_slider'] == true) :

                ob_start();
                wooswipe_woocommerce_show_product_main_image_swiper($finalArray, $zoomed_image_size);
                echo ob_get_clean();

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
            // add main image
            if (has_post_thumbnail()) {
                $featuredArray[] = get_post_thumbnail_id();
            }
            $result = array_unique(array_merge($featuredArray, $attachment_ids));

            $finalArray = array_values(array_filter($result));

            if ($wooswipe_options['product_main_slider'] == true) :
                ob_start();
                wooswipe_woocommerce_show_product_main_image_swiper($finalArray, $zoomed_image_size);
                echo ob_get_clean();
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

<?php include_once('inc-photoswipe-footer.php');
}

/**
 * Build Swiper for the Main Image
 */
function wooswipe_woocommerce_show_product_main_image_swiper($finalArray, $zoomed_image_size)
{

?>
    <div class="single-product-main-image-wrap">
        <input type="hidden" class="woocommerce-product-gallery__image" value="none" />
        <ul class="single-product-main-image">
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
                echo apply_filters('woocommerce_single_product_image_html', $main_img_slider_html , $finalArray[$i]);
            }
            ?>
        </ul>
    </div>
<?php

}

function wooswipe_theme_setup()
{
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'wooswipe_theme_setup'); ?>
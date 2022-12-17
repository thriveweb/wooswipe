<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://thriveweb.com.au/
 * @since      1.0.0
 *
 * @package    Wooswipe
 * @subpackage Wooswipe/admin/partials
 */
$options = get_option('wooswipe_options');
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="wooswipe_admin" class="wrap">
    <div class="wooswipe_admin-main">
        <h1><?php _e( 'WooSwipe Options', 'wooswipe' ); ?></h1>

        <p><?php _e( 'WooSwipe is a ', 'wooswipe' ); ?><a target="_blank" rel="noreferrer" href="<?php echo esc_url('https://wordpress.org/plugins/wooswipe/'); ?>"><?php _e( 'WooCommerce gallery plugin for WordPress', 'wooswipe' ); ?></a> <?php _e( 'built using Photoswipe from  Dmitry Semenov.', 'wooswipe' ); ?> <a href="<?php echo esc_url('http://photoswipe.com/'); ?>"><?php _e( 'Photoswipe', 'wooswipe' ); ?></a> <?php _e( 'and ', 'wooswipe' ); ?><a href="<?php echo esc_url('http://kenwheeler.github.io/slick/'); ?>"> <?php _e( 'Slick', 'wooswipe' ); ?></a> </p>

        <p><?php _e( 'You can edit your thumbnail image sizes in ', 'wooswipe' ); ?><b><?php _e( 'Appearance › Customize › WooCommerce › Product Images', 'wooswipe' ); ?></b> <?php _e( "unless your theme registers it's own sizes.", 'wooswipe' ); ?></a></p>

        <p style="font-style:italic; font-weight:normal; color:grey " ><?php _e( 'Please note: Images that are already on the server will not change size until you regenerate the thumbnails. Use ', 'wooswipe' ); ?><a title="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" href="<?php echo esc_url('http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/'); ?>"><?php _e( 'AJAX thumbnail rebuild', 'wooswipe' ); ?></a> </p>

        <form method="post" action="#" enctype="multipart/form-data">
            <?php wp_nonce_field( 'wooswipe_nonce_action', 'wooswipe_nonce_field' );?>
            <div class="ps_border" ></div>
            <p><label><input name="white_theme" type="checkbox" value="<?php esc_attr_e(!empty($options['white_theme']) ? $options['white_theme'] : '' ); ?>" <?php if($options['white_theme']) _e("checked='checked'"); ?> /> <?php _e( 'Use white theme?', 'wooswipe' ); ?></label></p>
            
            <div class="ps_border" ></div>
            <p><label><input name="pinterest" type="checkbox" value="<?php esc_attr_e(!empty($options['pinterest']) ? $options['pinterest'] : '' ); ?>" <?php if($options['pinterest']) _e("checked='checked'"); ?> /> <?php _e( 'Add Pinterest link?', 'wooswipe' ); ?></label></p>

            <div class="ps_border" ></div>
            <p><label><input name="hide_thumbnails" type="checkbox" value="<?php esc_attr_e(!empty($options['hide_thumbnails']) ? $options['hide_thumbnails'] : '' ); ?>" <?php if($options['hide_thumbnails']) _e("checked='checked'"); ?> /> <?php _e( 'Hide thumbnails if there are no product gallery or variation images.', 'wooswipe' ); ?></label></p>

            <div class="ps_border" ></div>
            <p><label><input name="product_main_slider" type="checkbox" value="<?php esc_attr_e(!empty($options['product_main_slider']) ? $options['product_main_slider'] : '' ); ?>" id="product_main_slider" <?php if($options['product_main_slider']) _e("checked='checked'"); ?> /> <?php _e( 'Add slider to Product main Image?', 'wooswipe' ); ?></label></p>

            <?php 
            $display_style="";
            if($options['product_main_slider']):
                $display_style = " ";
            else:
                $display_style = "display:none;";
            endif;
            ?>
            <div class="ps_border" ></div>
            <p class="main_slide_nav" style="<?php _e($display_style); ?>"><label><input name="product_main_slider_nav_arrow" id="product_main_slider_nav_arrow" type="checkbox" value="<?php esc_attr_e(!empty($options['product_main_slider_nav_arrow']) ? $options['product_main_slider_nav_arrow'] : '' ); ?>" <?php if($options['product_main_slider_nav_arrow']) _e("checked='checked'"); ?> /> <?php _e( 'Add navigation arrows to the Product main image slider?', 'wooswipe' ); ?></label></p>
            
            <div class="ps_border" ></div>
            <p><label><input name="remove_thumb_slider" type="checkbox" value="checkbox" <?php if($options['remove_thumb_slider']) _e("checked='checked'"); ?> /> <?php _e( 'Remove thumbnail slider completely?', 'wooswipe' ); ?></label></p>
            
            <div class="icon_color_opt">
                <div class="icon_color_inputs">
                    <div class="ps_border" ></div>
                    <p><label><input type="color" id="icon_bg_color" name="icon_bg_color" value="<?php esc_attr_e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#000000" ); ?>"> <?php _e( 'Choose icon background color', 'wooswipe' ); ?></label></p>

                    <div class="ps_border" ></div>
                    <p><label><input type="color" id="icon_stroke_color" name="icon_stroke_color" value="<?php esc_attr_e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"> <?php _e( 'Choose icon stroke color', 'wooswipe' ); ?></label></p>
                </div>
                <div class="icons-preview">
                    <span><?php _e( 'Icon Preview', 'wooswipe' ); ?></span>
                    <ul class="icons-preview-list">
                    <li><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33" height="33" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 51 51" style="enable-background:new 0 0 51 51;" xml:space="preserve"><circle id="Ellipse_1" data-name="Ellipse 1" cx="25.5" cy="25.5" r="25" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>"></circle><path d="M37.4,20.3c0.8,0,1.3-0.6,1.3-1.3v-5.3c0-0.1,0-0.4-0.2-0.6c-0.2-0.3-0.4-0.6-0.8-0.8c-0.2-0.1-0.4-0.1-0.6-0.1h-5.3  c-0.8,0-1.3,0.6-1.3,1.3c0,0.8,0.6,1.3,1.3,1.3h2.2l-8.6,8.6l-8.6-8.6H19c0.8,0,1.3-0.6,1.3-1.3s-0.6-1.3-1.3-1.3h-5.3  c-0.1,0-0.4,0-0.6,0.1c-0.3,0.2-0.6,0.5-0.8,0.8c-0.1,0.2-0.1,0.5-0.1,0.6V19c0,0.8,0.6,1.3,1.3,1.3s1.3-0.6,1.3-1.3v-2.2l8.6,8.6  l-8.6,8.6v-2.2c0-0.8-0.6-1.3-1.3-1.3c-0.8,0-1.3,0.6-1.3,1.3v5.3c0,0.2,0,0.4,0.1,0.6c0.1,0.3,0.4,0.6,0.8,0.8  c0.2,0.2,0.5,0.2,0.6,0.2H19c0.8,0,1.3-0.6,1.3-1.3c0-0.8-0.6-1.3-1.3-1.3h-2.2l8.6-8.6l8.6,8.6h-2.2c-0.8,0-1.3,0.6-1.3,1.3  c0,0.8,0.6,1.3,1.3,1.3h5.3c0.2,0,0.4,0,0.6-0.2c0.3-0.2,0.6-0.4,0.8-0.8c0.2-0.2,0.2-0.4,0.2-0.6v-5.3c0-0.8-0.6-1.3-1.3-1.3  c-0.8,0-1.3,0.6-1.3,1.3v2.2l-8.6-8.6l8.5-8.6V19C36,19.9,36.5,20.3,37.4,20.3z" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"></path></svg></li>
                        <li class="nav-left"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_2" data-name="Ellipse 2" cx="40" cy="40" r="40" transform="translate(977 529)" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"/></g></svg></li>
                        <li class="nav-right"><svg xmlns="http://www.w3.org/2000/svg" id="right" width="33" height="33" viewBox="0 0 80 80"><circle id="Ellipse_3" data-name="Ellipse 2" cx="40" cy="40" r="40" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>" /><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M26.387,21.735,7.965,3.314a2.275,2.275,0,0,0-3.217,0L2.6,5.463a2.275,2.275,0,0,0,0,3.213L17.2,23.344,2.6,38.012a2.274,2.274,0,0,0,0,3.213l2.149,2.149a2.275,2.275,0,0,0,3.217,0L26.387,24.952A2.275,2.275,0,0,0,26.387,21.735Z" transform="translate(24.947 16.352)" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"/></svg></li>
                    </ul>
                </div>
            </div>

            <div class="ps_border" ></div>
          
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
            
        </form>
        <p><?php _e( 'WooSwipe built by', 'wooswipe' ); ?> <a target="_blank" rel="noreferrer" href="<?php echo esc_url('https://thriveweb.com.au'); ?>"><?php _e( 'Thrive Digital', 'wooswipe' ); ?></a>
        </p>
    </div>
    
</div>
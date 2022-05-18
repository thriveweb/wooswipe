<?php
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die('Illegal Entry');

// Admin CSS
function wooswipe_register_head() {
    $url = plugins_url( 'admin.css', __FILE__ );
    $jsurl = plugins_url( 'admin.js', __FILE__ );
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    echo "<script type='text/javaScript' src='$jsurl' id='wooswipe-adminjs'></script>\n";

}
add_action('admin_head', 'wooswipe_register_head');



/*--------------------------------------------------------------
WooSwipe Options
--------------------------------------------------------------*/
class wooswipe_plugin_options {

	public static function init() {
		// register functions
		add_action('admin_menu', array('wooswipe_plugin_options', 'update'));
        wooswipe_plugin_options::WooSwipe_getOptions();
	}

    // Defaults
    public static function WooSwipe_getOptions() {
        // Pull from WP options database table
        $options = get_option('wooswipe_options');
        if (!is_array($options)) {
            $options['white_theme'] = false;
            $options['pinterest'] = false;
            $options['hide_thumbnails'] = false;
            $options['remove_thumb_slider'] = false;
            $options['product_main_slider'] = false;
            $options['product_main_slider_nav_arrow'] = false;
            $options['icon_bg_color'] = "#000000";
            $options['icon_stroke_color'] = "#ffffff";
            update_option('wooswipe_options', $options);
        } else {
            if(!isset($options['white_theme'])) {
                $options['white_theme'] = false;
            }
            if(!isset($options['pinterest'])) {
                $options['pinterest'] = false;
            }
            if(!isset($options['hide_thumbnails'])) {
                $options['hide_thumbnails'] = false;
            }
            if(!isset($options['product_main_slider'])) {
                $options['product_main_slider'] = false;
            }
            if(!isset($options['product_main_slider_nav_arrow'])) {
                $options['product_main_slider_nav_arrow'] = false;
            }
            if(!isset($options['remove_thumb_slider'])) {
                $options['remove_thumb_slider'] = false;
            }
            if(!isset($options['icon_bg_color'])) {
                $options['icon_bg_color'] = "#000000";
            }
            if(!isset($options['icon_stroke_color'])) {
                $options['icon_stroke_color'] = "#ffffff";
            }

            update_option('wooswipe_options', $options);
        }
        return $options;
    }

    public static function update() {
        if (isset($_POST['wooswipe_save'])) {

            $options = wooswipe_plugin_options::WooSwipe_getOptions();

            if (isset($_POST['white_theme'])) {
                $options['white_theme'] = (bool)true;
            } else {
                $options['white_theme'] = (bool)false;
            }

            if (isset($_POST['pinterest'])) {
                $options['pinterest'] = (bool)true;
            } else {
                $options['pinterest'] = (bool)false;
            }

            if (isset($_POST['hide_thumbnails'])) {
                $options['hide_thumbnails'] = (bool)true;
            } else {
                $options['hide_thumbnails'] = (bool)false;
            }

            if (isset($_POST['product_main_slider'])) {
                $options['product_main_slider'] = (bool)true;
            } else {
                $options['product_main_slider'] = (bool)false;
            }

            if (isset($_POST['product_main_slider_nav_arrow'])) {
                $options['product_main_slider_nav_arrow'] = (bool)true;
            } else {
                $options['product_main_slider_nav_arrow'] = (bool)false;
            }


            if (isset($_POST['remove_thumb_slider'])) {
                $options['remove_thumb_slider'] = (bool)true;
            } else {
                $options['remove_thumb_slider'] = (bool)false;
            }            

            // if (isset($_POST['light_icons'])) {
            //     $options['light_icons'] = (bool)true;
            // } else {
            //     $options['light_icons'] = (bool)false;
            // }

            if (isset($_POST['icon_bg_color'])) {
                $options['icon_bg_color'] = $_POST['icon_bg_color'];
            } else {
                $options['icon_bg_color'] = '#000000';
            }

            if (isset($_POST['icon_stroke_color'])) {
                $options['icon_stroke_color'] = $_POST['icon_stroke_color'];
            } else {
                $options['icon_stroke_color'] = '#ffffff';
            }

            update_option('wooswipe_options', $options);
        } else {
            wooswipe_plugin_options::WooSwipe_getOptions();
        }
    }

	public static function display() {
		$options = wooswipe_plugin_options::WooSwipe_getOptions(); ?>

        <div id="wooswipe_admin" class="wrap">
            <div class="wooswipe_admin-main">
                <h1>WooSwipe Options</h1>

                <p>WooSwipe is a <a target="_blank" rel="noreferrer" href="https://wordpress.org/plugins/wooswipe/">WooCommerce gallery plugin for WordPress</a> built using Photoswipe from  Dmitry Semenov.  <a href="http://photoswipe.com/">Photoswipe</a> and <a href="http://kenwheeler.github.io/slick/"> Slick</a> </p>

                <p>You can edit your thumbnail image sizes in <b>Appearance › Customize › WooCommerce › Product Images</b> unless your theme registers it's own sizes. </a></p>

                <p style="font-style:italic; font-weight:normal; color:grey " >Please note: Images that are already on the server will not change size until you regenerate the thumbnails. Use <a title="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/">AJAX thumbnail rebuild</a> </p>

                <form method="post" action="#" enctype="multipart/form-data">

                    <div class="ps_border" ></div>
                    <p><label><input name="white_theme" type="checkbox" value="checkbox" <?php if($options['white_theme']) echo "checked='checked'"; ?> /> Use white theme?</label></p>
                    
                    <div class="ps_border" ></div>
                    <p><label><input name="pinterest" type="checkbox" value="checkbox" <?php if($options['pinterest']) echo "checked='checked'"; ?> /> Add Pinterest link?</label></p>

                    <div class="ps_border" ></div>
                    <p><label><input name="hide_thumbnails" type="checkbox" value="checkbox" <?php if($options['hide_thumbnails']) echo "checked='checked'"; ?> /> Hide thumbnails if there are no product gallery or variation images.</label></p>

                    <div class="ps_border" ></div>
                    <p><label><input name="product_main_slider" type="checkbox" value="checkbox" id="product_main_slider" <?php if($options['product_main_slider']) echo "checked='checked'"; ?> /> Add slider to Product main Image?</label></p>

                    <?php 
                    $display_style="";
                    if($options['product_main_slider']):
                        $display_style = " ";
                    else:
                        $display_style = "display:none;";
                    endif;
                    ?>
                    <div class="ps_border" ></div>
                    <p class="main_slide_nav" style="<?php echo $display_style; ?>"><label><input name="product_main_slider_nav_arrow" id="product_main_slider_nav_arrow" type="checkbox" value="checkbox" <?php if($options['product_main_slider_nav_arrow']) echo "checked='checked'"; ?> /> Add navigation arrows to the Product main image slider?</label></p>
                    
                    <div class="ps_border" ></div>
                    <p><label><input name="remove_thumb_slider" type="checkbox" value="checkbox" <?php if($options['remove_thumb_slider']) echo "checked='checked'"; ?> /> Remove thumbnail slider completely?</label></p>
                    
                    <div class="icon_color_opt">
                        <div class="icon_color_inputs">
                            <div class="ps_border" ></div>
                            <p><label><input type="color" id="icon_bg_color" name="icon_bg_color" value="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#000000" ); ?>"> Choose icon background color</label></p>

                            <div class="ps_border" ></div>
                            <p><label><input type="color" id="icon_stroke_color" name="icon_stroke_color" value="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"> Choose icon stroke color</label></p>
                        </div>
                        <div class="icons-preview">
                            <span>Icon Preview</span>
                            <ul class="icons-preview-list">
                            <li><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33" height="33" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 51 51" style="enable-background:new 0 0 51 51;" xml:space="preserve"><circle id="Ellipse_1" data-name="Ellipse 1" cx="25.5" cy="25.5" r="25" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>"></circle><path d="M37.4,20.3c0.8,0,1.3-0.6,1.3-1.3v-5.3c0-0.1,0-0.4-0.2-0.6c-0.2-0.3-0.4-0.6-0.8-0.8c-0.2-0.1-0.4-0.1-0.6-0.1h-5.3  c-0.8,0-1.3,0.6-1.3,1.3c0,0.8,0.6,1.3,1.3,1.3h2.2l-8.6,8.6l-8.6-8.6H19c0.8,0,1.3-0.6,1.3-1.3s-0.6-1.3-1.3-1.3h-5.3  c-0.1,0-0.4,0-0.6,0.1c-0.3,0.2-0.6,0.5-0.8,0.8c-0.1,0.2-0.1,0.5-0.1,0.6V19c0,0.8,0.6,1.3,1.3,1.3s1.3-0.6,1.3-1.3v-2.2l8.6,8.6  l-8.6,8.6v-2.2c0-0.8-0.6-1.3-1.3-1.3c-0.8,0-1.3,0.6-1.3,1.3v5.3c0,0.2,0,0.4,0.1,0.6c0.1,0.3,0.4,0.6,0.8,0.8  c0.2,0.2,0.5,0.2,0.6,0.2H19c0.8,0,1.3-0.6,1.3-1.3c0-0.8-0.6-1.3-1.3-1.3h-2.2l8.6-8.6l8.6,8.6h-2.2c-0.8,0-1.3,0.6-1.3,1.3  c0,0.8,0.6,1.3,1.3,1.3h5.3c0.2,0,0.4,0,0.6-0.2c0.3-0.2,0.6-0.4,0.8-0.8c0.2-0.2,0.2-0.4,0.2-0.6v-5.3c0-0.8-0.6-1.3-1.3-1.3  c-0.8,0-1.3,0.6-1.3,1.3v2.2l-8.6-8.6l8.5-8.6V19C36,19.9,36.5,20.3,37.4,20.3z" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"></path></svg></li>
                                <li class="nav-left"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_2" data-name="Ellipse 2" cx="40" cy="40" r="40" transform="translate(977 529)" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"/></g></svg></li>
                                <li class="nav-right"><svg xmlns="http://www.w3.org/2000/svg" id="right" width="33" height="33" viewBox="0 0 80 80"><circle id="Ellipse_3" data-name="Ellipse 2" cx="40" cy="40" r="40" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>" /><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M26.387,21.735,7.965,3.314a2.275,2.275,0,0,0-3.217,0L2.6,5.463a2.275,2.275,0,0,0,0,3.213L17.2,23.344,2.6,38.012a2.274,2.274,0,0,0,0,3.213l2.149,2.149a2.275,2.275,0,0,0,3.217,0L26.387,24.952A2.275,2.275,0,0,0,26.387,21.735Z" transform="translate(24.947 16.352)" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"/></svg></li>
                            </ul>
                        </div>
                    </div>

                    <div class="ps_border" ></div>
                    <p><input class="button-primary" type="submit" name="wooswipe_save" value="Save Changes" /></p>

                </form>
                <p>WooSwipe built by <a target="_blank" rel="noreferrer" href="https://thriveweb.com.au">Thrive Digital</a>
                </p>
            </div>
            
        </div>

    <?php }
}
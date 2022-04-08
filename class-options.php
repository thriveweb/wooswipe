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
                    <p><label><input name="product_main_slider" type="checkbox" value="checkbox" <?php if($options['product_main_slider']) echo "checked='checked'"; ?> /> Add slider to Product main Image?</label></p>
                    
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
                                <li><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" stroke="#000" stroke-linecap="round" stroke-linejoin="round" fill="#fff" fill-rule="evenodd"><ellipse id="Ellipse_1" cx="19.5" cy="20.1613" rx="15" ry="15.1613" stroke-opacity="0" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>"/><path d="M26.1373 12.4821h-.278l-.0292-.0293-.0366.0366-3.6931-.0078-.0076 1.6458 2.0476.0149-4.4102 4.4101-4.4165-4.4186 2.0185.0149.0075-1.6605-3.6932-.0224-.0072-.0073-.0147.0146-.3145-.0074c-.2281.0036-.4233.0863-.585.2487s-.244.3554-.2487.5852l.0072.3145-.0146.0147.0146.0145-.0005 3.7011 1.6527.0003.0004-2.0482 4.4238 4.426-4.4249 4.4249.0002-2.048-1.6527-.0002-.0005 3.7011-.0293.0292.0293.0293-.0074.2852c.0046.2298.0876.4247.2486.5853s.3568.2451.585.2487l.2852-.0073.0292.0293.0294-.0292 3.6857-.0142-.0071-1.6604-2.0184.0143 4.4176-4.4175 4.4091 4.4115-2.0477.0143.0072 1.6459 3.6931-.0069.022.022.0146-.0147.3072.0001c.2323-.0056.4274-.0883.585-.2487a.798.798 0 0 0 .2415-.5924v-.2926l.0219-.0219-.0219-.022-.0141-3.6866-1.6528.0145.0071 2.0115-4.402-4.4041 4.4031-4.4029-.0076 2.0115 1.6527.0148.0151-3.6865.0366-.0367-.0366-.0365.0001-.2633c.0024-.2306-.0781-.4281-.2412-.5925-.1577-.1604-.3528-.2433-.585-.2488z" stroke="none" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>" fill-rule="nonzero"/></svg></li>
                                <li class="nav-left"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_2" data-name="Ellipse 1" cx="40" cy="40" r="40" transform="translate(977 529)" fill="<?php _e(!empty($options['icon_bg_color']) ? $options['icon_bg_color'] : "#ffffff" ); ?>"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="<?php _e(!empty($options['icon_stroke_color']) ? $options['icon_stroke_color'] : "#ffffff" ); ?>"/></g></svg></li>
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
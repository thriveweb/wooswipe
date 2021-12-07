<?php
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die('Illegal Entry');

// Admin CSS
function wooswipe_register_head() {
    $url = plugins_url( 'admin.css', __FILE__ );
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'wooswipe_register_head');



/*--------------------------------------------------------------
WooSwipe Options
--------------------------------------------------------------*/
class wooswipe_plugin_options {

	public static function init() {
		// register functions
		add_action('admin_menu', array('wooswipe_plugin_options', 'update'));
	}

    // Defaults
    public static function WooSwipe_getOptions() {
        // Pull from WP options database table
        $options = get_option('wooswipe_options');
        if (!is_array($options)) {
            $options['white_theme'] = false;
            $options['pinterest'] = false;
            $options['hide_thumbnails'] = false;
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
                    <p><input class="button-primary" type="submit" name="wooswipe_save" value="Save Changes" /></p>

                </form>
            </div>

            <div class="wooswipe_admin-sidebar">
                <br>
                    <img src="<?= plugins_url() . '/wooswipe/images/Thrive_logo.gif'; ?>" alt="Thrive digital" width="100%" height="auto">
                    <div class="ps_border" ></div>
                    <h2>Publications from our team</h2>
                    <img src="<?= plugins_url() . '/wooswipe/images/WooCommerce-thumbnail.jpg'; ?>" alt="PhotoSwipe" width="100%" height="auto" />
                    <p>WooCommerce is at the heart of many ecommerce stores, designed for small to large-sized online merchants using WordPress.</p>
                    <p><a class="btn" target="_blank" rel="noreferrer" href="https://thriveweb.com.au/the-lab/woocommerce-checklist/">Read more</a></p>
                    <div class="ps_border" ></div>
                    <img src="<?= plugins_url() . '/wooswipe/images/photoswipe-mansonry-2.0.jpg'; ?>" alt="PhotoSwipe" width="100%" height="auto" />
                    <p>Explore the brand new PhotoSwipe Masonry 2.0 gallery, based off Dmitry Semenov's PhotoSwipe plugin.</p>
                    <p><a class="btn" target="_blank" rel="noreferrer" href="https://thriveweb.com.au/the-lab/photoswipe-v2/">Read more</a></p>
                    <p>Wooswipe built by Thrive Digital
                        <br>
                        <a target="_blank" rel="noreferrer" href="https://thriveweb.com.au">Web Design Gold Coast.</a>
                    </p>
            </div>
        </div>

    <?php }
}
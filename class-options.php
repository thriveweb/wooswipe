<?php 

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Illegal Entry');
}

///////////
//Admin CSS
function wooswipe_register_head() {

    $url = plugins_url( 'admin.css', __FILE__ );

    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'wooswipe_register_head');


//============================== wooswipe options ========================//
class wooswipe_plugin_options {

	public static function init() {

		// register functions
		add_action('admin_menu', array('wooswipe_plugin_options', 'update'));

	}


	//Defaults
	public static function WooSwipe_getOptions() {

		//Pull from WP options database table
		 $options = get_option('wooswipe_options');

		if (!is_array($options)) {

			$options['white_theme'] = false;

			update_option('wooswipe_options', $options);
		}
		return $options;
	}


	public static function update() {

		if(isset($_POST['wooswipe_save'])) {

			$options = wooswipe_plugin_options::WooSwipe_getOptions();

			if (isset($_POST['white_theme'])) {
				$options['white_theme'] = (bool)true;
			} else {
				$options['white_theme'] = (bool)false;
			}

			update_option('wooswipe_options', $options);

		} else {
			wooswipe_plugin_options::WooSwipe_getOptions();
		}
	}


	public static function display() {

		$options = wooswipe_plugin_options::WooSwipe_getOptions();
		?>

		<div id="wooswipe_admin" class="wrap">

			<h2>WooSwipe Options</h2>

			<p>WooSwipe is a WooCommerce gallery plugin for WordPress built using Photoswipe from  Dmitry Semenov.  <a href="http://photoswipe.com/">Photoswipe</a> and <a href="http://kenwheeler.github.io/slick/"> Slick</a> </p>

			<p>More options coming soon. Edit your image sizes <a href="<?php echo admin_url( 'customize.php?return=%2Fwp-admin%2Foptions-media.php', 'http' ); ?> "> here </a></p>

			<p style="font-style:italic; font-weight:normal; color:grey " >Please note: Images that are already on the server will not change size until you regenerate the thumbnails. Use <a title="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/">AJAX thumbnail rebuild</a> </p>

			<form method="post" action="#" enctype="multipart/form-data">

				<div class="ps_border" ></div>


				<p><label><input name="white_theme" type="checkbox" value="checkbox" <?php if($options['white_theme']) echo "checked='checked'"; ?> /> Use white theme?</label></p>


				<div class="ps_border" ></div>

				<p><input class="button-primary" type="submit" name="wooswipe_save" value="Save Changes" /></p>

			</form>


		</div>

		<?php
	}
}



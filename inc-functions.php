<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Illegal Entry');
}

///////////////////////
// keep the image size settings. Most themes seem to override it. 
remove_theme_support( 'woocommerce',
	array( 'thumbnail_image_width', 'gallery_thumbnail_image_width', 'single_image_width' )
);

///////////////////////
// remove woo lightbox
add_action( 'wp_print_scripts', 'wooswipe_deregister_javascript', 100 );
function wooswipe_deregister_javascript() {
	wp_deregister_script( 'prettyPhoto' );
	wp_deregister_script( 'prettyPhoto-init' );
}
add_action( 'wp_print_styles', 'wooswipe_deregister_styles', 100 );
function wooswipe_deregister_styles() {
	wp_deregister_style( 'woocommerce_prettyPhoto_css' );
}


///////////////////////
// Remove default Woo Gallery
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'wooswipe_woocommerce_show_product_thumbnails', 20 );

function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
    remove_theme_support( 'wc-product-gallery-lightbox' );
    remove_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );

///////////
//Sub Menu
function register_wooswipe_custom_submenu_page() {
    add_submenu_page( 'woocommerce', 'WooSwipe', 'WooSwipe', 'manage_options', 'wooswipe-options', array('wooswipe_plugin_options', 'display') );
}
function wooswipe_custom_submenu_page_callback() {
    echo '<h3>WooSwipe Custom Submenu Page</h3>';
}
add_action('admin_menu', 'register_wooswipe_custom_submenu_page',99);

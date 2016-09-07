=== WooSwipe WooCommerce Gallery ===
Contributors: deanoakley, jinksi
Author: Dean Oakley
Author URI: http://thriveweb.com.au/
Plugin URI: http://thriveweb.com.au/the-lab/wooswipe/
Tags: WooSwipe, woocommerce, woocommerce gallery, products, product gallery, responsive
Requires at least: 3.0
Tested up to: 4.6
Stable tag: 1.1.6.2

A WooCommerce gallery plugin built using PhotoSwipe from Dmitry Semenov and Slick carousel.

== Description ==

A WooCommerce gallery plugin built using PhotoSwipe from Dmitry Semenov. [photoswipe](http://photoswipe.com/ "PhotoSwipe") and [slick carousel](http://kenwheeler.github.io/slick/ "Slick Carousel") Slick Carousel.

WooSwipe should work out of the box with your WooCommerce gallery settings. Simply adjust your image sizes in WooCommerce > Settings > Products > Display. You may need to rebuild your thumbnails.

* Responsive
* Very Mobile Friendly
* Keyboard control
* Full image size
* 2 colour options

Planned Features:
* Show titles or captions

Actions:
wooswipe_before_main
wooswipe_after_main

Filter:
wooswipe_zoomed_image_size
add_filter( 'wooswipe_zoomed_image_size', 'max_image_size', 10, 1 );
function max_image_size( $size ) {
	$size = "large";
	return $size;
}

Join the chat at https://gitter.im/thriveweb/wooswipe

[More Info here](http://thriveweb.com.au/the-lab/wooswipe/ "WooSwipe")

== Installation ==

1. Upload `/wooswipe/` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Checkout your new gallery!

== Screenshots ==

1. Screenshot Default gallery layout
2. Screenshot Popup layout

= 1.1.6.2 =
* Readme docs update

= 1.1.6 =
* Fix Undefined variable: zoomed_image_size

= 1.1.4 =
* BJ Fixed Hooks Bug

= 1.1.3 =
* BJ Added hooks and filter

= 1.1.1 =
* rewrite js
* fix image change bugs
* much betterness

= 1.0.5 =
* style clear

= 1.0.4 =
* style fix

= 1.0.3 =
* White Skin update

= 1.0.2 =
* Fix for missing srcset

= 1.0.1 =
* This is the first version

=== WooSwipe WooCommerce Gallery ===
Contributors: deanoakley, jinksi, Firthir
Author: Web Design Gold Coast
Author URI: https://thriveweb.com.au/
Plugin URI: https://thriveweb.com.au/the-lab/wooswipe/
Tags: WooSwipe, woocommerce, woocommerce gallery, products, product gallery, responsive
Requires at least: 3.0
Tested up to: 5.8.2
Stable tag: 1.1.13

A WooCommerce gallery plugin built using PhotoSwipe from Dmitry Semenov and Slick carousel.

== Description ==

A WooCommerce gallery plugin built using PhotoSwipe from Dmitry Semenov. [photoswipe](http://photoswipe.com/ "PhotoSwipe") and [slick carousel](http://kenwheeler.github.io/slick/ "Slick Carousel").

WooSwipe should work out of the box with your WooCommerce gallery settings. Simply adjust your image sizes in Appearance > Customize > WooCommerce > Product Images. You may need to rebuild your thumbnails when changing image sizes. (Note: If your theme declares theme image sizes then you may not be able to change them.)

* Responsive
* Very Mobile Friendly
* Keyboard control
* Full image size
* 2 colour options
* Pinit to Pinterest option

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

= 1.1.13 =
* Added option for hiding thumbnails when no product gallery or product variation image is available
* Remove lazy loading from main image (https://github.com/thriveweb/wooswipe/issues/40)
* Accessibility fixes
* Tested with WP 5.8.2 + WC 5.9.0

= 1.1.12 =
* Fixed issue where lightbox opens with wrong image if changed via variation selector due to pinterest links (https://wordpress.org/support/topic/wrong-image-in-lightbox-when-variation-is-selected/)
* Add "product_page" shortcode support (https://github.com/thriveweb/wooswipe/issues/20)
* Tested with WP 5.7.2 + WC 5.4.0

= 1.1.11 =
* Fix Pinterest select image 

= 1.1.10 =
* PHP notice fix

= 1.1.9 =
* Layout fix and image size fix

= 1.1.8.11 =
* Version bump slick.js 1.5.7 -> 1.8.1

= 1.1.8.10 =
* Readme updated with latest way to adjust image sizes

= 1.1.8.9 =
* Revert PR38

= 1.1.8.8 =
* Added Compatibility for "WooCommerce Variation Swatches and Photo" up to v3.1.1
* Merged PR (https://github.com/thriveweb/wooswipe/pull/38). Add variation id for thumbnails.

= 1.1.8.7 =
* Readme and checking latest compatibility

= 1.1.8.6 =
* Rollback bug fix 

= 1.1.8.5 =
* SVG Pinterest image
* Meta text update

= 1.1.7.0 =
* Add Pinterest option
* Merged pull request pinit branch

= 1.1.6.9 =
* Variation image bug fix https://github.com/thriveweb/wooswipe/issues/27
* Skip repeated images from gallery and variation
* Minor restructre and tidy up

= 1.1.6.8 =
* Meta update and testing with WP v5
* Merged pull request from @matthijs166 https://github.com/thriveweb/wooswipe/pull/28

= 1.1.6.7 =
* Added alt tag to main image

= 1.1.6.6 =
* Readme
* z-index increase

= 1.1.6.5 =
* Fixed image change bug with variation selector
* Removed file

= 1.1.6.3 =
* Fixed depreciation notice of get_gallery_attachment_ids

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

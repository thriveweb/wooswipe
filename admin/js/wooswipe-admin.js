(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function(){
		$("input#icon_bg_color").change(function () {
			console.log("hi");
			var bgcolor = $(this).val();
			$(".icons-preview-list li").each(function () {
				$(this).find('svg').each(function () { $(this).find('circle').attr('fill', bgcolor) });

			});
		});
		$("input#icon_stroke_color").change(function () {
			var strokecolor = $(this).val();
			$(".icons-preview-list li").each(function () {
				$(this).find('svg').each(function () { $(this).find('path').attr('fill', strokecolor) });

			});
		});

		$("#product_main_slider[type=checkbox]").change(function () {
			if ($(this).prop("checked") == true) {
				$(".main_slide_nav").slideDown();
			} else {
				$(".main_slide_nav").slideUp();
				$("#product_main_slider_nav_arrow").prop("checked", false);
			}
		});
	});

})( jQuery );

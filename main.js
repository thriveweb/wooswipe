jQuery(document).ready(function($) {
	
	(function productThumbnails(){
		$('.thumbnail-nav').slick({
			variableWidth: false,
			dots: false,
			focusOnSelect: false,
			infinite: false,
			slidesToShow: 5,
			slidesToScroll: 5,
			respondTo: 'slider',
			responsive: [
			{
			  breakpoint: 680,
			  settings: {
			    slidesToShow: 5,
			    slidesToScroll: 5
			  }
			},
			{
			  breakpoint: 520,
			  settings: {
			    slidesToShow: 4,
			    slidesToScroll: 4
			  }
			},
			{
			  breakpoint: 420,
			  settings: {
			    slidesToShow: 3,
			    slidesToScroll: 3
			  }
			}
			]
  
		});
		$('.thumbnails .thumb').click(function(e){
			
			e.preventDefault();
			
			var $this = $(this);
			var med = $this.attr('data-med');
			var srcset = $this.attr('data-med');
			var width = $this.attr('data-medw');
			var height = $this.attr('data-medh');
			var hq = $this.attr('data-hq');
			var hqw = $this.attr('data-w');
			var hqh = $this.attr('data-h');
			var ind = $this.parent().index();
			var parHeight = 0;
			
			$('.single-product-main-image img').fadeOut('fast', function(){
				
				$(this).attr('data-ind', ind)
					.attr('src', med)
					.attr('srcset', med)
					.attr('width', width)
					.attr('height', height)
					.attr('data-hq', hq)
					.attr('data-w', hqw)
					.attr('data-h', hqh)
					.fadeIn('fast', function(){
						// setTimeout(function(){
						// 	parHeight = $(this).height();
						// 	$('.single-product-main-image').animate({
						// 		height: parHeight
						// 	}, 200);
						// }, 300);
				});

			});
		});
	})();

	
	(function photoSwipe(){

	  var pswpElement = document.querySelectorAll('.pswp')[0];
	  var items = [];

		function openPswp(index){
			var options = {
				index: index, /* ,
				getThumbBoundsFn: function(index) {
				
				    // find thumbnail element
				    var thumbnail = document.querySelectorAll('.zoom')[index];
				
				    // get window scroll Y
				    var pageYScroll = window.pageYOffset || document.documentElement.scrollTop; 
				    // optionally get horizontal scroll
				
				    // get position of element relative to viewport
				    var rect = thumbnail.getBoundingClientRect(); 
				
				    // w = width
				    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
				
				
				    // Good guide on how to get element coordinates:
				    // http://javascript.info/tutorial/coordinates
				}, */
				shareEl: false
			};
			// Initializes and opens PhotoSwipe
			var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
			gallery.init();
		}

	  // build items array
		if ( $('.thumbnails .thumb').length > 0 ) {
			var $thumbs = $('.thumbnails .thumb');
			for( i=0; i<$thumbs.length; i++){
				var $this = $thumbs[i];
		    var src = $this.attributes['data-hq'].value;
		    var w = $this.attributes['data-w'].value;
		    var h = $this.attributes['data-h'].value;
				var item = {
					src: src,
					w: w,
					h: h
				};
		    items.push(item);
			}
		} else if ( $('.single-product-main-image').length > 0 ) {
			var $this = $('.single-product-main-image img')[0];
			var src = $this.attributes['data-hq'].value;
			var w = $this.attributes['data-w'].value;
			var h = $this.attributes['data-h'].value;
			var item = {
				src: src,
				w: w,
				h: h
			};
			items.push(item);
		}

		// click event
		if ( $('.single-product-main-image').length > 0 ) {
			$('.single-product-main-image').click(function(e){
				var ind = $(this).find('img').attr('data-ind');
				e.preventDefault();
				if( ind ) {
					index = parseInt(ind);
				} else {
					index = 0;
				}
				openPswp(index);
			});
		}

	})();
		
	
});
	
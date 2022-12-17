(function(document, window, $) {
    "use strict";
    var main_image_swiper = wooswipe_data['product_main_slider'];
    
    var add_slick_track_class = " ";
    var add_slick_slide_class = " ";
    if(main_image_swiper) {
        add_slick_track_class = ".slick-track";
        add_slick_slide_class = ".slick-slide";
    }

    (function productThumbnails() {
        // see wp_enqueue_script wp_localize_script wooswipe.php
        var plugin_path = wooswipe_wp_plugin_path.templateUrl + "/";

        var addPintrest = wooswipe_data['addpin'];

        var firstUrl;
        var alt;
        
        if($('.single-product-main-image img').length > 0){
            firstUrl = $(".single-product-main-image img").attr("src");
            alt = $(".single-product-main-image img").attr("alt");
        }else if($('.wooswipe-placeholder').length > 0){
            firstUrl = $(".wooswipe-placeholder").attr("src");
            alt = $(".wooswipe-placeholder").attr("alt");
        }
        var link = window.location.href;

        // run this on thumbnail click
        function pinit(url) {
            $(".wooswipe-pinit").attr(
                "href",
                "https://www.pinterest.com/pin/create/button/?media=" +
                url +
                "&url=" +
                link +
                "&description=" +
                encodeURI(alt)
            );
        }

        if (addPintrest) {
            // set up first pin
            if($(".single-product-main-image").length != 0){
            $("#wooswipe").prepend(
                '<a class="wooswipe-pinit" target="_blank" rel="noreferrer noopener" href="https://www.pinterest.com/pin/create/button/?media=' +
                firstUrl +
                "&url=" +
                link +
                "&description=" +
                encodeURI(alt) +
                '"><img src="' +
                plugin_path +
                'public/pinit/pinterest.svg" alt="Pinterest" /></a>'
            );
            }
            // set up pin for place holder image 
            if($(".wooswipe-placeholder").length != 0){
                $("#wooswipe").prepend(
                    '<a class="wooswipe-pinit" target="_blank" rel="noreferrer noopener" href="https://www.pinterest.com/pin/create/button/?media=' +
                    firstUrl +
                    "&url=" +
                    link +
                    "&description=" +
                    encodeURI(alt) +
                    '"><img src="' +
                    plugin_path +
                    'public/pinit/pinterest.svg" alt="Pinterest" /></a>'
                );
            }
            // popit new window
            $(".wooswipe-pinit").click(function(e) {
                e.preventDefault();
                var popitHref = $(this).attr("href");
                window.open(
                popitHref,
                "popUpWindow",
                "height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes"
                );
                return false;
            });
            // end add pin
        }

        // It will setup the selected image url for the full screen view
        function setup_full_screen_image_url(url) {
            $(".wooswipe-popup").attr("href", url);
        }

        $(".thumbnail-nav").slick({
            variableWidth: false,
            dots: false,
            focusOnSelect: false,
            infinite: false,
            slidesToShow: 5,
            slidesToScroll: 1,
            respondTo: "slider",
            prevArrow: '<button class="wooswipe-prev slick-arrow slick-disabled" aria-label="Previous" type="button" style=""><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" transform="translate(977 529)" fill="'+wooswipe_data['icon_bg_color']+'"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="'+wooswipe_data['icon_stroke_color']+'"/></g></svg></button>',
            nextArrow: '<button class="wooswipe-next slick-arrow" aria-label="Next" type="button" style="" ><svg xmlns="http://www.w3.org/2000/svg" id="right" width="20" height="20" viewBox="0 0 80 80"><circle id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" fill="'+wooswipe_data['icon_bg_color']+'" /><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M26.387,21.735,7.965,3.314a2.275,2.275,0,0,0-3.217,0L2.6,5.463a2.275,2.275,0,0,0,0,3.213L17.2,23.344,2.6,38.012a2.274,2.274,0,0,0,0,3.213l2.149,2.149a2.275,2.275,0,0,0,3.217,0L26.387,24.952A2.275,2.275,0,0,0,26.387,21.735Z" transform="translate(24.947 16.352)" fill="'+wooswipe_data['icon_stroke_color']+'"/></svg></button>',
            responsive: [
                {
                breakpoint: 680,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                breakpoint: 520,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                breakpoint: 420,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });


        // if slider disable for the main image
    
        // set the data attributes for the image on thumbnail click
        $(".thumbnails .thumb").click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var med = replace_mainimage_thumb_change($this);
            if (addPintrest) {
                pinit(med);
            }
        });

        // Replace the main image on thumbnail click from the thumbnail slider
        function replace_mainimage_thumb_change($this) {
            var med = $this.attr("data-med");
            var alt = $this.attr("data-title");
            var title = $this.attr("data-title");
            var srcset = $this.attr("data-med");
            var width = $this.attr("data-medw");
            var height = $this.attr("data-medh");
            var hq = $this.attr("data-hq");
            var hqw = $this.attr("data-w");
            var hqh = $this.attr("data-h");
            var atid = $this.attr("data-attachment_id");
            var ind = $this.parent().index();
            var parHeight = 0;
            mainImage = $(".single-product-main-image img");
            mainImage
                .attr("data-ind", ind)
                .attr("src", med)
                .attr("srcset", med)
                .attr("width", width)
                .attr("height", height)
                .attr("data-hq", hq)
                .attr("data-w", hqw)
                .attr("data-h", hqh)
                .attr("data-attachment_id", atid)
                .attr("alt", alt)
                .attr("title", title);
            return med;
        }

        var mainImage = $(".single-product-main-image img");
        
        if (mainImage.length != 0) {
            mainImage = $(".single-product-main-image img");
            mainImage.wrap('<a class="woocommerce-main-image zoom" href="#"></a>');
            $(".woocommerce-main-image").wrap(
                '<div class="single-product-main-image"></div>'
            );
            
            if (addPintrest) {
                pinit(mainImage[0].src);
            }
        }

        var placeholderImage = $(document).find(".wooswipe-placeholder");
        if (placeholderImage.length != 0) {
            placeholderImage = $(".wooswipe-placeholder");
            placeholderImage.wrap('<a class="woocommerce-main-image zoom" href="#"></a>');
            $(".woocommerce-main-image").wrap(
                '<div class="single-product-main-image"></div>'
            );
            if (addPintrest) {
                pinit(placeholderImage[0].src);
            }
        }

        // on variation change set popup index to changed variation (if slider enable for the main image)
        var srcind_new;
        var pinimgsrc;
        $( '.single_variation_wrap' ).on( 'show_variation', function( event, variation ) {
            var current_variation_img = variation.image.url;
            $("div.thumb[data-slide]").each(function () {
                if (current_variation_img == $(this).attr("data-med")) {                    
                    // srcind_new = $(this).parent().attr("data-slick-index");
                    var $this = $(this);
                    var med = replace_mainimage_thumb_change($this);
                    pinimgsrc = med;
                }
            });

            // $("#wooswipe .single-product-main-image "+add_slick_slide_class+" img").attr("data-ind", srcind_new);
            if (addPintrest) {
                pinit(pinimgsrc);
                setup_full_screen_image_url(pinimgsrc);
            }
            
        });
       
    })();

    (function photoSwipe() {
        var pswpElement = document.querySelectorAll(".pswp")[0];
        var items = [];

        function openPswp(index) {
            var options = {
                index: index,
                shareEl: false
            };
            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe(
                pswpElement,
                PhotoSwipeUI_Default,
                items,
                options
            );
            gallery.init();
        }

        // build items array
        function pushItem(image) {
            var src = image.attributes["data-hq"].value;
            var w = image.attributes["data-w"].value;
            var h = image.attributes["data-h"].value;
            var t = image.attributes["data-title"].value;
            var item = {
                src: src,
                w: w,
                h: h,
                title: t
            };
            items.push(item);
        }

        // Adding items to image for lightbox
        if ($(".thumbnails .thumb").length > 0) {
            var $thumbs = $(".thumbnails .thumb");            
            for (var i = 0; i < $thumbs.length; i++) {
                var thumbAlt = $($thumbs[i]).find("img").attr("title");
                $($thumbs[i]).attr("data-title", thumbAlt);
                pushItem($thumbs[i]);
            }
        } 
        if ($(".single-product-main-image").length > 0) {
            var singleImg = $(".single-product-main-image img");
            var singleImgAlt = singleImg.attr("title");
            $(".single-product-main-image").find('img').attr("data-title", singleImgAlt);
            var $this = $(".single-product-main-image img")[0];
            pushItem($this);
        }

        // click event
        if ($(".single-product-main-image "+add_slick_slide_class+" img").length > 0) {
            $(".single-product-main-image "+add_slick_slide_class+" img").click(function(e) {

                // Allow user to open image link in new tab or download it
                if (e.which == 2 || e.ctrlKey || e.altKey) {
                    return;
                }
                var ind = $(this)
                .attr("data-ind");

                e.preventDefault();
                var index = ind ? parseInt(ind) : 0;
                openPswp(index);
            });
        }
    })();
})(document, window, jQuery);

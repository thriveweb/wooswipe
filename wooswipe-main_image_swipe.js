(function (document, window, $) {
    $("#wooswipe .woocommerce-main-image").on("click", function (e) {
        e.preventDefault();
    });
    "use strict";
    var main_image_swiper = wooswipe_data['product_main_slider'];

    var add_slick_track_class = " ";
    var add_slick_slide_class = " ";
    if (main_image_swiper) {
        add_slick_track_class = ".slick-track";
        add_slick_slide_class = ".slick-slide";
    }
    (function productThumbnails() {
        // see wp_enqueue_script wp_localize_script wooswipe.php
        var plugin_path = wooswipe_wp_plugin_path.templateUrl + "/";

        var addPintrest = wooswipe_data['addpin'];

        var firstUrl = $(".single-product-main-image img").attr("src");
        var alt = $(".single-product-main-image img").attr("alt");
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
            if ($(".single-product-main-image").length != 0) {
                $("#wooswipe").prepend(
                    '<a class="wooswipe-pinit wooswipe-mainimagepin" target="_blank" rel="noreferrer noopener" href="https://www.pinterest.com/pin/create/button/?media=' +
                    firstUrl +
                    "&url=" +
                    link +
                    "&description=" +
                    encodeURI(alt) +
                    '"><img src="' +
                    plugin_path +
                    '/pinit/pinterest.svg" alt="Pinterest" /></a>'
                );

            }
            // popit new window
            $(".wooswipe-pinit").click(function (e) {
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


        // setup the full screen box
        $("#wooswipe").prepend(
            '<a class="wooswipe-popup wooswipe-mainimagepopup" rel="noreferrer noopener" href="' +
            firstUrl + '"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" stroke="#000" stroke-linecap="round" stroke-linejoin="round" fill="#fff" fill-rule="evenodd"><ellipse cx="19.5" cy="20.1613" rx="15" ry="15.1613" stroke-opacity="0" fill="'+wooswipe_data['icon_bg_color']+'"/><path d="M26.1373 12.4821h-.278l-.0292-.0293-.0366.0366-3.6931-.0078-.0076 1.6458 2.0476.0149-4.4102 4.4101-4.4165-4.4186 2.0185.0149.0075-1.6605-3.6932-.0224-.0072-.0073-.0147.0146-.3145-.0074c-.2281.0036-.4233.0863-.585.2487s-.244.3554-.2487.5852l.0072.3145-.0146.0147.0146.0145-.0005 3.7011 1.6527.0003.0004-2.0482 4.4238 4.426-4.4249 4.4249.0002-2.048-1.6527-.0002-.0005 3.7011-.0293.0292.0293.0293-.0074.2852c.0046.2298.0876.4247.2486.5853s.3568.2451.585.2487l.2852-.0073.0292.0293.0294-.0292 3.6857-.0142-.0071-1.6604-2.0184.0143 4.4176-4.4175 4.4091 4.4115-2.0477.0143.0072 1.6459 3.6931-.0069.022.022.0146-.0147.3072.0001c.2323-.0056.4274-.0883.585-.2487a.798.798 0 0 0 .2415-.5924v-.2926l.0219-.0219-.0219-.022-.0141-3.6866-1.6528.0145.0071 2.0115-4.402-4.4041 4.4031-4.4029-.0076 2.0115 1.6527.0148.0151-3.6865.0366-.0367-.0366-.0365.0001-.2633c.0024-.2306-.0781-.4281-.2412-.5925-.1577-.1604-.3528-.2433-.585-.2488z" stroke="none" fill="'+wooswipe_data['icon_stroke_color']+'" fill-rule="nonzero"/></svg></a>'
        );

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


        // if slider enable for the main image

        // implement slick carousel for main image slider
        $(".single-product-main-image").slick({
            variableWidth: false,
            dots: false,
            focusOnSelect: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            respondTo: "slider",
            adaptiveHeight: true,
            prevArrow: '<button class="wooswipe-prev slick-arrow slick-disabled" aria-label="Previous" type="button" style=""><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" transform="translate(977 529)" fill="'+wooswipe_data['icon_bg_color']+'"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="'+wooswipe_data['icon_stroke_color']+'"/></g></svg></button>',
            nextArrow: '<button class="wooswipe-next slick-arrow" aria-label="Next" type="button" style="" ><svg xmlns="http://www.w3.org/2000/svg" id="right" width="20" height="20" viewBox="0 0 80 80"><circle id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" fill="'+wooswipe_data['icon_bg_color']+'" /><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M26.387,21.735,7.965,3.314a2.275,2.275,0,0,0-3.217,0L2.6,5.463a2.275,2.275,0,0,0,0,3.213L17.2,23.344,2.6,38.012a2.274,2.274,0,0,0,0,3.213l2.149,2.149a2.275,2.275,0,0,0,3.217,0L26.387,24.952A2.275,2.275,0,0,0,26.387,21.735Z" transform="translate(24.947 16.352)" fill="'+wooswipe_data['icon_stroke_color']+'"/></svg></button>',
            responsive: [
                {
                    breakpoint: 680,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 420,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
        // change pinterest src on side arrows navigation click
        $("#wooswipe .slick-arrow").on("click", function (event) {
            var current_slide = $(".single-product-main-image .slick-active").find("a").attr('data-med');

            if (addPintrest) {
                pinit(current_slide);
                setup_full_screen_image_url(current_slide);
            }
        });
        // set the data attributes for the image on thumbnail click
        $('div.thumb[data-slide]').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var med = $this.attr("data-med");
            var srcset = $this.attr("data-med");
            var width = $this.attr("data-medw");
            var height = $this.attr("data-medh");
            var hq = $this.attr("data-hq");
            var hqw = $this.attr("data-w");
            var hqh = $this.attr("data-h");
            var atid = $this.attr("data-attachment_id");
            var ind = $this.parent().index();
            var parHeight = 0;

            mainImage = $(".single-product-main-image #" + atid);

            mainImage
                .attr("data-ind", ind)
                .attr("src", med)
                .attr("srcset", med)
                .attr("width", width)
                .attr("height", height)
                .attr("data-hq", hq)
                .attr("data-w", hqw)
                .attr("data-h", hqh)
                .attr("data-attachment_id", atid);
            if (addPintrest) {
                pinit(med);
                setup_full_screen_image_url(med);
            }
            var slideno = $(this).data('slide');
            // implemented the main slider naviation on thumbnail click
            $('.single-product-main-image').slick('slickGoTo', slideno);
        });


        var mainImage = $(".single-product-main-image " + add_slick_track_class + " img");
        if (!mainImage.length) {
            mainImage = $(".single-product-main-image " + add_slick_track_class + " img");
            mainImage.wrap('<a class="woocommerce-main-image zoom" href="#"></a>');
            $(".woocommerce-main-image").wrap(
                '<div class="single-product-main-image"></div>'
            );
            if (addPintrest) {
                pinit(mainImage[0].src);
                setup_full_screen_image_url(mainImage[0].src);
            }
        }

        // on variation change set popup index to changed variation (if slider enable for the main image)

        $(document).on("change", ".variations select", function () {
            var srcind = displaySwachesOrVariationSelection();
            $('.single-product-main-image').slick('slickGoTo', srcind);
            // $("#wooswipe .single-product-main-image "+add_slick_slide_class+" img").attr("data-ind", srcind);
        });


        // compatibility for "WooCommerce Variation Swatches and Photo". On swatch change set popup index to changed variation
        if ($(".variations .swatch-control").length > 0) {

            // if slider enable for the main image

            $(".variations_form").addClass('has-swatches');

            // manage variation change for the color type swatch
            $(document).on("click", ".variations_form.has-swatches .swatch-wrapper.selected ", function (e) {
                displaySwachesOrVariationSelection();
            });

            // manage variation change for the radio type swatch
            $(document).on("change", ".variations_form.has-swatches .radio-select.swatch-control li input[type=radio]", function (e) {
                displaySwachesOrVariationSelection();
            });
        }
        function displaySwachesOrVariationSelection() {
            var variation_img_src_with_swatch = $(".woocommerce-product-gallery__image").attr("data-thumb");
            var srcind_new = 0;
            var pinimgsrc = '';
            $("div.thumb[data-slide]").each(function () {
                if (variation_img_src_with_swatch == $(this).attr("data-med")) {
                    srcind_new = $(this).parent().attr("data-slick-index");
                    pinimgsrc = $(this).attr("data-med");
                }
            });

            $('.single-product-main-image').slick('slickGoTo', srcind_new);

            // $("#wooswipe .single-product-main-image "+add_slick_slide_class+" img").attr("data-ind", srcind_new);
            if (addPintrest) {
                pinit(pinimgsrc);
                setup_full_screen_image_url(pinimgsrc);
            }
            return srcind_new;
        };
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
                $thumbs.attr("data-title", thumbAlt);
                pushItem($thumbs[i]);
            }
        } else if ($(".single-product-main-image").length > 0) {
            var singleImg = $(".single-product-main-image img");
            for (var i = 0; i < singleImg.length; i++) {
                var singleImgAlt = $(singleImg[i]).attr("title");
                singleImg.attr("data-title", singleImgAlt);
                var $this = $(".single-product-main-image img");
                pushItem($this);
            }
        }

        // click event
        if ($(".single-product-main-image " + add_slick_slide_class + " img").length > 0) {
            $(document).on("click", ".wooswipe-popup", function (e) {

                // Allow user to open image link in new tab or download it
                if (e.which == 2 || e.ctrlKey || e.altKey) {
                    return;
                }
                var current_active_slick = jQuery(".slick-current.slick-active")[0];
                var ind = jQuery(current_active_slick).attr("data-slick-index");

                e.preventDefault();
                var index = ind ? parseInt(ind) : 0;
                openPswp(index);
            });
        }
    })();
})(document, window, jQuery);

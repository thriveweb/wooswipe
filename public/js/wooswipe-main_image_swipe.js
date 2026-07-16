(function (document, window, $) {
    "use strict";

    $("#wooswipe .woocommerce-main-image").on("click", function (e) {
        e.preventDefault();
    });

    var main_image_swiper = wooswipe_data["product_main_slider"];
    var main_image_slide_nav = wooswipe_data["product_main_slider_nav_arrow"];
    var add_slick_track_class = main_image_swiper ? ".slick-track" : " ";
    var add_slick_slide_class = main_image_swiper ? ".slick-slide" : " ";

    function getAttachmentIdFromThumb($el) {
        return String($el.attr("data-attachment_id") || "").replace(/^main_image_/, "");
    }

    /**
     * Find the thumbnail that matches a WooCommerce variation image.
     * Prefer image_id (reliable); fall back to comparing known image URLs.
     */
    function findThumbForVariation(variation) {
        var $match = $();
        var imageId =
            (variation && variation.image_id) ||
            (variation && variation.image && variation.image.id) ||
            "";

        if (imageId) {
            $("div.thumb[data-slide]").each(function () {
                if (String(imageId) === getAttachmentIdFromThumb($(this))) {
                    $match = $(this);
                    return false;
                }
            });
        }

        if ($match.length) {
            return $match;
        }

        var urls = [];
        if (variation && variation.image) {
            ["url", "src", "full_src", "gallery_thumbnail_src", "thumb_src"].forEach(function (key) {
                if (variation.image[key]) {
                    urls.push(variation.image[key]);
                }
            });
        }

        if (!urls.length) {
            return $match;
        }

        $("div.thumb[data-slide]").each(function () {
            var $thumb = $(this);
            var med = $thumb.attr("data-med");
            var hq = $thumb.attr("data-hq");
            if (urls.indexOf(med) !== -1 || urls.indexOf(hq) !== -1) {
                $match = $thumb;
                return false;
            }
        });

        return $match;
    }

    (function productThumbnails() {
        var plugin_path = wooswipe_wp_plugin_path.templateUrl + "/";
        var addPintrest = wooswipe_data["addpin"];
        var firstUrl;
        var alt;

        if ($(".single-product-main-image img").length > 0) {
            firstUrl = $(".single-product-main-image img").first().attr("src");
            alt = $(".single-product-main-image img").first().attr("alt");
        } else if ($(".wooswipe-placeholder").length > 0) {
            firstUrl = $(".wooswipe-placeholder").attr("src");
            alt = $(".wooswipe-placeholder").attr("alt");
        }
        var link = window.location.href;

        function pinit(url) {
            if (!url) {
                return;
            }
            $(".wooswipe-pinit").attr(
                "href",
                "https://www.pinterest.com/pin/create/button/?media=" +
                    url +
                    "&url=" +
                    link +
                    "&description=" +
                    encodeURI(alt || "")
            );
        }

        if (addPintrest && $(".single-product-main-image").length !== 0) {
            $("#wooswipe").prepend(
                '<a class="wooswipe-pinit wooswipe-mainimagepin" target="_blank" rel="noreferrer noopener" href="https://www.pinterest.com/pin/create/button/?media=' +
                    firstUrl +
                    "&url=" +
                    link +
                    "&description=" +
                    encodeURI(alt || "") +
                    '"><img src="' +
                    plugin_path +
                    'public/pinit/pinterest.svg" alt="Pinterest" /></a>'
            );
            $(".wooswipe-pinit").click(function (e) {
                e.preventDefault();
                window.open(
                    $(this).attr("href"),
                    "popUpWindow",
                    "height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes"
                );
                return false;
            });
        }

        $("#wooswipe").prepend(
            '<a class="wooswipe-popup wooswipe-mainimagepopup" rel="noreferrer noopener" href="' +
                firstUrl +
                '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25.5" height="25.5" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 51 51" style="enable-background:new 0 0 51 51;" xml:space="preserve"><circle cx="25.5" cy="25.5" r="25"  fill="' +
                wooswipe_data["icon_bg_color"] +
                '"></circle><path d="M37.4,20.3c0.8,0,1.3-0.6,1.3-1.3v-5.3c0-0.1,0-0.4-0.2-0.6c-0.2-0.3-0.4-0.6-0.8-0.8c-0.2-0.1-0.4-0.1-0.6-0.1h-5.3  c-0.8,0-1.3,0.6-1.3,1.3c0,0.8,0.6,1.3,1.3,1.3h2.2l-8.6,8.6l-8.6-8.6H19c0.8,0,1.3-0.6,1.3-1.3s-0.6-1.3-1.3-1.3h-5.3  c-0.1,0-0.4,0-0.6,0.1c-0.3,0.2-0.6,0.5-0.8,0.8c-0.1,0.2-0.1,0.5-0.1,0.6V19c0,0.8,0.6,1.3,1.3,1.3s1.3-0.6,1.3-1.3v-2.2l8.6,8.6  l-8.6,8.6v-2.2c0-0.8-0.6-1.3-1.3-1.3c-0.8,0-1.3,0.6-1.3,1.3v5.3c0,0.2,0,0.4,0.1,0.6c0.1,0.3,0.4,0.6,0.8,0.8  c0.2,0.2,0.5,0.2,0.6,0.2H19c0.8,0,1.3-0.6,1.3-1.3c0-0.8-0.6-1.3-1.3-1.3h-2.2l8.6-8.6l8.6,8.6h-2.2c-0.8,0-1.3,0.6-1.3,1.3  c0,0.8,0.6,1.3,1.3,1.3h5.3c0.2,0,0.4,0,0.6-0.2c0.3-0.2,0.6-0.4,0.8-0.8c0.2-0.2,0.2-0.4,0.2-0.6v-5.3c0-0.8-0.6-1.3-1.3-1.3  c-0.8,0-1.3,0.6-1.3,1.3v2.2l-8.6-8.6l8.5-8.6V19C36,19.9,36.5,20.3,37.4,20.3z" fill="' +
                wooswipe_data["icon_stroke_color"] +
                '"></path></svg></a>'
        );

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
            prevArrow:
                '<button class="wooswipe-prev slick-arrow slick-disabled" aria-label="Previous" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" transform="translate(977 529)" fill="' +
                wooswipe_data["icon_bg_color"] +
                '"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="' +
                wooswipe_data["icon_stroke_color"] +
                '"/></g></svg></button>',
            nextArrow:
                '<button class="wooswipe-next slick-arrow" aria-label="Next" type="button"><svg xmlns="http://www.w3.org/2000/svg" id="right" width="20" height="20" viewBox="0 0 80 80"><circle id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" fill="' +
                wooswipe_data["icon_bg_color"] +
                '" /><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M26.387,21.735,7.965,3.314a2.275,2.275,0,0,0-3.217,0L2.6,5.463a2.275,2.275,0,0,0,0,3.213L17.2,23.344,2.6,38.012a2.274,2.274,0,0,0,0,3.213l2.149,2.149a2.275,2.275,0,0,0,3.217,0L26.387,24.952A2.275,2.275,0,0,0,26.387,21.735Z" transform="translate(24.947 16.352)" fill="' +
                wooswipe_data["icon_stroke_color"] +
                '"/></svg></button>',
            responsive: [
                { breakpoint: 680, settings: { slidesToShow: 5 } },
                { breakpoint: 520, settings: { slidesToShow: 4 } },
                { breakpoint: 420, settings: { slidesToShow: 3 } }
            ]
        });

        var prevArrow =
            '<button class="wooswipe-prev slick-arrow slick-disabled" aria-label="Previous" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 80 80"><g id="left" transform="translate(-977 -529)"><circle xmlns="http://www.w3.org/2000/svg" id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" transform="translate(977 529)" fill="' +
            wooswipe_data["icon_bg_color"] +
            '"/><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M2.6,21.735,21.021,3.314a2.275,2.275,0,0,1,3.217,0l2.149,2.149a2.275,2.275,0,0,1,0,3.213l-14.6,14.667,14.6,14.668a2.274,2.274,0,0,1,0,3.213l-2.149,2.149a2.275,2.275,0,0,1-3.217,0L2.6,24.952A2.275,2.275,0,0,1,2.6,21.735Z" transform="translate(1003.067 545.352)" fill="' +
            wooswipe_data["icon_stroke_color"] +
            '"/></g></svg></button>';
        var nextArrow =
            '<button class="wooswipe-next slick-arrow" aria-label="Next" type="button"><svg xmlns="http://www.w3.org/2000/svg" id="right" width="20" height="20" viewBox="0 0 80 80"><circle id="Ellipse_1" data-name="Ellipse 1" cx="40" cy="40" r="40" fill="' +
            wooswipe_data["icon_bg_color"] +
            '" /><path id="Icon_awesome-chevron-left" data-name="Icon awesome-chevron-left" d="M26.387,21.735,7.965,3.314a2.275,2.275,0,0,0-3.217,0L2.6,5.463a2.275,2.275,0,0,0,0,3.213L17.2,23.344,2.6,38.012a2.274,2.274,0,0,0,0,3.213l2.149,2.149a2.275,2.275,0,0,0,3.217,0L26.387,24.952A2.275,2.275,0,0,0,26.387,21.735Z" transform="translate(24.947 16.352)" fill="' +
            wooswipe_data["icon_stroke_color"] +
            '"/></svg></button>';

        if (main_image_slide_nav != true) {
            prevArrow = false;
            nextArrow = false;
        }

        $(".single-product-main-image").slick({
            variableWidth: false,
            dots: false,
            focusOnSelect: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            respondTo: "slider",
            adaptiveHeight: true,
            prevArrow: prevArrow,
            nextArrow: nextArrow,
            responsive: [
                { breakpoint: 680, settings: { slidesToShow: 1 } },
                { breakpoint: 520, settings: { slidesToShow: 1 } },
                { breakpoint: 420, settings: { slidesToShow: 1 } }
            ]
        });

        $(".single-product-main-image").on("swipe", function () {
            var current_slide = $(".single-product-main-image .slick-active").find("a").attr("data-med");
            if (addPintrest) {
                pinit(current_slide);
                setup_full_screen_image_url(current_slide);
            }
        });

        $("#wooswipe .slick-arrow").on("click", function () {
            var current_slide = $(".single-product-main-image .slick-active").find("a").attr("data-med");
            if (addPintrest) {
                pinit(current_slide);
                setup_full_screen_image_url(current_slide);
            }
        });

        $("div.thumb[data-slide]").click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var med = $this.attr("data-med");
            var atid = $this.attr("data-attachment_id");
            var ind = $this.parent().index();
            var mainImage = $(".single-product-main-image #" + atid);

            mainImage
                .attr("data-ind", ind)
                .attr("src", med)
                .attr("srcset", med)
                .attr("width", $this.attr("data-medw"))
                .attr("height", $this.attr("data-medh"))
                .attr("data-hq", $this.attr("data-hq"))
                .attr("data-w", $this.attr("data-w"))
                .attr("data-h", $this.attr("data-h"))
                .attr("data-attachment_id", atid);

            if (addPintrest) {
                pinit(med);
                setup_full_screen_image_url(med);
            }

            $(".single-product-main-image-ul").slick("slickGoTo", ind);
        });

        var mainImage = $(".single-product-main-image " + add_slick_track_class + " img");
        if (mainImage.length && !mainImage.first().closest("a.woocommerce-main-image").length) {
            mainImage.wrap('<a class="woocommerce-main-image zoom" href="#"></a>');
        }
        if (addPintrest && mainImage.length) {
            pinit(mainImage[0].src);
            setup_full_screen_image_url(mainImage[0].src);
        }

        $(".single_variation_wrap").on("show_variation", function (event, variation) {
            var $thumb = findThumbForVariation(variation);
            if (!$thumb.length) {
                return;
            }
            var srcind_new = $thumb.parent().attr("data-slick-index");
            var pinimgsrc = $thumb.attr("data-med");
            if (typeof srcind_new !== "undefined") {
                $(".single-product-main-image-ul").slick("slickGoTo", srcind_new);
            }
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
            var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, {
                index: index,
                shareEl: false
            });
            gallery.init();
        }

        function pushItem(image) {
            if (!image || !image.attributes || !image.attributes["data-hq"]) {
                return;
            }
            items.push({
                src: image.attributes["data-hq"].value,
                w: image.attributes["data-w"].value,
                h: image.attributes["data-h"].value,
                title: image.attributes["data-title"]
                    ? image.attributes["data-title"].value
                    : ""
            });
        }

        if ($(".thumbnails .thumb").length > 0) {
            var $thumbs = $(".thumbnails .thumb");
            for (var i = 0; i < $thumbs.length; i++) {
                var thumbAlt = $($thumbs[i]).find("img").attr("title");
                $($thumbs[i]).attr("data-title", thumbAlt);
                pushItem($thumbs[i]);
            }
        } else if ($(".single-product-main-image").length > 0) {
            var singleImg = $(".single-product-main-image img");
            for (var j = 0; j < singleImg.length; j++) {
                var singleImgAlt = $(singleImg[j]).attr("title");
                $(singleImg[j]).attr("data-title", singleImgAlt);
                pushItem(singleImg[j]);
            }
        } else if ($(".wooswipe-placeholder").length > 0) {
            var placeholder = $(".wooswipe-placeholder");
            for (var k = 0; k < placeholder.length; k++) {
                var placeholderAlt = $(placeholder[k]).attr("title");
                $(placeholder[k]).attr("data-title", placeholderAlt);
                pushItem(placeholder[k]);
            }
        }

        if ($(".single-product-main-image " + add_slick_slide_class + " img").length > 0) {
            $(document).on("click", ".wooswipe-popup", function (e) {
                if (e.which == 2 || e.ctrlKey || e.altKey) {
                    return;
                }
                e.preventDefault();
                var current_active_slick = jQuery(".slick-current.slick-active")[0];
                var ind = jQuery(current_active_slick).attr("data-slick-index");
                openPswp(ind ? parseInt(ind, 10) : 0);
            });
        } else if ($(".wooswipe-placeholder").length > 0) {
            $(document).on("click", ".wooswipe-popup", function (e) {
                if (e.which == 2 || e.ctrlKey || e.altKey) {
                    return;
                }
                e.preventDefault();
                var ind = $(".wooswipe-placeholder").attr("data-ind");
                openPswp(ind ? parseInt(ind, 10) : 0);
            });
        }
    })();
})(document, window, jQuery);

(function (document, window, $) {
    "use strict";

    var main_image_swiper = wooswipe_data["product_main_slider"];
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
            firstUrl = $(".single-product-main-image img").attr("src");
            alt = $(".single-product-main-image img").attr("alt");
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

        if (addPintrest) {
            if ($(".single-product-main-image").length !== 0) {
                $("#wooswipe").prepend(
                    '<a class="wooswipe-pinit" target="_blank" rel="noreferrer noopener" href="https://www.pinterest.com/pin/create/button/?media=' +
                        firstUrl +
                        "&url=" +
                        link +
                        "&description=" +
                        encodeURI(alt || "") +
                        '"><img src="' +
                        plugin_path +
                        'public/pinit/pinterest.svg" alt="Pinterest" /></a>'
                );
            }
            if ($(".wooswipe-placeholder").length !== 0) {
                $("#wooswipe").prepend(
                    '<a class="wooswipe-pinit" target="_blank" rel="noreferrer noopener" href="https://www.pinterest.com/pin/create/button/?media=' +
                        firstUrl +
                        "&url=" +
                        link +
                        "&description=" +
                        encodeURI(alt || "") +
                        '"><img src="' +
                        plugin_path +
                        'public/pinit/pinterest.svg" alt="Pinterest" /></a>'
                );
            }
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
        }

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

        $(".thumbnails .thumb").click(function (e) {
            e.preventDefault();
            var med = replace_mainimage_thumb_change($(this));
            if (addPintrest) {
                pinit(med);
            }
        });

        function replace_mainimage_thumb_change($this) {
            var med = $this.attr("data-med");
            var title = $this.attr("data-title");
            var width = $this.attr("data-medw");
            var height = $this.attr("data-medh");
            var hq = $this.attr("data-hq");
            var hqw = $this.attr("data-w");
            var hqh = $this.attr("data-h");
            var atid = $this.attr("data-attachment_id");
            var ind = $this.parent().index();
            var mainImage = $(".single-product-main-image img");

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
                .attr("alt", title)
                .attr("title", title);
            return med;
        }

        var mainImage = $(".single-product-main-image img");
        if (mainImage.length && !mainImage.closest("a.woocommerce-main-image").length) {
            mainImage.wrap('<a class="woocommerce-main-image zoom" href="#"></a>');
            if (!mainImage.closest(".single-product-main-image").length) {
                $(".woocommerce-main-image").wrap('<div class="single-product-main-image"></div>');
            }
            if (addPintrest) {
                pinit(mainImage[0].src);
            }
        }

        var placeholderImage = $(".wooswipe-placeholder");
        if (placeholderImage.length && !placeholderImage.closest("a.woocommerce-main-image").length) {
            placeholderImage.wrap('<a class="woocommerce-main-image zoom" href="#"></a>');
            if (!placeholderImage.closest(".single-product-main-image").length) {
                placeholderImage.closest("a.woocommerce-main-image").wrap('<div class="single-product-main-image"></div>');
            }
            if (addPintrest) {
                pinit(placeholderImage[0].src);
            }
        }

        $(".single_variation_wrap").on("show_variation", function (event, variation) {
            var $thumb = findThumbForVariation(variation);
            if (!$thumb.length) {
                return;
            }
            var med = replace_mainimage_thumb_change($thumb);
            if (addPintrest) {
                pinit(med);
                setup_full_screen_image_url(med);
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
        }

        if ($(".single-product-main-image " + add_slick_slide_class + " img").length > 0) {
            $(".single-product-main-image " + add_slick_slide_class + " img").click(function (e) {
                if (e.which == 2 || e.ctrlKey || e.altKey) {
                    return;
                }
                e.preventDefault();
                var ind = $(this).attr("data-ind");
                openPswp(ind ? parseInt(ind, 10) : 0);
            });
        }
    })();
})(document, window, jQuery);

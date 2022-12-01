jQuery(document).ready(function () {
  jQuery("input#icon_bg_color").change(function () {
    var bgcolor = jQuery(this).val();
    jQuery(".icons-preview-list li").each(function () {
      jQuery(this).find('svg').each(function () { jQuery(this).find('circle').attr('fill', bgcolor) });

    });
  });
  jQuery("input#icon_stroke_color").change(function () {
    var strokecolor = jQuery(this).val();
    jQuery(".icons-preview-list li").each(function () {
      jQuery(this).find('svg').each(function () { jQuery(this).find('path').attr('fill', strokecolor) });

    });
  });

  jQuery("#product_main_slider[type=checkbox]").change(function () {
    if (jQuery(this).prop("checked") == true) {
      jQuery(".main_slide_nav").slideDown();
    }else{
      jQuery(".main_slide_nav").slideUp();
    }
  });
  
});

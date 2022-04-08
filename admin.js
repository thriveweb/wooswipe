jQuery(document).ready(function () {
  jQuery("input#icon_bg_color").change(function () {
    var bgcolor = jQuery(this).val();
    jQuery(".icons-preview-list li").each(function () {
      jQuery(this).find('svg').children('ellipse').attr('fill', bgcolor);
      jQuery(this).find('svg').each(function () { jQuery(this).find('circle').attr('fill', bgcolor) });

    });
  });
  jQuery("input#icon_stroke_color").change(function () {
    var strokecolor = jQuery(this).val();
    jQuery(".icons-preview-list li").each(function () {
      jQuery(this).find('svg').each(function () { jQuery(this).find('path').attr('fill', strokecolor) });

    });
  });
  
});

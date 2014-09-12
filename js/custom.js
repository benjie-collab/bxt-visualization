var tosmaxwidth=400
var tosmaxheight=600
jQuery(window).on('resize',function() {
	var toswidth = window.innerWidth-50;
	if (toswidth > tosmaxwidth) {
	toswidth=tosmaxwidth;
	}
	var tosheight = window.innerHeight-50;
	if (tosheight > tosmaxheight) {
	tosheight=tosmaxheight;
	}
	var toslink = "http://example.com/wp-content/plugins/wp-greet/wpg_service.php?height=" + tosheight + "&width=" + toswidth;
	jQuery(".thickbox").attr("href",toslink);
});
jQuery(document).ready(function() {
    jQuery(window).trigger('resize');
});
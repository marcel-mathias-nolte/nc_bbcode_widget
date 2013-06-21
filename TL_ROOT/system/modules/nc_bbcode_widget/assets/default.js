jQuery(document).ready(function()
{
	jQuery("textarea.bbcode").bbcode(
	{
		tag_bold      : true,
		tag_italic    : true,
		tag_underline : true,
		tag_link      : false,
		tag_image     : false,
		button_image  : true,
		image_url     : 'system/modules/nc_bbcode_widget/assets/'
	});
	bbcode_process();
});

var bbcode_value = "";
function bbcode_process()
{
	var el = jQuery("textarea.bbcode");
	if (bbcode_value != el.val())
	{
		bbcode_value = el.val();
		jQuery.get(
			'system/modules/nc_bbcode_widget/assets/bbParser.php',
			{
				bbcode: bbcode_value,
				valid_tags: 'b,i,u,s,list,center'
			},
			function(txt)
			{
				jQuery('#bbcode_preview').html(txt);
			}
		);
	}
	setTimeout("bbcode_process()", 2000);
}

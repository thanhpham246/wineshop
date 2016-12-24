jQuery(function(jQuery) {  
	/************** Start upload Image For Shortcode **************/
    jQuery('.custom_upload_image_text').live('dblclick',function() {  
		var current_input = jQuery(this);
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');  
		
		old_window_to_editor = window.send_to_editor;
		
        window.send_to_editor = function(html) {  
			var _current_obj = jQuery('img',html);
			if( _current_obj.length <= 0 )
				_current_obj = jQuery(html);		
            imgurl = _current_obj.attr('src');  
            classes = _current_obj.attr('class');  
            id = classes.replace(/(.*?)wp-image-/, '');  
            current_input.val(imgurl);  
            tb_remove(); 
			window.send_to_editor = old_window_to_editor;			
        }  
        return false;  
    });  
	
	/************** End upload Image For Shortcode ****************/
	
    jQuery('.custom_upload_image_button').click(function() {  
        formfield = jQuery(this).siblings('.custom_upload_image');  
        preview = jQuery(this).siblings('.custom_preview_image');  
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');  
		
		old_window_to_editor = window.send_to_editor;
		
        window.send_to_editor = function(html) {  
			var _current_obj = jQuery('img',html);
			if( _current_obj.length <= 0 )
				_current_obj = jQuery(html);		
            imgurl = _current_obj.attr('src');  
            classes = _current_obj.attr('class');  
            id = classes.replace(/(.*?)wp-image-/, '');  
            formfield.val(imgurl);  
            preview.attr('src', imgurl);  
            tb_remove();  
			window.send_to_editor = old_window_to_editor;	
        }  
        return false;  
    });  	
	
    jQuery('.custom_clear_image_button').click(function() {  
        //var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();  
		var defaultImage = template_path + '/images/no-logo.png';
        jQuery(this).parent().siblings('.custom_upload_image').val(' ');  
        jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);  
        return false;  
    });  	
	
	// jQuery('input.edit-menu-item-wide-custom-color').each(function(index,element){
		// jQuery(element).ColorPicker({
			// onChange: function (hsb, hex, rgb) {
				// jQuery(element).val('#' + hex);
			// }
		// });
	// });

	
	
	//if we have wd menu
	if(jQuery('.edit-menu-item-wide-style').length > 0){
		jQuery('.edit-menu-item-wide-style').each(function(index,element){
			wide_style = jQuery(element).val();
			if(wide_style == 1){
				jQuery(element).parent().parent().siblings('.wd-custom-menu').show();
			}else{
				jQuery(element).parent().parent().siblings('.wd-custom-menu').hide();
			}
			jQuery(element).change(function(){
				ele_wide_style = jQuery(this).val();
				if(ele_wide_style == 1){
					jQuery(this).parent().parent().siblings('.wd-custom-menu').show();
				}else{
					jQuery(this).parent().parent().siblings('.wd-custom-menu').hide();
				}
			
			
			});
		});
		
		
		if(jQuery('.edit-menu-item-wide-default-color').length > 0){
			jQuery('.edit-menu-item-wide-default-color').each(function(index,element){
				default_style = jQuery(element).val();
				wide_style_enable = jQuery(element).parent().parent().siblings('.wd-custom-menu-control').find('.edit-menu-item-wide-style').val();
				if(wide_style_enable == 1){
					if(default_style == 'custom'){
						jQuery(element).parent().parent().siblings('.wd-custom-color-menu').show();
					}else{
						jQuery(element).parent().parent().siblings('.wd-custom-color-menu').hide();
					}
				}
				jQuery(element).change(function(){
					ele_default_style = jQuery(this).val();
					if(ele_default_style == 'custom'){
						jQuery(this).parent().parent().siblings('.wd-custom-color-menu').show();
					}else{
						jQuery(this).parent().parent().siblings('.wd-custom-color-menu').hide();
					}
				
				
				});
			});
		
		}
		
		if(jQuery('ul#menu-to-edit').find('li').length > 0){
			jQuery('ul#menu-to-edit > li').click(function(){
				var cur_li_class = jQuery(this).attr('class');
				if(cur_li_class.indexOf('menu-item-depth-0') < 0){
					jQuery(this).find('.menu-item-settings').find('p.wd-add-on').hide();
				}else{
					var wide_enable = jQuery(this).find('.edit-menu-item-wide-style').val();
					if(wide_enable == 0){
						jQuery(this).find('.wd-custom-menu-control').show();
					}else{
						var custom_color_enable = jQuery(this).find('.edit-menu-item-wide-default-color').val();
						if(custom_color_enable != 'custom'){
							jQuery(this).find('.menu-item-settings').find('p.wd-add-on').not('p.field-wide-custom-color').show();
						}else{
							jQuery(this).find('.menu-item-settings').find('p.wd-add-on').show();
						}
					}
					
					
				}
			});
		
		}
	}
}); 
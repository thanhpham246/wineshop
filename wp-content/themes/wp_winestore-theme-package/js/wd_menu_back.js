//input : current li item : jquery object
//output : top parrent of current item : jquery object
function find_top_parent(current_element){
	li_top_parrent = current_element.prevUntil('.menu-item-depth-0');
	if(li_top_parrent.length <= 0){
		li_top_parrent = current_element.prev();
	}else{
		array_len = li_top_parrent.length-1;
		li_top_parrent = li_top_parrent.eq(array_len).prev();
	}
	return li_top_parrent;
}


//input : current li item : jquery object
//output : children list of current item : jquery object
function find_all_child(current_element){
	li_children_arr = current_element.nextUntil('.menu-item-depth-0');
	return li_children_arr;
}

//input : menu li class
//output : menu level
// root : 0
// lv 1 : 1
// lv 2 : 2
// lv 3 and higher : 3

function get_menu_level( d_class_name ){
	if( typeof(d_class_name) != "undefined" ){
		if( d_class_name.indexOf('menu-item-depth-0') >= 0 ){
			return 0;
		}else if( d_class_name.indexOf('menu-item-depth-1') >= 0 ){
			return 1;
		}else if( d_class_name.indexOf('menu-item-depth-2') >= 0 ){
			return 2;
		}else{
			return 3;
		}
	}else{
		return -1;
	}

}

jQuery(function(jQuery) {  	
	
	/******************************MENU-THUMBNAILS*********************************/
	
	//handle add image button
    // jQuery('.custom_upload_image_button_mega').each(function(index,element){
		// jQuery(element).live('click',function() {  
			// current_add_ele = jQuery(this);
			// current_rmv_ele = jQuery(this).siblings('a.custom_clear_image_button_mega');
			// preview = jQuery(this).siblings('span.edit-menu-item-thumbnail-wrapper');
			// thumbnail_value = jQuery(this).siblings('.edit-menu-item-thumbnail');  
			// nav_item_id = jQuery(this).attr('id');
			// tb_show('', 'media-upload.php?type=image&post_id='+nav_item_id+'&TB_iframe=true&width=670&height=380');  
			// window.send_to_editor = function(html) {  
				// imgurl = jQuery('img',html).attr('src');  
				// classes = jQuery('img', html).attr('class');  
				// id = classes.replace(/(.*?)wp-image-/, '');   
				// jQuery.ajax({
					// type: "POST",
				    // url : ajaxurl, 
				    // data: {
					   // 'action':'find_media_thumbnail',
					   // 'thumbnail_id':id
				    // }, 
				    // success : function(response){
						// imgurl = response;
						// preview.html('<img src="'+imgurl+'" width="32" height="32" >'); 
						// thumbnail_value.val(imgurl);
				    // },
					// error: function(response){
						// preview.html('<img src="'+imgurl+'" width="32" height="32" >'); 
						// thumbnail_value.val(imgurl);
					// }
				// });
				// current_add_ele.hide();
				// current_rmv_ele.show();
				// tb_remove();  
			// }  
			// return false;  
		// }); 
	// }); 
  

		jQuery('.custom_upload_image_button_mega').live('click',function() {  
			current_add_ele = jQuery(this);
			current_rmv_ele = jQuery(this).siblings('a.custom_clear_image_button_mega');
			preview = jQuery(this).siblings('span.edit-menu-item-thumbnail-wrapper');
			thumbnail_value = jQuery(this).siblings('.edit-menu-item-thumbnail');  
			thumbnail_id_value = jQuery(this).siblings('.edit-menu-item-thumbnail-id');  
			nav_item_id = jQuery(this).attr('id');
			tb_show('', 'media-upload.php?type=image&post_id='+nav_item_id+'&TB_iframe=true&width=670&height=380');  
			window.send_to_editor = function(html) {  
				var _current_obj = jQuery('img',html);
				if( _current_obj.length < 0 )
					_current_obj = jQuery(html);
				imgurl = _current_obj.attr('src');  
				classes = _current_obj.attr('class');  
				id = classes.replace(/(.*?)wp-image-/, '');  
				thumbnail_id_value.val(id);
				jQuery.ajax({
					type: "POST",
				    url : ajaxurl, 
				    data: {
					   'action':'find_media_thumbnail',
					   'thumbnail_id':id
				    }, 
				    success : function(response){
						imgurl = response;
						preview.html('<img src="'+imgurl+'" width="32" height="32" >'); 
						thumbnail_value.val(imgurl);
				    },
					error: function(response){
						preview.html('<img src="'+imgurl+'" width="32" height="32" >'); 
						thumbnail_value.val(imgurl);
					}
				});
				current_add_ele.hide();
				current_rmv_ele.show();
				tb_remove();  
			}  
			return false;  
		}); 

		jQuery('.custom_clear_image_button_mega').live('click',function() {  
			current_rmv_ele = jQuery(this);
			current_add_ele = jQuery(this).siblings('a.custom_upload_image_button_mega');
			preview = jQuery(this).siblings('span.edit-menu-item-thumbnail-wrapper');
			thumbnail_value = jQuery(this).siblings('.edit-menu-item-thumbnail');  
			thumbnail_id_value = jQuery(this).siblings('.edit-menu-item-thumbnail-id');  
			preview.html('');
			thumbnail_value.val('');  
			thumbnail_id_value.val('');
			current_add_ele.show();
			current_rmv_ele.hide();
			return false;  
		}); 
	//handle remove image button
	// jQuery('.custom_clear_image_button_mega').each(function(index,element){
		// jQuery(element).live('click',function() {  
			// current_rmv_ele = jQuery(this);
			// current_add_ele = jQuery(this).siblings('a.custom_upload_image_button_mega');
			// preview = jQuery(this).siblings('span.edit-menu-item-thumbnail-wrapper');
			// thumbnail_value = jQuery(this).siblings('.edit-menu-item-thumbnail');  
			// preview.html('');
			// thumbnail_value.val('');  
			// current_add_ele.show();
			// current_rmv_ele.hide();
			// return false;  
		// }); 
	// }); 
	
	/******************************MENU-THUMBNAILS-END*********************************/
 
	/******************************MENU-COLOR*********************************/
	// jQuery('input.edit-menu-item-wide-custom-color').each(function(index,element){
		// jQuery(element).ColorPicker({
			// onChange: function (hsb, hex, rgb) {
				// jQuery(element).val('#' + hex);
			// }
		// });
	// });

	jQuery('.colorpicker-menu').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			//jQuery('body').css('background-color',ev.color.toHex());				
	});	
	
	/******************************MENU-COLOR-END*********************************/

	
	
	
	/******************************MENU-CONTROL*********************************/
	//if we have wd menu
	if(jQuery('p.field-wide-style').length > 0){
		jQuery('p.field-wide-style').each(function(index,element){
			//tim cac element lv 0,show check style
			//neu open mega menu thi moi show thanh fan column
			wide_style = jQuery(element).find('select').val();
			li_parrent = jQuery(element).parent().parent();
			li_parrent_class = li_parrent.attr('class');
			//menu ko phai o lv 0,hide select mega menu
			// if( li_parrent_class.indexOf('menu-item-depth-1') >= 0 || li_parrent_class.indexOf('menu-item-depth-2') >= 0 ){
				// li_parrent.find('.wd-add-on-lv0').hide();
				// //lay gia tri parrent mega menu
				// menu_li_parrent = li_parrent.prevUntil('.menu-item-depth-0');
				
				// //neu item lien ke parent
				// if(menu_li_parrent.length <= 0){
					// menu_li_parrent = li_parrent.prev();
				// }else{
					// array_len = menu_li_parrent.length-1;
					// menu_li_parrent = menu_li_parrent.eq(array_len).prev();
				// }
				// //neu top parent mega
				// wide_style = jQuery(menu_li_parrent).find('select').val();
				// if(wide_style == 1){
					// jQuery(element).siblings('.parrent-active').show();
					// jQuery(element).siblings('.wd-add-on-lv0').not('.wd-add-on-lv1').hide();
				// }else{
				// //top parent ko mega
					// jQuery(element).siblings('.parrent-active').hide();
					// jQuery(element).siblings('.wd-add-on-lv0').hide();
				// }

			// }else if(li_parrent_class.indexOf('menu-item-depth-0') >= 0){
			// //lv 0
				// if(wide_style == 1){
					// jQuery(element).siblings('.parrent-active').hide();
					// jQuery(element).siblings('.wd-add-on-lv0').show();
				// }else{
					// jQuery(element).siblings('.wd-add-on-lv0').hide();
					// jQuery(element).siblings('.parrent-active').hide();
					// jQuery(element).show();
				// }
			// }else{
			// //lv3 and higher,show nothing
				// jQuery(element).hide();
				// jQuery(element).siblings('.wd-custom-menu').hide();
			
			// }


			jQuery(element).find('select').change(function(){
				//tim cac element lv 0,show check style
				//neu open mega menu thi moi show thanh fan column
				wide_style = jQuery(element).find('select').val();
				li_parrent = jQuery(element).parent().parent();
				li_parrent_class = li_parrent.attr('class');
				//menu lv 0
				if(li_parrent_class.indexOf('menu-item-depth-0') >= 0){
					//neu bat mega,show toan bo
					if(wide_style == 1){
						menu_li_child = li_parrent.nextUntil('.menu-item-depth-0');
						//neu ko child
						if(menu_li_child.length <= 0){
							jQuery(element).siblings('.parrent-active').hide();
							jQuery(element).siblings('.wd-add-on-lv0').show();						
						}else{
							jQuery(element).siblings('.parrent-active').hide();
							jQuery(element).siblings('.wd-add-on-lv0').show();		
							jQuery(menu_li_child).each(function(index,subelement){
								if(jQuery(subelement).attr('class').indexOf('menu-item-depth-1') >= 0 || jQuery(subelement).attr('class').indexOf('menu-item-depth-2') >= 0 ){
									jQuery(subelement).find('.parrent-active').show();
								}else{
									jQuery(subelement).find('.wd-custom-menu').hide();
								}

							});

						}
					}else{
					//hide toan bo
						menu_li_child = li_parrent.nextUntil('.menu-item-depth-0');
						//neu ko child
						if(menu_li_child.length <= 0){
							jQuery(element).siblings('.parrent-active').hide();
							jQuery(element).siblings('.mega-active').hide();
						
						}else{
							jQuery(element).siblings('.parrent-active').hide();
							jQuery(element).siblings('.mega-active').hide();
							jQuery(menu_li_child).each(function(index,subelement){
									jQuery(subelement).find('.wd-custom-menu').hide();
							});
						}
					}

				}else{
				//lv1 and higher,show nothing
					jQuery(element).hide();
					jQuery(element).siblings('.wd-custom-menu').hide();
				
				}
			});
		});

		jQuery('a.item-edit').live('mouseup',function(){
			jQuery(this).parent().parent().parent().parent().trigger('click');
		});

		
		

		jQuery('ul#menu-to-edit > li').live('click',function(event){
			if( event.target.className.indexOf('edit-menu-item-sidebars') > -1 ){
				return ;
			}
				var _this_class = jQuery(this).attr('class');
				//var menu_level = get_menu_level(_this_class);
				var mega_active = 0;
				if( _this_class.indexOf('menu-item-depth-0') >= 0 ){
					//lv 0
					mega_active = jQuery(this).find('p.field-wide-style').find('select').val();
					search_style = jQuery(this).find('p.field-search-style').find('select').val();
					menu_li_child = jQuery(this).nextUntil('.menu-item-depth-0');
					if(mega_active == 1){
						//neu ko child
						if(menu_li_child.length <= 0){
							jQuery(this).find('.parrent-active').hide();
							jQuery(this).find('.wd-add-on-lv0').show();						
						}else{
							jQuery(this).find('.parrent-active').hide();
							jQuery(this).find('.wd-add-on-lv0').show();		
							jQuery(menu_li_child).each(function(index,subelement){
								if( get_menu_level(jQuery(subelement).attr('class')) == 1 || get_menu_level(jQuery(subelement).attr('class')) == 2 ){
									jQuery(subelement).find('.parrent-active').show();
								}else{
									jQuery(subelement).find('.wd-custom-menu').hide();
								}
							});
						}
						if( search_style == 1 ){
							jQuery(this).find('.depend-field-search-style').hide();	
						}						
					}else{
						if(menu_li_child.length <= 0){
							jQuery(this).find('.wd-add-on-lv0').show();		
							jQuery(this).find('.parrent-active').hide();
							jQuery(this).find('.mega-active').hide();
						
						}else{
							jQuery(this).find('.wd-add-on-lv0').show();		
							jQuery(this).find('.parrent-active').hide();
							jQuery(this).find('.mega-active').hide();
							jQuery(menu_li_child).each(function(index,subelement){
									jQuery(subelement).find('.wd-custom-menu').hide();
							});
						}					
					}
				}else if( _this_class.indexOf('menu-item-depth-1') >= 0 ){
					// lv 1  
					parrent_li = find_top_parent(jQuery(this));
					mega_active = parrent_li.find('p.field-wide-style').find('select').val();
					parent_column = parrent_li.find('p.field-wide-column').find('select').val();
					if(mega_active == 1){
						jQuery(this).find('.wd-add-on-lv0').hide();	
						jQuery(this).find('.parrent-active').hide();	
						jQuery(this).find('.wd-add-on-lv1').show();
						if( parent_column != '0' ){
							jQuery(this).find('.depend-field-wide-column').hide();	
						}
					}else{
						jQuery(this).find('.wd-custom-menu').hide();
					}
				
				}else if( _this_class.indexOf('menu-item-depth-2') >= 0 ){
					// lv 2   
					parrent_li = find_top_parent(jQuery(this));
					mega_active = parrent_li.find('p.field-wide-style').find('select').val();
					if(mega_active == 1){
						jQuery(this).find('.wd-add-on-lv0').hide();	
						jQuery(this).find('.parrent-active').hide();	
						jQuery(this).find('.wd-add-on-lv2').show();
					}else{
						jQuery(this).find('.wd-custom-menu').hide();
					}
				}else{
					jQuery(this).find('.wd-custom-menu').hide();
				}
				
		});

		jQuery('.edit-menu-item-search-style').live('change',function(){
			if( jQuery(this).val() == 1 ){
				jQuery(this).parent().parent().parent().find('.depend-field-search-style').hide();
			}else{
				jQuery(this).parent().parent().parent().find('.depend-field-search-style').show();	
			}
		});		
		/******************************MENU-CONTROL-END*********************************/
	}
	
  
}); 

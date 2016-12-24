<?php
	global $df_single_post_config,$df_archive_page_config,$df_single_product_config,$df_category_product_config,$df_custom_style_config,$df_mega_menu_config,$df_size;
	global $wd_custom_size,$archive_page_config,$single_product_config,$category_product_config,$custom_style_config,$mega_menu_config;
	
	$df_single_post_config = array(
					'show_category' 						=> 1
					,'show_author_post_link' 				=> 1
					,'show_time' 							=> 1
					,'show_tags' 							=> 1
					,'show_comment_count' 					=> 1
					,'show_social' 							=> 1
					,'show_author' 							=> 1
					,'show_related' 						=> 1
					,'related_label' 						=> __("Related Posts",'wpdance')
					,'show_comment_list' 					=> 1				
					,'comment_list_label' 					=> __("Responds",'wpdance')				
					,'num_post_related' 					=> 3
					,'show_category_phone' 					=> 1
					,'show_author_post_link_phone' 			=> 1
					,'show_time_phone' 						=> 1
					,'show_tags_phone' 						=> 1
					,'show_comment_count_phone' 			=> 1
					,'show_social_phone' 					=> 1
					,'show_author_phone' 					=> 1
					,'show_related_phone' 					=> 1
					,'show_comment_list_phone' 				=> 1						
	);	
	
	
	$df_archive_page_config	=	array(
					'show_category' 					=> 1
					,'show_author_post_link' 			=> 1
					,'show_time' 						=> 1
					,'show_tags' 						=> 1
					,'show_comment_count' 				=> 1
					,'show_excerpt' 					=> 1
					,'show_thumb' 						=> 1
					,'show_content' 					=> 1
					,'show_read_more' 					=> 1		
					,'show_category_phone' 				=> 1
					,'show_author_post_link_phone' 		=> 1
					,'show_time_phone' 					=> 1
					,'show_tags_phone' 					=> 1
					,'show_comment_count_phone' 		=> 1
					,'show_excerpt_phone'				=> 1
					,'show_thumb_phone' 				=> 1
					,'show_content_phone' 				=> 1
					,'show_read_more_phone' 			=> 1						
	);				
		

	$df_single_product_config = array(
					'show_image' 			=> 1
					,'show_label' 			=> 1
					,'show_title' 			=> 1
					,'show_sku' 			=> 1
					,'show_review' 			=> 1
					,'show_availability' 	=> 1
					,'show_add_to_cart' 	=> 1
					,'show_price' 			=> 1
					,'show_short_desc'		=> 1
					,'show_meta' 			=> 1
					,'show_related' 		=> 1
					,'show_sharing'			=> 1
					,'related_title' 		=> __("Related Products","wpdance")
					,'sharing_title' 		=> __("Share this",'wpdance')
					,'sharing_intro' 		=> __("Love it?Share with your friend",'wpdance')
					,'sharing_custom_code' 	=> ""
					,'show_ship_return' 	=> 1				
					,'ship_return_title' 	=> __('FREE SHIPPING & RETURN'	,'wpdance')
					,'ship_return_content' 	=>  htmlentities('<a href="#"><img src="http://demo.wpdance.com/imgs/woocommerce/return_shipping.png" alt="free shipping and return" title="free shipping and return"></a><div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'."'".'s standard dummy text ever since the 1500s</div>')
					,'show_tabs' 			=> 1
					,'show_custom_tab' 		=> 1	
					,'custom_tab_title' 	=> "Custom Title"				
					,'custom_tab_content' 	=> "<div>Table content goes here</div>"				
					,'show_upsell' 			=> 1
					,'upsell_title'			=> __("YOU MAY ALSO BE INTERESTED IN THE FOLLOWING PRODUCT(S)",'wpdance')
					,'layout' 				=> '0-1-0'
					,'left_sidebar' 		=> 'product-widget-area'
					,'right_sidebar' 		=> 'product-widget-area'				
		);	
		
	$df_category_product_config = array(
					'cat_columns' 				=> 2
					,'cat_layout' 				=> "1-1-0"
					,'cat_left_sidebar' 		=> "category-widget-area"
					,'cat_right_sidebar' 		=> "category-widget-area"	
					,'cat_custom_content'		=> ''
	);		
	
	$df_custom_style_config = array(
						'enable_custom_preview' 		=> 0
						,'enable_custom_font' 			=> 0
						,'enable_custom_color' 			=> 0
						,'page_layout' 					=> 'wide'
						,'font_sort' 					=>  "popularity"
						
						/******** Body font *******/
						,"body_font_name" 				=> "-1"
						,"body_font_style"				=> "normal"
						,"body_font_style_str" 			=> ""
						,"body_font_weight" 			=> "normal"

						
						/******** Heading font *******/
						,"heading_font_name" 			=> "-1"
						,"heading_font_style" 			=> "normal"
						,"heading_font_style_str" 		=> ""
						,"heading_font_weight" 			=> "normal"	
						
						/******** Menu font *******/
						,"menu_font_name" 				=> "-1"
						,"menu_font_style" 				=> "normal"
						,"menu_font_style_str" 			=> ""
						,"menu_font_weight" 			=> "bold"
						

						,'theme_color' 					=> "#141414"
						,'heading_color' 				=> "#141414"
						,'text_color' 					=> "#646464"
						,'link_color' 					=> "#141414"
						,'button_background' 			=> "#141414"
						,'button_text_color' 			=> "#fff"
						,'border_color' 				=> "#d5d5d5"
						
						,'header_menu_background'		=> "#141414"
						,'header_menu_text_color'		=> '#fff'
						,'header_sub_menu_background'	=> ''
						,'header_sub_menu_text_color'	=> ''
						,'sub_menu_hover_bg'			=> '#6A84B9'
						
						
						,'footer_background'			=> '#fafafa'
						,'footer_border'				=> '#e6e6e6'
						,'footer_heading_color'			=> '#323232'
						,'footer_text_color'			=> '#646464'						
						
						,'sidebar_heading_text_color'	=> '#141414'
						,'filter'						=> '#141414'
						,'catagories_current_item_color'=> '#6a84b9'
	

						,'feedback_background'			=> '#141414'
						,'totop_background'				=> '#141414'
						,'scollbar'						=> '#141414'
						,'sale_background_color'		=> '#cc4c51'		
						,'sale_text_color'				=> '#fff'
						,'feature_background_color'		=> '#72284c'
						,'feature_text_color'			=> '#fff'
						,'rating_color'					=> '#EEAA4E'		
	);		
		
		
	$df_mega_menu_config = array(
			'area_number' 				=> 1
			,'thumbnail_width' 			=> 16
			,'thumbnail_height' 		=> 16
			,'menu_text' 				=> __("Menu",'wpdance')
			,'disabled_on_phone' 		=> 0
	);		
		
	
	$df_size = array(
							array(1200,450)
							,array(960,350)
							,array(190,122)
	);
	
	$wd_custom_size = get_option(THEME_SLUG.'custom_size','');
	if( strlen($wd_custom_size) > 0 ){
		$wd_custom_size = unserialize($wd_custom_size);
	}else{
		$wd_custom_size = $df_size ;
	}					

?>
<?php
	function wd_font_string_to_font_obj( $font_name = "" ,$font_style_str = "" ,$font_size = "" ){
		if( strlen( $font_style_str ) > 0 ){
			$font_weight = strcmp( $font_style_str,'regular' ) == 0 ? '400' : $font_style_str;
			$font_weight = strcmp( $font_style_str,'italic' ) == 0 ? '400italic' : $font_style_str;
			$font_style = strpos($font_weight, 'italic') == false ? 'normal' : 'italic';
			$font_weight = str_replace( "italic", "", $font_weight );
			return $ret = array(
								"font_name" => $font_name
								,"font_weight" => $font_weight
								,"font_style" => $font_style
								,"font_size" => $font_size
							);
		}
		return $ret = array(
							"font_name" => $font_name
							,"font_weight" => ""
							,"font_style" => ""
							,"font_size" => $font_size		
		);
	}

	global $wd_default_custom_style_config,$wd_custom_style_config;
	$wd_default_custom_style_config = array(
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
						,"menu_font_weight" 			=> "normal"
						
						/******** Menu font *******/
						,"sub_menu_font_name" 				=> "-1"
						,"sub_menu_font_style" 				=> "normal"
						,"sub_menu_font_style_str" 			=> ""
						,"sub_menu_font_weight" 			=> "normal"

						,'primary_color' 				=> "#000"
						,'primary_second_color'				=> '#d70000'
						,'primary_background_color'				=> '#fff'
						,'heading_color' 				=> "#000"
						,'primary_text_color' 					=> "#000"
						,'border_color_primary' 					=> "#cbcbcb"
						,'primary_link_color' 					=> "#000"
						
						,'button_background' 			=> "#d70000"
						,'button_text_color' 			=> "#fff"
						,'button_border_color'			=> "#d70000"
						//,'border_color' 				=> "#d5d5d5"
						
						,'button_second_background' 	=> "#fff"
						,'button_second_text_color' 	=> "#000"
						,'border_second_button' 		=> "#d70000"
						
						,'background_tab' 				=> "#FFF"
						,'tab_text_color' 				=> "#000"		
						,'tab_border_color'					=> '#cbcbcb'
						,'tab_text_color_active'				=> '#fff'
						,'tab_background_color_active'				=> '#000'
						,'tab_border_color_active'				=> '#000'
						
						
						
						
						
						,'header_top_text_color'				=> '#000'
						
						,'header_bottom_background'				=> '#fff'
						,'header_bottom_text_color'				=> '#000'
						,'header_border_bottom_color'				=> '#cbcbcb'
						,'header_menu_text_color'				=> '#000'
						,'header_menu_background'		=> "#fff"
						//,'header_menu_text_color'		=> '#000'
						//,'header_sub_menu_background'	=> ''
						,'header_submenu_link_text_color'	=> '#202020'
						,'header_submenu_text_color'				=> '#202020'
						,'header_submenu_border_color'				=> '#cbcbcb'
						,'header_submenu_background_hover'				=> '#e6e6e8'
						,'header_submenu_background_color'				=> '#fff'
						
						,'accordion_text_color'				=> '#000'
						,'accordion_background_color'				=> '#fff'
						
						,'footer_first_area_background_color'			=> '#fff'
						,'footer_border_color'				=> '#cbcbcb'
						,'footer_second_area_background_color'			=> '#fff'
			//			,'footer_area_border_color'			=> '#000'						
						,'footer_first_area_text_color'					=> '#000'
						,'footer_first_area_heading_color'					=> '#000'
						,'footer_second_area_text_color'					=> '#000'
						,'footer_second_area_heading_color'					=> '#000'
						,'footer_thrid_area_text_color'					=> '#000'
						,'footer_thrid_area_background'					=> '#fff'
			//			,'footer_four_area_text_color'					=> '#000'
			//			,'footer_four_area_heading_color'					=> '#000'
			//			,'coppy_right_backgound_color'					=> '#fff'
			//			,'coppy_right_text'					=> '#000'
			//			,'coppy_right_border'					=> '#cbcbcb'						
						
						,'sidebar_text_color'	=> '#000'
						,'sidebar_border_color'	=> '#b2b2b2'
						,'sidebar_link_color'	=> '#d70000'
						,'icon_color'						=> '#d7000'
						,'filter'						=> '#2a2a2a'
						,'sidebar_heading_color'=> '#000'
	

						,'feedback_background'			=> '#000'
						,'totop_background'				=> '#000'
						,'feedback_color_hover'						=> '#d70000'
					//	,'sale_background_color'		=> '#cc4c51'		
					//	,'sale_text_color'				=> '#fff'
					//	,'feature_background_color'		=> '#d70000'
					//	,'feature_text_color'			=> '#fff'
						,'rating_color'					=> '#d70000'
					//	,'text_shortcode'				=> '#2a2a2a'
						,'label_text_color'				=> '#fff'						
	);	

	$wd_custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
	$wd_custom_style_config = unserialize($wd_custom_style_config);
	if( !is_array($wd_custom_style_config) ){
		$wd_custom_style_config = array();
	}
	$wd_custom_style_config = wd_array_atts_str($wd_default_custom_style_config,$wd_custom_style_config);	
	
	
	add_action('wp_ajax_nopriv_wd_ajax_style', 'wd_ajax_save_style');
	add_action('wp_ajax_wd_ajax_style', 'wd_ajax_save_style');
	
	function wd_ajax_save_style(){
		global $wd_default_custom_style_config,$wd_custom_style_config;
		
		//get config data,merge it with default config data
		// $custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
		// $style_datas = unserialize($custom_style_config);
		// $style_datas = wd_array_atts($wd_default_custom_style_config,$style_datas);
				
		$style_datas = $wd_custom_style_config;		
				


		
		$enable_custom_font = $style_datas['enable_custom_font'];
		$enable_custom_color = $style_datas['enable_custom_color'];
				
		if(	! is_user_logged_in() ){
			die('You do not have sufficient permissions to do this action.');
		}else{
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to do this action.','wpdance' ) );
			}else{
				//TODO : check nonce & do font save
				if( !$enable_custom_font && !$enable_custom_color ){
					wp_die( __( 'Custom style disabled','wpdance' ) );
				}
				if ( empty($_POST) || !wp_verify_nonce($_POST['ajax_preview'],'ajax_save_style') ){
					wp_die( __( 'Something goes wrong!Please login again','wpdance' ) );
				}else{
				   // process form data
										
					$save_datas = $style_datas;
					$save_datas['page_layout'] 						= strlen( $_POST['page_layout'] ) > 0 						? wp_kses_data($_POST['page_layout']) 					: $save_datas['page_layout'];
					$save_datas['body_font_style_str'] 				= wp_kses_data($_POST['body_font_style_str']);
					$save_datas['heading_font_style_str'] 			= wp_kses_data($_POST['heading_font_style_str']) ;
					$save_datas['menu_font_style_str'] 				= wp_kses_data($_POST['menu_font_style_str']) ;
					$save_datas['body_font_name'] 					= strlen( $_POST['@body_font'] ) > 0 						? wp_kses_data($_POST['@body_font']) 						: $save_datas['body_font_name'];
					$save_datas['body_font_weight'] 				= strlen( $_POST['@body_font_weight'] ) > 0 				? wp_kses_data($_POST['@body_font_weight']) 				: $save_datas['body_font_weight'];
					$save_datas['body_font_style'] 					= strlen( $_POST['@body_font_style'] ) > 0 					? wp_kses_data($_POST['@body_font_style']) 					: $save_datas['body_font_style'];
					$save_datas['menu_font_name'] 					= strlen( $_POST['@menu_font'] ) > 0 						? wp_kses_data($_POST['@menu_font']) 						: $save_datas['menu_font_name'];
					$save_datas['menu_font_weight'] 				= strlen( $_POST['@menu_font_weight'] ) > 0 				? wp_kses_data($_POST['@menu_font_weight']) 				: $save_datas['menu_font_weight'];
					$save_datas['menu_font_style'] 					= strlen( $_POST['@menu_font_style'] ) > 0 					? wp_kses_data($_POST['@menu_font_style']) 					: $save_datas['menu_font_style'];
					$save_datas['sub_menu_font_name'] 				= strlen( $_POST['@sub_menu_font'] ) > 0 					? wp_kses_data($_POST['@sub_menu_font']) 						: $save_datas['sub_menu_font_name'];
					$save_datas['sub_menu_font_weight'] 			= strlen( $_POST['@sub_menu_font_weight'] ) > 0 			? wp_kses_data($_POST['@sub_menu_font_weight']) 				: $save_datas['sub_menu_font_weight'];
					$save_datas['sub_menu_font_style'] 				= strlen( $_POST['@sub_menu_font_style'] ) > 0 				? wp_kses_data($_POST['@sub_menu_font_style']) 					: $save_datas['sub_menu_font_style'];
					$save_datas['heading_font_name'] 				= strlen( $_POST['@heading_font'] ) > 0 					? wp_kses_data($_POST['@heading_font']) 					: $save_datas['heading_font_name'];
					$save_datas['heading_font_weight'] 				= strlen( $_POST['@heading_font_weight'] ) > 0 				? wp_kses_data($_POST['@heading_font_weight']) 				: $save_datas['heading_font_weight'];
					$save_datas['heading_font_style'] 				= strlen( $_POST['@heading_font_style'] ) > 0 				? wp_kses_data($_POST['@heading_font_style']) 				: $save_datas['heading_font_style'];
					$save_datas['primary_color'] 					= strlen( $_POST['@primary_color'] ) > 0 					? wp_kses_data($_POST['@primary_color']) 					: $save_datas['primary_color'];
					$save_datas['primary_second_color'] 		= strlen( $_POST['@primary_second_color'] ) > 0 		? wp_kses_data($_POST['@primary_second_color']) 		: $save_datas['primary_second_color'];
					$save_datas['primary_background_color'] 		= strlen( $_POST['@primary_background_color'] ) > 0 		? wp_kses_data($_POST['@primary_background_color']) 		: $save_datas['primary_background_color'];
					$save_datas['heading_color'] 					= strlen( $_POST['@heading_color'] ) > 0 					? wp_kses_data($_POST['@heading_color']) 					: $save_datas['heading_color'];
					$save_datas['primary_text_color'] 						= strlen( $_POST['@primary_text_color'] ) > 0 						? wp_kses_data($_POST['@primary_text_color']) 						: $save_datas['primary_text_color'];
					$save_datas['primary_link_color'] 						= strlen( $_POST['@primary_link_color'] ) > 0 						? wp_kses_data($_POST['@primary_link_color']) 						: $save_datas['primary_link_color'];
					$save_datas['border_color_primary'] 						= strlen( $_POST['@primary_border_color'] ) > 0 						? wp_kses_data($_POST['@primary_border_color']) 						: $save_datas['border_color_primary'];
					$save_datas['button_primary_background'] 				= strlen( $_POST['@button_primary_background'] ) > 0 				? wp_kses_data($_POST['@button_primary_background']) 				: $save_datas['button_background'];
					$save_datas['button_text_color'] 				= strlen( $_POST['@button_primary_text_color'] ) > 0 				? wp_kses_data($_POST['@button_primary_text_color']) 				: $save_datas['button_text_color'];
					$save_datas['button_border_color'] 				= strlen( $_POST['@button_primary_border_color'] ) > 0 				? wp_kses_data($_POST['@button_primary_border_color']) 				: $save_datas['button_border_color'];
					
					
					$save_datas['button_second_background'] 				= strlen( $_POST['@button_second_background'] ) > 0 				? wp_kses_data($_POST['@button_second_background']) 				: $save_datas['button_second_background'];
					$save_datas['button_second_text_color'] 				= strlen( $_POST['@button_second_text_color'] ) > 0 				? wp_kses_data($_POST['@button_second_text_color']) 				: $save_datas['button_second_text_color'];
					$save_datas['border_second_button'] 				= strlen( $_POST['@button_second_border'] ) > 0 				? wp_kses_data($_POST['@button_second_border']) 				: $save_datas['border_second_button'];
					
					$save_datas['background_tab'] 				= strlen( $_POST['@tab_backgound_color'] ) > 0 				? wp_kses_data($_POST['@tab_backgound_color']) 				: $save_datas['background_tab'];
					$save_datas['tab_text_color'] 				= strlen( $_POST['@tab_text_color'] ) > 0 				? wp_kses_data($_POST['@tab_text_color']) 				: $save_datas['tab_text_color'];
					$save_datas['tab_border_color'] 				= strlen( $_POST['@tab_border_color'] ) > 0 				? wp_kses_data($_POST['@tab_border_color']) 				: $save_datas['tab_border_color'];
					$save_datas['tab_text_color_active'] 		= strlen( $_POST['@tab_text_color_active'] ) > 0 		? wp_kses_data($_POST['@tab_text_color_active']) 		: $save_datas['tab_text_color_active'];
					$save_datas['tab_background_color_active'] 		= strlen( $_POST['@tab_background_color_active'] ) > 0 		? wp_kses_data($_POST['@tab_background_color_active']) 		: $save_datas['tab_background_color_active'];
					$save_datas['tab_border_color_active'] 		= strlen( $_POST['@tab_border_color_active'] ) > 0 		? wp_kses_data($_POST['@tab_border_color_active']) 		: $save_datas['tab_border_color_active'];
					
					$save_datas['footer_first_area_text_color'] 					= strlen( $_POST['@footer_first_area_text_color'] ) > 0 					? wp_kses_data($_POST['@footer_first_area_text_color']) 					: $save_datas['footer_first_area_text_color'];
					$save_datas['footer_first_area_heading_color'] 					= strlen( $_POST['@footer_first_area_heading_color'] ) > 0 					? wp_kses_data($_POST['@footer_first_area_heading_color']) 					: $save_datas['footer_first_area_heading_color'];
					$save_datas['footer_second_area_text_color'] 					= strlen( $_POST['@footer_second_area_text_color'] ) > 0 					? wp_kses_data($_POST['@footer_second_area_text_color']) 					: $save_datas['footer_second_area_text_color'];
					$save_datas['footer_second_area_heading_color'] 					= strlen( $_POST['@footer_second_area_heading_color'] ) > 0 					? wp_kses_data($_POST['@footer_second_area_heading_color']) 					: $save_datas['footer_second_area_heading_color'];
					$save_datas['footer_thrid_area_text_color'] 					= strlen( $_POST['@footer_thrid_area_text_color'] ) > 0 					? wp_kses_data($_POST['@footer_thrid_area_text_color']) 					: $save_datas['footer_thrid_area_text_color'];
					$save_datas['footer_thrid_area_background'] 					= strlen( $_POST['@footer_third_area_backgound'] ) > 0 					? wp_kses_data($_POST['@footer_third_area_backgound']) 					: $save_datas['footer_thrid_area_background'];
			//		$save_datas['footer_four_area_text_color'] 					= strlen( $_POST['@footer_four_area_text_color'] ) > 0 					? wp_kses_data($_POST['@footer_four_area_text_color']) 					: $save_datas['footer_four_area_text_color'];
			//		$save_datas['footer_four_area_heading_color'] 					= strlen( $_POST['@footer_four_area_heading_color'] ) > 0 					? wp_kses_data($_POST['@footer_four_area_heading_color']) 					: $save_datas['footer_four_area_heading_color'];
			//		$save_datas['coppy_right_backgound_color'] 					= strlen( $_POST['@coppy_right_backgound_color'] ) > 0 					? wp_kses_data($_POST['@coppy_right_backgound_color']) 					: $save_datas['coppy_right_backgound_color'];
			//		$save_datas['coppy_right_text'] 					= strlen( $_POST['@coppy_right_text'] ) > 0 					? wp_kses_data($_POST['@coppy_right_text']) 					: $save_datas['coppy_right_text'];
			//		$save_datas['coppy_right_border'] 					= strlen( $_POST['@coppy_right_border'] ) > 0 					? wp_kses_data($_POST['@coppy_right_border']) 					: $save_datas['coppy_right_border'];
					$save_datas['header_menu_background'] 			= strlen( $_POST['@header_menu_background_color'] ) > 0 			? wp_kses_data($_POST['@header_menu_background_color']) 			: $save_datas['header_menu_background'];
			//		$save_datas['header_menu_text_color'] 			= strlen( $_POST['@header_menu_text_color'] ) > 0 			? wp_kses_data($_POST['@header_menu_text_color']) 			: $save_datas['header_menu_text_color'];
			//		$save_datas['header_sub_menu_background']		= strlen( $_POST['@header_sub_menu_background'] ) > 0 		? wp_kses_data($_POST['@header_sub_menu_background']) 		: $save_datas['header_sub_menu_background'];
					$save_datas['header_submenu_link_text_color'] 		= strlen( $_POST['@header_submenu_link_text_color'] ) > 0 		? wp_kses_data($_POST['@header_submenu_link_text_color']) 		: $save_datas['header_submenu_link_text_color'];
					
					
					$save_datas['header_top_text_color'] 		= strlen( $_POST['@header_top_text_color'] ) > 0 		? wp_kses_data($_POST['@header_top_text_color']) 		: $save_datas['header_top_text_color'];
					
					
					$save_datas['header_bottom_background'] 		= strlen( $_POST['@header_bottom_background'] ) > 0 		? wp_kses_data($_POST['@header_bottom_background']) 		: $save_datas['header_bottom_background'];
					$save_datas['header_bottom_text_color'] 		= strlen( $_POST['@header_bottom_text_color'] ) > 0 		? wp_kses_data($_POST['@header_bottom_text_color']) 		: $save_datas['header_bottom_text_color'];
					$save_datas['header_border_bottom_color'] 		= strlen( $_POST['@header_border_bottom_color'] ) > 0 		? wp_kses_data($_POST['@header_border_bottom_color']) 		: $save_datas['header_border_bottom_color'];
					$save_datas['header_menu_text_color'] 		= strlen( $_POST['@header_menu_text_color'] ) > 0 		? wp_kses_data($_POST['@header_menu_text_color']) 		: $save_datas['header_menu_text_color'];
					$save_datas['header_submenu_text_color'] 		= strlen( $_POST['@header_submenu_text_color'] ) > 0 		? wp_kses_data($_POST['@header_submenu_text_color']) 		: $save_datas['header_submenu_text_color'];
					$save_datas['header_submenu_border_color'] 		= strlen( $_POST['@header_submenu_border_color'] ) > 0 		? wp_kses_data($_POST['@header_submenu_border_color']) 		: $save_datas['header_submenu_border_color'];
					$save_datas['header_submenu_background_hover'] 		= strlen( $_POST['@header_submenu_background_hover'] ) > 0 		? wp_kses_data($_POST['@header_submenu_background_hover']) 		: $save_datas['header_submenu_background_hover'];
					$save_datas['header_submenu_background_color'] 		= strlen( $_POST['@header_submenu_background_color'] ) > 0 		? wp_kses_data($_POST['@header_submenu_background_color']) 		: $save_datas['header_submenu_background_color'];
					
					$save_datas['accordion_text_color'] 		= strlen( $_POST['@accordion_text_color'] ) > 0 		? wp_kses_data($_POST['@accordion_text_color']) 		: $save_datas['accordion_text_color'];
					$save_datas['accordion_background_color'] 		= strlen( $_POST['@accordion_background_color'] ) > 0 		? wp_kses_data($_POST['@accordion_background_color']) 		: $save_datas['cart_text_color'];
					$save_datas['footer_first_area_background_color'] 				= strlen( $_POST['@footer_first_area_backgound'] ) > 0 				? wp_kses_data($_POST['@footer_first_area_backgound']) 				: $save_datas['footer_first_area_background_color'];
					$save_datas['footer_border_color'] 					= strlen( $_POST['@footer_border_color'] ) > 0 					? wp_kses_data($_POST['@footer_border_color']) 					: $save_datas['footer_border_color'];
					$save_datas['footer_second_area_background_color'] 			= strlen( $_POST['@footer_second_area_backgound'] ) > 0 			? wp_kses_data($_POST['@footer_second_area_backgound']) 			: $save_datas['footer_second_area_background_color'];
		//			$save_datas['footer_area_border_color'] 				= strlen( $_POST['@footer_area_border_color'] ) > 0 				? wp_kses_data($_POST['@footer_area_border_color']) 				: $save_datas['footer_area_border_color'];
					$save_datas['sidebar_text_color'] 		= strlen( $_POST['@sidebar_text_color'] ) > 0 		? wp_kses_data($_POST['@sidebar_text_color']) 		: $save_datas['sidebar_text_color'];
					$save_datas['sidebar_border_color'] 		= strlen( $_POST['@sidebar_border_color'] ) > 0 		? wp_kses_data($_POST['@sidebar_border_color']) 		: $save_datas['sidebar_border_color'];
					$save_datas['sidebar_link_color'] 		= strlen( $_POST['@sidebar_link_color'] ) > 0 		? wp_kses_data($_POST['@sidebar_link_color']) 		: $save_datas['sidebar_link_color'];
					$save_datas['icon_color'] 							= strlen( $_POST['@icon_color'] ) > 0 							? wp_kses_data($_POST['@icon_color']) 							: $save_datas['icon_color'];
					$save_datas['filter'] 							= strlen( $_POST['@filter'] ) > 0 							? wp_kses_data($_POST['@filter']) 							: $save_datas['filter'];
					$save_datas['sidebar_heading_color'] 	= strlen( $_POST['@sidebar_heading_color'] ) > 0 	? wp_kses_data($_POST['@sidebar_heading_color']) 	: $save_datas['sidebar_heading_color'];
					$save_datas['feedback_background'] 				= strlen( $_POST['@feedback_background'] ) > 0 				? wp_kses_data($_POST['@feedback_background']) 				: $save_datas['feedback_background'];
					$save_datas['totop_background'] 				= strlen( $_POST['@totop_background'] ) > 0 				? wp_kses_data($_POST['@totop_background']) 				: $save_datas['totop_background'];
					$save_datas['feedback_color_hover'] 						= strlen( $_POST['@feedback_color_hover'] ) > 0 						? wp_kses_data($_POST['@feedback_color_hover']) 						: $save_datas['feedback_color_hover'];
			//		$save_datas['sale_background_color'] 			= strlen( $_POST['@sale_background_color'] ) > 0 			? wp_kses_data($_POST['@sale_background_color']) 			: $save_datas['sale_background_color'];
			//		$save_datas['sale_text_color'] 					= strlen( $_POST['@sale_text_color'] ) > 0 					? wp_kses_data($_POST['@sale_text_color']) 					: $save_datas['sale_text_color'];
			//		$save_datas['feature_background_color'] 		= strlen( $_POST['@feature_background_color'] ) > 0 		? wp_kses_data($_POST['@feature_background_color']) 		: $save_datas['feature_background_color'];
			//		$save_datas['feature_text_color'] 				= strlen( $_POST['@feature_text_color'] ) > 0 				? wp_kses_data($_POST['@feature_text_color']) 				: $save_datas['feature_text_color'];
					$save_datas['rating_color'] 					= strlen( $_POST['@rating_color'] ) > 0 					? wp_kses_data($_POST['@rating_color']) 					: $save_datas['rating_color'];
					
			//		$save_datas['text_shortcode'] 					= strlen( $_POST['@text_shortcode'] ) > 0 					? wp_kses_data($_POST['@text_shortcode']) 					: $save_datas['text_shortcode'];
					$save_datas['label_text_color'] 					= strlen( $_POST['@label_text_color'] ) > 0 					? wp_kses_data($_POST['@label_text_color']) 					: $save_datas['label_text_color'];					
					//merge new config data with old config data,then save
					

					update_option(THEME_SLUG.'custom_style_config',serialize($save_datas));						
						
					$ret_value = wd_save_custom_style( $save_datas );
					wp_die( 1  );
					//wp_die(  $ret_value  );
				}
			}
			
		}
	
	}
	

	function wd_previewPanel(){
	/***************Start font block****************/
	
	$api_key = get_option(THEME_SLUG.'googlefont_api_key','AIzaSyAP4SsyBZEIrh0kc_cO9s90__r2oCJ8Rds');
	$google_font_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=".$api_key;
	

	
	global $wd_default_custom_style_config,$wd_custom_style_config;
	
	// $custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
	// $style_datas = unserialize($custom_style_config);
	// $style_datas = wd_array_atts($wd_default_custom_style_config,$style_datas);	
	
	
	$style_datas = $wd_custom_style_config;
		
	$body_font_name = $style_datas['body_font_name'];
	$body_font_style_str = $style_datas['body_font_style_str'];
	
	$heading_font_name = $style_datas['heading_font_name'];
	$heading_font_style_str = $style_datas['heading_font_style_str'];
	
	$font_sort = $style_datas['font_sort'];


	
	/***************End font block****************/	
	$enable_custom_font = 	(int) $style_datas['enable_custom_font'];
	$enable_custom_color = 	(int) $style_datas['enable_custom_color'];
	
	
	if( $enable_custom_font || $enable_custom_color ){

	?>	

		<div id="wd-control-panel" class="default-font hidden-phone">
			<div id="control-panel-main">
						<a id="wd-control-close" href="#"></a>

						
<div class="accordion" id="review_panel_accordion">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_layout">
				<h2 class="wd-preview-heading">Layout Style</h2>
			</a>
		</div>
		<div id="collapse_layout" class="accordion-body collapse in">
			<div class="accordion-inner">
				<select name="page_layout" id="_page_layout" class="page_layout">
					<option value="wide" <?php if( strcmp(esc_html($style_datas['page_layout']),'wide') == 0 ) echo "selected";?>>Wide</option>
					<option value="box" <?php if( strcmp(esc_html($style_datas['page_layout']),'box') == 0 ) echo "selected";?>>Box</option>
				</select>	
			</div>
		</div>
	</div>
	<?php if($enable_custom_color):?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_color">
				<h2 class="wd-preview-heading">Custom Color</h2>
			</a>
		</div>
		<div id="collapse_color" class="accordion-body collapse">
			<div class="accordion-inner">
				<div class="input-append color colorpicker6 colorpicker_primary_color" data-color="<?php echo esc_html($style_datas['primary_color']); ?>" data-color-format="hex">
					<p class="custom-title">Theme Color</p>
					<input name="primary_color" id="primary_color" type="text" class="span2" value="<?php echo esc_html($style_datas['primary_color']); ?>" >
					<span class="add-on"><i style="color: <?php echo esc_html($style_datas['primary_color']); ?>"></i></span>
				</div>			
				<div class="input-append color colorpicker1 colorpicker_background_color" data-color="#f5f5f5" data-color-format="hex">
					<p class="custom-title">Background (Support Box Layout Only)</p>
					<input name="background_color" id="background_color" type="text" class="span2" value="#f5f5f5" >
					<span class="add-on"><i style="background-color: #f5f5f5"></i></span>
				</div>
				<div class="input-append color colorpicker_header_color" data-color="<?php echo esc_html($style_datas['header_bottom_background']); ?>" data-color-format="hex">
					<p class="custom-title">Menu</p>
					<input name="header_color" id="header_color" type="text" class="span2" value="<?php echo esc_html($style_datas['header_bottom_background']); ?>" >
					<span class="add-on"><i style="background-color: <?php echo esc_html($style_datas['header_bottom_background']); ?>"></i></span>
				</div>
				<div class="input-append color colorpicker_footer_color" data-color="<?php echo esc_html($style_datas['footer_first_area_background_color']); ?>" data-color-format="hex">
					<p class="custom-title">Footer</p>
					<input name="footer_color" id="footer_color" type="text" class="span2" value="<?php echo esc_html($style_datas['footer_first_area_background_color']); ?>" >
					<span class="add-on"><i style="background-color: <?php echo esc_html($style_datas['footer_first_area_background_color']); ?>"></i></span>
				</div>										
			</div>
		</div>
	</div>
	<?php endif;?>
	
	
	<?php if($enable_custom_font):?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_font">
				<h2 class="wd-preview-heading">Custom Font</h2>
			</a>
		</div>
		<div id="collapse_font" class="accordion-body collapse">
			<div class="accordion-inner">
							<h2 class="wd-preview-heading">Custom Font</h2>
							<hr/>						
						<div class="custom-body">
							<p class="custom-title">Body Font</p>
							<label id="textbody-contain">
								<select name="body_font" id="list_body_font">
								</select>
							</label>
							<!--
							<?php //if( $enable_custom_color ):?>				
								<div class="input-append color colorpicker_text_color" data-color="<?php //echo esc_html($style_datas['primary_text_color']); ?>" data-color-format="hex">
									<input name="text-color" <?php //if($enable_custom_font) echo 'style="display:none;"'?> id="text-color" type="text" class="span2" value="<?php //echo esc_html($style_datas['primary_text_color']); ?>" >
									<span class="add-on"><i style="color: <?php //echo esc_html($style_datas['primary_text_color']); ?>"></i></span>
								</div>
							<?php //endif;?>
							-->
							<div class="custom-font-body">
								<p class="custom-title">Body Font Style</p>
								<label id="heading_font-contain">
									<select name="body_font_weight" id="body_font_weight">
									</select>
								</label>
							</div>							
							
						</div>
						
						<div class="custom-heading">
						<?php if($enable_custom_font):?>
						
							<p class="custom-title">Heading Font</p>
							<label id="textheading-contain">
								<select name="heading_font" id="list_heading_font">
								</select>
							</label>
						<?php endif;?>
						<!--
						<?php //if($enable_custom_color):?>
							<div class="input-append color colorpicker_heading_color" data-color="<?php //echo esc_html($style_datas['heading_color']); ?>" data-color-format="hex">
								<input name="heading_color" <?php //if($enable_custom_font) echo 'style="display:none;"'?> id="heading_color" type="text" class="span2" value="<?php //echo esc_html($style_datas['heading_color']); ?>" >
								<span class="add-on"><i style="color: <?php //echo esc_html($style_datas['heading_color']); ?>"></i></span>
							</div>
						<?php //endif;?>
						-->
							<div class="custom-heading-style">
								<p class="custom-title">Heading Font Style</p>
								<label for="heading_font_weight" id="heading_font_weight-contain">
									<select name="heading_font_weight" id="heading_font_weight">
									</select>
								</label>
							</div>						
						</div>
						
						<div class="custom-menu">
						<?php if($enable_custom_font):?>
						
							<p class="custom-title">Menu Font</p>
							<label id="textmenu-contain">
								<select name="menu_font" id="list_menu_font">
								</select>
							</label>
						<?php endif;?>
						<!--
						<?php //if($enable_custom_color):?>
							<div class="input-append color colorpicker_menu_text_color" data-color="<?php ///echo esc_html($style_datas['header_menu_text_color']); ?>" data-color-format="hex">
								<input name="menu_color" <?php //if($enable_custom_font) echo 'style="display:none;"'?> id="menu_color" type="text" class="span2" value="<?php //echo esc_html($style_datas['header_menu_text_color']); ?>" >
								<span class="add-on"><i style="color: <?php //echo esc_html($style_datas['header_menu_text_color']); ?>"></i></span>
							</div>
						<?php //endif;?>
						-->
							<div class="custom-heading-style">
								<p class="custom-title">Menu Font Style</p>
								<label id="menu_font_weight-contain">
									<select name="menu_font_weight" id="menu_font_weight">
									</select>
								</label>
							</div>						
						</div>
						
			</div>
		</div>
	</div>
	<?php endif;?>
	
	<?php global $wd_demo_mod ;$wd_demo_mod=1;?>	
	<?php if( $wd_demo_mod ): ?>	
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#review_panel_accordion" href="#collapse_textures">
				<h2 class="wd-preview-heading">Textures</h2>
			</a>
		</div>
		<div id="collapse_textures" class="accordion-body collapse">
			<div class="accordion-inner">

					<h2 class="wd-preview-heading">Custom Background Images</h2>
					<hr/>					
					<div class="wd-background-wrapper">
						<p class="custom-title">Background Image(Support Box Layout Only)</p>
						<?php
							$_base_path = get_template_directory_uri() . '/images/partern/';
							echo "<ul class='wd-background-patten'>";
							for( $i = 1 ; $i <= 10 ; $i++ ){
								$_cur_path = $_base_path."{$i}.png";
								echo "<li><img id='patten_{$i}' class='wd-background-patten-image' src='{$_cur_path}' title='patten {$i}' alt='patten {$i}'></li>";
							}
							echo "</ul>";
						?>
					</div>
						
			</div>
		</div>
	</div>	
	<?php endif; ?>	
</div>					
						
					<p class="button-save"><button class="btn btn-primary" data-loading-text="Saving..." id="font-save-btn" type="button">Save</button></p>
					<p class="button-clear"><button class="btn btn-primary" data-loading-text="Clearing..." id="font-clear-btn" type="button">Clear</button></p>
					
					<div id="preview-save-result" class="alert" style="display:none;">

					</div>

					<?php //TODO ?>
					<?php wp_nonce_field('ajax_save_style','preview_nonce_field'); ?>	
			</div>
		</div>
	<script type="text/javascript">
		function loadSelectedFont( font_name,font_weight ){
			if(  font_name.length > 0 ){
				jQuery('head').append("<link id='" + font_name + "' href='http://fonts.googleapis.com/css?family="+font_name.replace(/ /g,'+')+( jQuery.trim(font_weight).length > 0 ? (':' + font_weight) : '' )+"' rel='stylesheet' type='text/css' />");
			}
		}

		function get_font_weight(font_string){
			font_string = font_string.replace("italic","");
			if( font_string.length <= 0 || font_string == 'regular' ){
				return 'normal';
			}
			return font_string;
		}
		function get_font_style(font_string){
			if( font_string.indexOf('italic') >= 0 )
				return 'italic';
			return 'normal';
		}
		
		function set_color( selector_id,color_value ){
			jQuery(selector_id).find('input.span2').val(color_value);
			setTimeout(function(){
				jQuery(selector_id).find('i').eq(0).css('background-color',color_value);
			},1000);
		}		
		
	jQuery(document).ready(function() {
	
		jQuery.cookie.defaults = { path: '/', expires: 365 };
	
			<?php
				$_style_datas = $style_datas;
				foreach( $_style_datas as $_key => $_value ){
					$_style_datas[$_key] = strlen($_value) <= 0 ? "null" : $_value;
				}
				$_style_datas['body_font_name'] = (strcmp($_style_datas['body_font_name'],'null') == 0 || (int)$_style_datas['body_font_name'] == - 1) ? "Open Sans" : $_style_datas['body_font_name'];
				$_style_datas['heading_font_name'] = (strcmp($_style_datas['heading_font_name'],'null') == 0 || (int)$_style_datas['heading_font_name'] == - 1) ? "Open Sans" : $_style_datas['heading_font_name'];
				$_style_datas['menu_font_name'] = (strcmp($_style_datas['menu_font_name'],'null') == 0 || (int)$_style_datas['menu_font_name'] == - 1) ? "Open Sans" : $_style_datas['menu_font_name'];
				$_style_datas['sub_menu_font_name'] = (strcmp($_style_datas['sub_menu_font_name'],'null') == 0 || (int)$_style_datas['sub_menu_font_name'] == - 1) ? "Open Sans" : $_style_datas['sub_menu_font_name'];
				
			?>
			custom_datas = {	"@body_font" : "<?php echo esc_html($_style_datas['body_font_name']); ?>"
								,"@body_font_weight" : "<?php echo esc_html($_style_datas['body_font_weight']); ?>"
								,"@body_font_style" : "<?php echo esc_html($_style_datas['body_font_style']); ?>"
								,"@font_menu" : "<?php echo esc_html($_style_datas['menu_font_name']); ?>"
								,"@menu_font_weight" : "<?php echo esc_html($_style_datas['menu_font_weight']); ?>"
								,"@menu_font_style" : "<?php echo esc_html($_style_datas['menu_font_style']); ?>"
								,"@font_submenu" : "<?php echo esc_html($_style_datas['sub_menu_font_name']); ?>"
								,"@sub_menu_font_weight" : "<?php echo esc_html($_style_datas['sub_menu_font_weight']); ?>"
								,"@sub_menu_font_style" : "<?php echo esc_html($_style_datas['sub_menu_font_style']); ?>"
								,"@heading_font" : "<?php echo esc_html($_style_datas['heading_font_name']); ?>"
								,"@heading_font_weight" : "<?php echo esc_html($_style_datas['heading_font_weight']); ?>"
								,"@heading_font_style" : "<?php echo esc_html($_style_datas['heading_font_style']); ?>"
								,"@primary_color" : "<?php echo esc_html($_style_datas['primary_color']); ?>"
								,"@primary_second_color" : "<?php echo esc_html($_style_datas['primary_second_color']); ?>"
								,"@heading_color" : "<?php echo esc_html($_style_datas['heading_color']); ?>"
								,"@primary_background_color" : "<?php echo esc_html($_style_datas['primary_background_color']); ?>"
								,"@primary_text_color" : "<?php echo esc_html($_style_datas['primary_text_color']); ?>"
								,"@primary_link_color" : "<?php echo esc_html($_style_datas['primary_link_color']); ?>"
								,"@primary_border_color" : "<?php echo esc_html($_style_datas['border_color_primary']); ?>"
								,"@button_background" : "<?php echo esc_html($_style_datas['button_background']); ?>"
								,"@button_primary_text_color" : "<?php echo esc_html($_style_datas['button_text_color']); ?>"
								,"@button_primary_border_color" : "<?php echo esc_html($_style_datas['button_border_color']); ?>"
								
								,"@tab_backgound_color" : "<?php echo esc_html($_style_datas['background_tab']); ?>"
								,"@tab_text_color" : "<?php echo esc_html($_style_datas['tab_text_color']); ?>"
								,"@tab_border_color" : "<?php echo esc_html($_style_datas['tab_border_color']); ?>"
								,"@tab_border_color_active" : "<?php echo esc_html($_style_datas['tab_border_color_active']); ?>"
								,"@tab_text_color_active" : "<?php echo esc_html($_style_datas['tab_text_color_active']); ?>"
								,"@tab_background_color_active" : "<?php echo esc_html($_style_datas['tab_background_color_active']); ?>"
								
								,"@accordion_text_color" : "<?php echo esc_html($_style_datas['accordion_text_color']); ?>"
								,"@accordion_background_color" : "<?php echo esc_html($_style_datas['accordion_background_color']); ?>"
								
								,"@button_second_background" : "<?php echo esc_html($_style_datas['button_second_background']); ?>"
								,"@button_second_text_color" : "<?php echo esc_html($_style_datas['button_second_text_color']); ?>"
								,"@button_second_border" : "<?php echo esc_html($_style_datas['border_second_button']); ?>"
								
								,"@header_menu_background_color" : "<?php echo esc_html($_style_datas['header_menu_background']); ?>"
								,"@header_submenu_link_text_color" : "<?php echo esc_html($_style_datas['header_submenu_link_text_color']); ?>"
								,"@header_top_text_color" : "<?php echo esc_html($_style_datas['header_top_text_color']); ?>"
								,"@header_bottom_background" : "<?php echo esc_html($_style_datas['header_bottom_background']); ?>"
								,"@header_bottom_text_color" : "<?php echo esc_html($_style_datas['header_bottom_text_color']); ?>"
								,"@header_menu_text_color" : "<?php echo esc_html($_style_datas['header_menu_text_color']); ?>"
								,"@header_submenu_text_color" : "<?php echo esc_html($_style_datas['header_submenu_text_color']); ?>"
								,"@header_submenu_border_color" : "<?php echo esc_html($_style_datas['header_submenu_border_color']); ?>"
								,"@header_submenu_background_hover" : "<?php echo esc_html($_style_datas['header_submenu_background_hover']); ?>"
								,"@header_submenu_background_color" : "<?php echo esc_html($_style_datas['header_submenu_background_color']); ?>"
								,"@header_border_bottom_color" : "<?php echo esc_html($_style_datas['header_border_bottom_color']); ?>"
								
								
								,"@footer_first_area_text_color" : "<?php echo esc_html($_style_datas['footer_first_area_text_color']); ?>"
								,"@footer_first_area_heading_color" : "<?php echo esc_html($_style_datas['footer_first_area_heading_color']); ?>"
								,"@footer_second_area_text_color" : "<?php echo esc_html($_style_datas['footer_second_area_text_color']); ?>"
								,"@footer_second_area_heading_color" : "<?php echo esc_html($_style_datas['footer_second_area_heading_color']); ?>"
								,"@footer_third_area_text_color" : "<?php echo esc_html($_style_datas['footer_thrid_area_text_color']); ?>"
								,"@footer_third_area_backgound" : "<?php echo esc_html($_style_datas['footer_thrid_area_background']); ?>"
				//				,"@footer_four_area_text_color" : "<?php echo esc_html($_style_datas['footer_four_area_text_color']); ?>"
				//				,"@footer_four_area_heading_color" : "<?php echo esc_html($_style_datas['footer_four_area_heading_color']); ?>"
				//				,"@coppy_right_backgound_color" : "<?php echo esc_html($_style_datas['coppy_right_backgound_color']); ?>"
				//				,"@coppy_right_text" : "<?php echo esc_html($_style_datas['coppy_right_text']); ?>"
				//				,"@coppy_right_border" : "<?php echo esc_html($_style_datas['coppy_right_border']); ?>"
								,"@footer_first_area_backgound" : "<?php echo esc_html($_style_datas['footer_first_area_background_color']); ?>"
								,"@footer_border_color" : "<?php echo esc_html($_style_datas['footer_border_color']); ?>"
								,"@footer_second_area_backgound" : "<?php echo esc_html($_style_datas['footer_second_area_background_color']); ?>"
				//				,"@footer_area_border_color" : "<?php echo esc_html($_style_datas['footer_area_border_color']); ?>"
								
								,"@sidebar_text_color" : "<?php echo esc_html($_style_datas['sidebar_text_color']); ?>"
								,"@sidebar_border_color" : "<?php echo esc_html($_style_datas['sidebar_border_color']); ?>"
								,"@sidebar_link_color" : "<?php echo esc_html($_style_datas['sidebar_link_color']); ?>"
								,"@icon_color" : "<?php echo esc_html($_style_datas['icon_color']); ?>"
								,"@filter" : "<?php echo esc_html($_style_datas['filter']); ?>"
								,"@sidebar_heading_color" : "<?php echo esc_html($_style_datas['sidebar_heading_color']); ?>"
								
								,"@feedback_background" : "<?php echo esc_html($_style_datas['feedback_background']); ?>"
								,"@totop_background" : "<?php echo esc_html($_style_datas['totop_background']); ?>"
								,"@feedback_color_hover" : "<?php echo esc_html($_style_datas['feedback_color_hover']); ?>"
							//	,"@sale_background_color" : "<?php echo esc_html($_style_datas['sale_background_color']); ?>"
				//				,"@sale_text_color" : "<?php echo esc_html($_style_datas['sale_text_color']); ?>"
				//				,"@feature_background_color" : "<?php echo esc_html($_style_datas['feature_background_color']); ?>"
				//				,"@feature_text_color" : "<?php echo esc_html($_style_datas['feature_text_color']); ?>"
								,"@rating_color" : "<?php echo esc_html($_style_datas['rating_color']); ?>"
								
				//				,"@text_shortcode" : "<?php echo esc_html($_style_datas['text_shortcode']); ?>"
								,"@label_text_color" : "<?php echo esc_html($_style_datas['label_text_color']); ?>"
							};
			orgin_custom_datas = custom_datas;
			<?php if( $enable_custom_font && $enable_custom_color ) : ?>
			
			if ( jQuery.cookie("page_layout") !== undefined ){
				jQuery('#_page_layout').val(jQuery.cookie("page_layout"));
				jQuery('body').removeClass('wide box').addClass(jQuery.cookie("page_layout"));
			}
			if ( jQuery.cookie("bg_image") !== undefined ){
				jQuery('ul.wd-background-patten > li.active').removeClass('active');
				var _img_id = '#'+jQuery.cookie("bg_image");
				if( jQuery(_img_id).length > 0 ){
					jQuery('body').css( "background-image",'url("' + jQuery(_img_id).attr('src') + '")' );
					jQuery('body').css( "background-repeat","repeat" );	
					jQuery(_img_id).parent().addClass('active');
				}
			}			
			if ( jQuery.cookie("bg_color") !== undefined ){
				set_color( '.colorpicker_background_color',jQuery.cookie("bg_color") );
				jQuery('body').css('background-color',jQuery.cookie("bg_color"));	
			}			
			
			if ( jQuery.cookie("custom_datas") !== undefined ){
				custom_datas = jQuery.cookie("custom_datas");
				if( typeof custom_datas == 'string' ){
					custom_datas = jQuery.parseJSON(custom_datas);
					//console.log(custom_datas);
					<?php if( $enable_custom_color ) : ?>
					set_color('.colorpicker_primary_color',custom_datas['@primary_color']);
					set_color('.colorpicker_footer_color',custom_datas['@footer_first_area_backgound']);
					set_color('.colorpicker_text_color',custom_datas['@primary_text_color']);
					set_color('.colorpicker_heading_color',custom_datas['@primary_heading_color']);
		//			set_color('.colorpicker_menu_text_color',custom_datas['@header_menu_text_color']);
					<?php endif;?>
					
					<?php if( $enable_custom_font ) : ?>
					
					loadSelectedFont(custom_datas['@body_font'],jQuery.cookie("body_font_style_str"));
					loadSelectedFont(custom_datas['@heading_font'],jQuery.cookie("heading_font_style_str"));
					loadSelectedFont(custom_datas['@font_menu'],jQuery.cookie("menu_font_style_str"));
					
					jQuery('body').bind('font_load_success',function(){
						setTimeout(function(){
							jQuery('#list_body_font').val(custom_datas['@body_font']);
							jQuery('#list_heading_font').val(custom_datas['@heading_font']);
							jQuery('#list_menu_font').val(custom_datas['@menu_font']);
						},1000);
						setTimeout(function(){
							if ( jQuery.cookie("body_font_style_str") !== undefined ){
								if( custom_datas['@body_font'] != 'Open Sans' ){
									weight_array = font_config[custom_datas['@body_font']][0];
									weight_array = weight_array[0];
									jQuery.each(weight_array, function(index, value) {
										option_weight_html = '<option value="'+value+'">' + value + '</option>';
										jQuery('#body_font_weight').append(option_weight_html);
									});
								}	
								jQuery('#body_font_weight').val( jQuery.cookie("body_font_style_str") );
							}
							if ( jQuery.cookie("heading_font_style_str") !== undefined ){
								if( custom_datas['@heading_font'] != 'Open Sans' ){
									weight_array = font_config[custom_datas['@heading_font']][0];
									weight_array = weight_array[0];
									jQuery.each(weight_array, function(index, value) {
										option_weight_html = '<option value="'+value+'">' + value + '</option>';
										jQuery('#heading_font_weight').append(option_weight_html);
									});
								}							
								jQuery('#heading_font_weight').val( jQuery.cookie("heading_font_style_str") );
							}
								
							if ( jQuery.cookie("menu_font_style_str") !== undefined ){
								if( custom_datas['@menu_font'] != 'Open Sans' ){
									weight_array = font_config[custom_datas['@menu_font']][0];
									weight_array = weight_array[0];
									jQuery.each(weight_array, function(index, value) {
										option_weight_html = '<option value="'+value+'">' + value + '</option>';
										jQuery('#menu_font_weight').append(option_weight_html);
									});
								}
								jQuery('#menu_font_weight').val( jQuery.cookie("menu_font_style_str") );
							}
								
						},3000);						
					});
					<?php endif;?>
					less.modifyVars(custom_datas);
				}
			}
			<?php endif;?>
			

			
					
			jQuery('ul.wd-background-patten > li > img.wd-background-patten-image').click(function(event){
				jQuery('ul.wd-background-patten > li.active').removeClass('active');
				$_src_img = jQuery(this).attr('src');
				jQuery('body').css( "background-image",'url("' + $_src_img + '")' );
				jQuery('body').css( "background-repeat","repeat" );		
				jQuery.cookie("bg_image", jQuery(this).attr('id'));
				jQuery(this).parent().addClass('active');
				event.preventDefault();
			});
			jQuery('#_page_layout').change(function(event){
				//less goes here
				jQuery('body').removeClass('wide').removeClass('box').addClass(jQuery(this).val());
				jQuery.cookie("page_layout", jQuery(this).val());
				
				if( jQuery('.slideshow-wrapper').length > 0 ){
					if( jQuery(this).val() == 'wide' ){
						jQuery('.slideshow-wrapper').removeClass('container').addClass('wide');
						jQuery('.slideshow-sub-wrapper').removeClass('span24').addClass('wide-wrapper');
					}	
					if( jQuery(this).val() == 'box' ){
						jQuery('.slideshow-wrapper').removeClass('wide').addClass('container');
						jQuery('.slideshow-sub-wrapper').removeClass('wide-wrapper').addClass('span24');
						jQuery('body').css('background-color',jQuery('input#background_color').val());	
						jQuery.cookie("bg_color", jQuery('input#background_color').val());	
						//jQuery('body').css('background-color',jQuery.cookie("bg_color"));	
						//#f5f0f0
						
					}	
					jQuery('body').trigger('resize');					
				}

			});		
	
	
			jQuery('#wd-control-panel').find('p,span,a,button,div,input,textarea,button').addClass('default-style');
			
			<?php if( $enable_custom_font ) : ?>
			/******************START FONT LOADER*******************/
			var body_option_html,selected_body_font,selected_body_weight,body_font_weight_obj,heading_font_weight_obj,menu_font_weight_obj;
			font_config = new Array();
			selected_body_weight = '<?php echo esc_html($body_font_style_str); ?>';
			selected_body_font = '<?php echo esc_html($_style_datas['body_font_name']); ?>';

			selected_body_font = jQuery.trim(selected_body_font);
			selected_body_weight = jQuery.trim(selected_body_weight);
			
			selected_heading_weight = '<?php echo esc_html($heading_font_style_str); ?>';
			selected_heading_font = '<?php echo esc_html($_style_datas['heading_font_name']); ?>';

			selected_heading_font = jQuery.trim(selected_heading_font);
			selected_heading_weight = jQuery.trim(selected_heading_weight);

			selected_menu_weight = '<?php echo esc_html($style_datas['menu_font_style_str']); ?>';
			selected_menu_font = '<?php echo esc_html($_style_datas['menu_font_name']); ?>';

			selected_menu_font = jQuery.trim(selected_menu_font);
			selected_menu_weight = jQuery.trim(selected_menu_weight);				
			
			

			jQuery.ajax("<?php echo esc_url($google_font_url); ?>", {
				data : { sort: "<?php echo esc_html($font_sort);?>" }
				,dataType: 'jsonp'
				,success : function(data){
					
					if( typeof(data) == 'string' ){
						data = JSON.parse(data);
					}
					option_html = "";
					//apend list font to select box,prepare data for font array object
					jQuery.each(data.items, function(i, obj) {
						font_config[obj.family] = new Array(
							new Array(obj.variants)
							,new Array(obj.subsets)
						);
						option_html = option_html + '<option value="'+obj.family+'" >' + obj.family + '</option>';
					});
					
					jQuery('#list_body_font').html("<option value='Open Sans'>Default</option>"+option_html).val(selected_body_font);
					jQuery('#list_heading_font').html("<option value='Open Sans'>Default</option>"+option_html).val(selected_heading_font);
					jQuery('#list_menu_font').html("<option value='Open Sans'>Default</option>"+option_html).val(selected_menu_font);					
					//do the first font weight
					if( selected_body_font.length <= 0 ){
						body_font_weight_obj = data.items[0].variants;
					}else{
						if( selected_body_font != 'Open Sans' ){
							body_font_weight_obj = font_config[selected_body_font][0][0];
						}else{
							body_font_weight_obj = new Array();
						}
					}
					
					if( selected_heading_font.length <= 0 ){
						heading_font_weight_obj = data.items[0].variants;
					}else{
						if( selected_heading_font != 'Open Sans' ){
							heading_font_weight_obj = font_config[selected_heading_font][0][0];
						}else{
							heading_font_weight_obj = new Array();
						}						
					}
					
					if( selected_menu_font.length <= 0 ){
						menu_font_weight_obj = data.items[0].variants;
					}else{
						if( selected_menu_font != 'Open Sans' ){
							menu_font_weight_obj = font_config[selected_heading_font][0][0];
						}else{
							menu_font_weight_obj = new Array();
						}						
					}					
					
					jQuery.each(body_font_weight_obj, function(i, obj) {
						body_selected_str = ( selected_body_weight == obj ? "selected" : "");
						body_option_html = '<option value="'+obj+'"' + body_selected_str + '>' + obj + '</option>';
						jQuery('#body_font_weight').append(body_option_html);

					});
					
					jQuery.each(heading_font_weight_obj, function(i, obj) {
						heading_selected_str = ( selected_heading_weight == obj ? "selected" : "");
						heading_option_html = '<option value="'+obj+'"' + heading_selected_str + '>' + obj + '</option>';
						jQuery('#heading_font_weight').append(heading_option_html);
					});				
					
					
					jQuery.each(menu_font_weight_obj, function(i, obj) {
						menu_selected_str = ( selected_menu_weight == obj ? "selected" : "");
						menu_option_html = '<option value="'+obj+'"' + menu_selected_str + '>' + obj + '</option>';
						jQuery('#menu_font_weight').append(menu_option_html);
					});					
					jQuery('body').trigger('font_load_success');
					//end first font weigh
				}


			});

				//select another font,reload font weight
				jQuery('#list_body_font').change(function(event){
					jQuery('#body_font_weight').html('');
					if( jQuery(this).val() != 'Open Sans' ){
						weight_array = font_config[jQuery(this).val()][0];
						weight_array = weight_array[0];
						jQuery.each(weight_array, function(index, value) {
							option_weight_html = '<option value="'+value+'">' + value + '</option>';
							jQuery('#body_font_weight').append(option_weight_html);
						});
						loadSelectedFont(jQuery(this).val(),jQuery('#body_font_weight').val());
					}
					custom_datas['@body_font'] = jQuery(this).val();
					jQuery.cookie("body_font_style_str", jQuery('#body_font_weight').val());
					jQuery('body').trigger('less_update');
					//less goes here
				});

				jQuery('#list_heading_font').change(function(event){
					jQuery('#heading_font_weight').html('');
					if( jQuery(this).val() != 'Open Sans' ){
						weight_array = font_config[jQuery(this).val()][0];
						weight_array = weight_array[0];
						jQuery.each(weight_array, function(index, value) {
							option_weight_html = '<option value="'+value+'">' + value + '</option>';
							jQuery('#heading_font_weight').append(option_weight_html);
						});
						loadSelectedFont(jQuery(this).val(),jQuery('#heading_font_weight').val());
					}
					custom_datas['@heading_font'] = jQuery(this).val();
					jQuery.cookie("heading_font_style_str", jQuery('#heading_font_weight').val());
					jQuery('body').trigger('less_update');
					//less goes here
				});	

				jQuery('#list_menu_font').change(function(event){
					jQuery('#menu_font_weight').html('');
					if( jQuery(this).val() != 'Open Sans' ){
						weight_array = font_config[jQuery(this).val()][0];
						weight_array = weight_array[0];
						jQuery.each(weight_array, function(index, value) {
							option_weight_html = '<option value="'+value+'">' + value + '</option>';
							jQuery('#menu_font_weight').append(option_weight_html);
						});
						loadSelectedFont(jQuery(this).val(),jQuery('#menu_font_weight').val());
					}
					custom_datas['@font_menu'] = jQuery(this).val();
					jQuery.cookie("menu_font_style_str", jQuery('#menu_font_weight').val());
					jQuery('body').trigger('less_update');
					//less goes here
				});					
			
			
			jQuery('#body_font_weight').change(function(event){
				//less goes here
				custom_datas['@body_font_weight'] = get_font_weight(jQuery(this).val());
				custom_datas['@body_font_style'] = get_font_style(jQuery(this).val());
				loadSelectedFont(jQuery('#list_body_font').val(),jQuery(this).val());
				jQuery.cookie("body_font_style_str", jQuery(this).val());
				jQuery('body').trigger('less_update');
			});
			jQuery('#heading_font_weight').change(function(event){
				//less goes here
				custom_datas['@heading_font_weight'] = get_font_weight(jQuery(this).val());
				custom_datas['@heading_font_style'] = get_font_style(jQuery(this).val());
				loadSelectedFont(jQuery('#list_heading_font').val(),jQuery(this).val());
				jQuery.cookie("heading_font_style_str", jQuery(this).val());
				jQuery('body').trigger('less_update');
			});	
			jQuery('#menu_font_weight').change(function(event){
				//less goes here
				custom_datas['@menu_font_weight'] = get_font_weight(jQuery(this).val());
				custom_datas['@menu_font_style'] = get_font_style(jQuery(this).val());
				loadSelectedFont(jQuery('#list_menu_font').val(),jQuery(this).val());
				jQuery.cookie("menu_font_style_str", jQuery(this).val());
				jQuery('body').trigger('less_update');
			});				
		/******************END FONT LOADER*******************/
		<?php endif; ?>
		

		<?php if( $enable_custom_color ) : ?>
		/******************START COLOR PICKER*******************/
		// color picker1 - Theme color
		$body_bg_picker = jQuery('.colorpicker_primary_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			//alert();
			custom_datas['@primary_color'] = ev.color.toHex();
			custom_datas['@border_color_primary'] = ev.color.toHex();
			//custom_datas['@button_background'] = ev.color.toHex();
			//custom_datas['@header_menu_background'] = ev.color.toHex();
			custom_datas['@filter'] = ev.color.toHex();
			custom_datas['@feedback_background'] = ev.color.toHex();
			custom_datas['@totop_background'] = ev.color.toHex();
			//custom_datas['@feedback_color_hover'] = ev.color.toHex();
			custom_datas['@heading_color'] = ev.color.toHex();
			custom_datas['@primary_link_color'] = ev.color.toHex();
		//	custom_datas['@text_shortcode'] = ev.color.toHex();
			//custom_datas['@sidebar_heading_text_color'] = ev.color.toHex();
			//console.log(custom_datas);
			jQuery('body').trigger('less_update');
		});

		$background_bg_picker = jQuery('.colorpicker_background_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			jQuery('body').css('background-color',ev.color.toHex());	
			jQuery.cookie("bg_color", ev.color.toHex());		
		});
		// color picker3 - background header
		$header_bg_picker = jQuery('.colorpicker_header_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@header_bottom_background'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});
		
		$footer_bg_picker = jQuery('.colorpicker_footer_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@footer_first_area_backgound'] = ev.color.toHex();
			custom_datas['@footer_second_area_backgound'] = ev.color.toHex();
			custom_datas['@footer_third_area_backgound'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});
		
		// color picker4 - color text body
		$text_picker = jQuery('.colorpicker_text_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@primary_text_color'] = ev.color.toHex();	
			jQuery('body').trigger('less_update');			
		});
		// color picker5 - heading
		$heading_picker = jQuery('.colorpicker_heading_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
			custom_datas['@heading_color'] = ev.color.toHex();
			custom_datas['@sidebar_text_color'] = ev.color.toHex();
			custom_datas['@footer_second_area_backgound'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});
		
		$hover_picker = jQuery('.colorpicker_menu_text_color').colorpicker({'format':'hex'}).on('changeColor', function(ev){
		//	custom_datas['@header_menu_text_color'] = ev.color.toHex();
			jQuery('body').trigger('less_update');
		});
		
		/******************END COLOR PICKER*******************/
		<?php endif; ?>
		
	
		jQuery('body').bind('less_update',jQuery.debounce( 250, function(){	
			//console.log(custom_datas);
			less.modifyVars(custom_datas);	
			jQuery.cookie("custom_datas", JSON.stringify(custom_datas));	
			var _container_offet = jQuery('.heade-bottom-content').offset();
			setTimeout(function(){
				jQuery('.menu-item-level0.wd-mega-menu.fullwidth-menu').each(function(index,value){
					var _cur_offset = jQuery(value).offset();
					var _margin_left = _cur_offset.left - _container_offet.left ;
					jQuery(value).children('ul.sub-menu').css('width',jQuery('.heade-bottom-content').outerWidth()).css('margin-left','-'+_margin_left+'px');
					
				});	
			},3000);			
		}));
	
		/******************START PANEL CONTROLLER*******************/
		
			// open and close custom panel
			var $et_control_panel = jQuery('#wd-control-panel'),
			$et_control_close = jQuery('#wd-control-close');

			$et_control_panel.animate( { left: -$et_control_panel.outerWidth() } );
			
			$et_control_close.click(function(){
				if ( jQuery(this).hasClass('control-open') ) {
					$et_control_panel.animate( { left: -jQuery("#wd-control-panel").outerWidth() } );
					jQuery(this).removeClass('control-open');
					jQuery.cookie('et_aggregate_control_panel_open', 0);
				} else {
					$et_control_panel.animate( { left: 0 } );
					jQuery(this).addClass('control-open');
					jQuery.cookie('et_aggregate_control_panel_open', 1);
				}
				return false;
			});
			if ( jQuery.cookie('et_aggregate_control_panel_open') == 1 ) { 
				$et_control_panel.animate( { left: 0 } );
				$et_control_close.addClass('control-open');
			}else{
				$et_control_panel.animate( { left: -jQuery("#wd-control-panel").outerWidth() } );
				$et_control_close.removeClass('control-open');
			}			
		/******************END PANEL CONTROLLER*******************/
		
		/******************START AJAX SAVE CONFIG*******************/
		jQuery('#font-clear-btn').click(function(event){
			jQuery.removeCookie("custom_datas");
			jQuery.removeCookie("page_layout");
			jQuery.removeCookie("bg_image");
			jQuery.removeCookie("bg_color");
			jQuery.removeCookie("body_font_style_str");
			jQuery.removeCookie("heading_font_style_str");
			jQuery.removeCookie("menu_font_style_str");
			jQuery('body').css( "background-image",'' );
			jQuery('body').css( "background-color","#f5f5f5" );		

			jQuery('#_page_layout').val('<?php echo esc_html($style_datas['page_layout']);?>').trigger('change');
			jQuery('ul.wd-background-patten > li.active').removeClass('active');
			
			custom_datas = orgin_custom_datas;
			setTimeout(function(){
				jQuery('#list_body_font').val(custom_datas['@body_font']);
				jQuery('#list_heading_font').val(custom_datas['@heading_font']);
				jQuery('#list_menu_font').val(custom_datas['@menu_font']);
			},1000);			
			
			less.modifyVars(custom_datas);
		});
		
		
			jQuery('#font-save-btn').click(function(event){
				
				var current_btn = jQuery(this);
				current_btn.button('loading');
			
				var ajax_data =  {
						//action
						action  				: 'wd_ajax_style'
						//verify nonce
						,ajax_preview			: jQuery('#preview_nonce_field').val()
						,page_layout 			: jQuery('#_page_layout').val()
						,body_font_style_str 	: jQuery('#body_font_weight').val() === null ? "" : jQuery('#body_font_weight').val()
						,heading_font_style_str	: jQuery('#heading_font_weight').val() === null ? "" : jQuery('#heading_font_weight').val()
						,menu_font_style_str	: jQuery('#menu_font_weight').val() === null ? "" : jQuery('#menu_font_weight').val()
						
				};	
				ajax_data = jQuery.extend(ajax_data, custom_datas);
				if( ajax_data['@body_font'] == 'Open Sans' )
					ajax_data['@body_font'] = -1;
				if( ajax_data['@heading_font'] == 'Open Sans')
					ajax_data['@heading_font'] = -1;
				if( ajax_data['@menu_font'] == 'Open Sans')
					ajax_data['@menu_font'] = -1;					
				
				
				jQuery.ajax({
					type  :'POST'
					,url   : '<?php echo admin_url('admin-ajax.php'); ?>'
					,data  : ajax_data
					,success : function(data){
						//console.log(data);
						if( parseInt(data) == 1 ){
							jQuery('#preview-save-result').html('Success').attr('class','alert alert-success').show()//.wait(3000).hide();
							setTimeout(								
								function(){
									jQuery('#preview-save-result').hide();
								},3000);
						}else{
							jQuery('#preview-save-result').html('Error!Sufficient permissions').attr('class','alert alert-error').show()//.wait(3000).hide();
							setTimeout(	
								function(){
									jQuery('#preview-save-result').hide();
								},3000);
						}	
						current_btn.button('reset');
					}			
				}).fail(function(){
					current_btn.button('reset');
				});
			});		

		
		
		/******************END AJAX SAVE CONFIG*******************/	

	});
	</script>	
	<?php
		}
	}
?>
<?php
	global $wd_default_custom_style_config;
	
	
	$custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
	$custom_style_config_arr = unserialize($custom_style_config);
	$custom_style_config_arr = wd_array_atts($wd_default_custom_style_config,$custom_style_config_arr);
	
	
	$enable_custom_preview = (int) $custom_style_config_arr['enable_custom_preview'];
	$enable_custom_font = 	(int) $custom_style_config_arr['enable_custom_font'];
	$enable_custom_color = 	(int) $custom_style_config_arr['enable_custom_color'];

	/***************Start font block****************/
	
	//$api_key = get_option(THEME_SLUG.'googlefont_api_key','AIzaSyAP4SsyBZEIrh0kc_cO9s90__r2oCJ8Rds');
	$api_key = get_option(THEME_SLUG.'googlefont_api_key','AIzaSyBVL7XGnZp8r-e0Xgr8pBo4kh6974i7bQA');
	$google_font_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=".$api_key;
	
	$body_font_name = $custom_style_config_arr['body_font_name'];
	$body_font_style = $custom_style_config_arr['body_font_style'];
	$body_font_style_str = $custom_style_config_arr['body_font_style_str'];
	//$body_font_size = $custom_style_config_arr['body_font_size'];
	$body_font_weight = $custom_style_config_arr['body_font_weight'];
	
	$heading_font_name = $custom_style_config_arr['heading_font_name'];
	$heading_font_style = $custom_style_config_arr['heading_font_style'];
	$heading_font_style_str = $custom_style_config_arr['heading_font_style_str'];
	//$heading_font_size = $custom_style_config_arr['heading_font_size'];
	$heading_font_weight = $custom_style_config_arr['heading_font_weight'];	

	$menu_font_name = $custom_style_config_arr['menu_font_name'];
	$menu_font_style = $custom_style_config_arr['menu_font_style'];
	$menu_font_style_str = $custom_style_config_arr['menu_font_style_str'];
	//$menu_font_size = $custom_style_config_arr['menu_font_size'];
	$menu_font_weight = $custom_style_config_arr['menu_font_weight'];

	$sub_menu_font_name = $custom_style_config_arr['sub_menu_font_name'];
	$sub_menu_font_style = $custom_style_config_arr['sub_menu_font_style'];
	$sub_menu_font_style_str = $custom_style_config_arr['sub_menu_font_style_str'];
	//$menu_font_size = $custom_style_config_arr['menu_font_size'];
	$sub_menu_font_weight = $custom_style_config_arr['sub_menu_font_weight'];	
	
	$font_sort =  $custom_style_config_arr['font_sort'];
	
	$font_sort_attr = array(
		 'popularity'
		,'alpha'
		,'date'
		,'style'
		,'trending'
	);
	
	/***************End font block****************/
	
	
	/***************Start custom color block****************/
	
	// $body_color = $custom_style_config_arr['body_color'];
	// $header_color = $custom_style_config_arr['header_color'];
	// $footer_color = $custom_style_config_arr['footer_color'];

	/***************End custom color block****************/
?>
<script type="text/javascript">
//<![CDATA[
	/**
	** 	position 
	**		0 : body
	** 		1 : heading
	**/
	function loadSelectedFont( font,font_weight,selector_id ){
		if(  font.length > 0 ){
			jQuery('head').append("<link id='" + font + "' href='http://fonts.googleapis.com/css?family="+font.replace(/ /g,'+')+( jQuery.trim(font_weight).length > 0 ? (':' + font_weight) : '' )+"' rel='stylesheet' type='text/css' />");
			if( font_weight.length > 0 ){
				if( font_weight == 'regular' ){
					font_weight = '400';
				}
				if( font_weight == 'italic' ){
					font_weight = '400italic';
				}						
				if( font_weight.indexOf('italic') >= 0 ){
					jQuery('#' + selector_id + ' > h3').css('font-style','italic');
					font_weight = font_weight.replace("italic","");
					jQuery('#' + selector_id + ' > h3').css('font-weight',font_weight);
				}else{
					jQuery('#' + selector_id + ' > h3').css('font-style','normal');
					jQuery('#' + selector_id + ' > h3').css('font-weight',font_weight);
				}
			}
			jQuery('#' + selector_id + ' > h3').css('font-family',font);
		}
	}
	//selector_id must be id without #
	//selector_weight_id must be selector_id+_weight
	
	function fillSelectedFont( font_options_html, font_config_array,selected_font ,selected_font_weight ,selector_id ){
		jQuery('#'+selector_id).html('<option value="-1">Default</option>').append( font_options_html ).val(selected_font);
		jQuery('#'+selector_id+'_weight').html('');
		if( selected_font != '-1' && selected_font.length > 0 ){
			font_weight_obj = font_config_array[selected_font][0][0];
			jQuery.each(font_weight_obj, function(i, obj) {
				selected_font_weight_str = ( selected_font_weight == obj ? "selected" : "");
				body_option_html = '<option value="'+obj+'"' + selected_font_weight_str + '>' + obj + '</option>';
				jQuery('#'+selector_id+'_weight').append(body_option_html);
			});	
			loadSelectedFont(selected_font,selected_font_weight,selector_id+"_demo");
		}else{
			loadDefaultFont('#'+selector_id);
		}
	}
	
	function set_color( selector_id,color_value ){
		jQuery(selector_id).find('input.span2').val(color_value);
		jQuery(selector_id).find('i').css('background-color',color_value);
	}
	
	function loadDefaultFont(selector_id,font){
		jQuery(selector_id).css('font-family',font).css('font-style','normal').css('font-weight',400);
	}
	
	jQuery(document).ready(function() {
		jQuery('.demo-font > h3').css('font-size','20px');
		font_config = new Array();		
		
		jQuery.ajax("<?php echo $google_font_url; ?>", {
				data : { sort: "<?php echo $font_sort;?>" }
				,dataType: 'jsonp'
				,success : function(data){
					if( typeof(data) == 'string' ){
						data = JSON.parse(data);
					}
					
					font_options_html = "";
					//apend list font to select box,prepare data for font array object
					jQuery.each(data.items, function(i, obj) {
						font_config[obj.family] = new Array(
							new Array(obj.variants)
							,new Array(obj.subsets)
						);
						font_options_html += '<option value="'+obj.family+'">' + obj.family + '</option>';;
						
					});			
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['body_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['body_font_style_str'];?>') ,"body_font");	
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['heading_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['heading_font_style_str'];?>') ,"heading_font");	
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['menu_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['menu_font_style_str'];?>') ,"menu_font");	
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['sub_menu_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['sub_menu_font_style_str'];?>') ,"sub_menu_font");	
					//end first font weight
			}
		});

			//select another font,reload font weight
			jQuery('#body_font,#heading_font,#site_title_font,#menu_font,#sub_menu_font,#link_font,#meta_font,#meta_link_font').change(function(event){
				font_weight_selector = '#'+jQuery(this).attr('id')+"_weight";
				font_demo_selector = jQuery(this).attr('id')+"_demo";
				jQuery(font_weight_selector).html('');
				if( jQuery(this).val() != '-1' ){
					weight_array = font_config[jQuery(this).val()][0];
					weight_array = weight_array[0];
					jQuery.each(weight_array, function(index, value) {
						option_weight_html = '<option value="'+value+'">' + value + '</option>';
						jQuery(font_weight_selector).append(option_weight_html);
					});
					loadSelectedFont(jQuery(this).val(),jQuery(font_weight_selector).val(),font_demo_selector);
				}else{
					loadDefaultFont(font_demo_selector);
				}

			});
			
		//change font weight
		jQuery('#body_font_weight,#heading_font_weight,#site_title_font_weight,#menu_font_weight,#sub_menu_font_weight,#link_font_weight,#meta_font_weight,#meta_link_font_weight').change(function(event){
			font_selector = jQuery(this).attr('id');
			font_selector = font_selector.replace("_weight",""); 
			loadSelectedFont(jQuery('#'+font_selector).val(),jQuery(this).val(),font_selector+"_demo");
		});
		
		
		
		//change sort order
		jQuery('#font_sort').change(function(event){
			jQuery.ajax("<?php echo $google_font_url; ?>", {
				data : { sort: jQuery(this).val() }
				,dataType: 'jsonp'
				,success : function(data){		
					if( typeof(data) == 'string' ){
						data = JSON.parse(data);
					}
										
					font_options_html = "";
					
					//apend list font to select box,prepare data for font array object
					jQuery.each(data.items, function(i, obj) {
						font_config[obj.family] = new Array(
							new Array(obj.variants)
							,new Array(obj.subsets)
						);
						font_options_html += '<option value="'+obj.family+'">' + obj.family + '</option>';;
						
					});

					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['body_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['body_font_style_str'];?>') ,"body_font");	
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['heading_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['heading_font_style_str'];?>') ,"heading_font");	
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['menu_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['menu_font_style_str'];?>') ,"menu_font");	
					fillSelectedFont(font_options_html,font_config,jQuery.trim('<?php echo $custom_style_config_arr['sub_menu_font_name'];?>') ,jQuery.trim('<?php echo $custom_style_config_arr['sub_menu_font_style_str'];?>') ,"sub_menu_font");	

				//mark load font success	
				
				}
			});
			
		});	


	//TODO
	/******************START COLOR PICKER*******************/
	$color_picker = jQuery('.colorpicker-select').colorpicker({'format':'hex'}).on('changeColor', function(ev){
		jQuery(this).children('input.span2').removeClass('invalid_color');
	});
	
	jQuery('.colorpicker-select > input.span2').each(function(index,value){
		jQuery(value).live('change',function(){
			var _is_hex  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(jQuery(this).val());
			var names_color = new Array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');
			var _post = names_color.indexOf(jQuery(this).val());
			if( _is_hex == false && _post < 0 ){
				var _cur_name = jQuery(this).attr('name');
				if( ( _cur_name == 'header_submenu_text_color') && jQuery(this).val() == '' ){
					return;
				}else{
					jQuery(this).val('Invalid Color').addClass('invalid_color');
				}	
			}else{
				jQuery(this).removeClass('invalid_color');
			}
		});
	});
	

	
	/******************END COLOR PICKER*******************/
	
		jQuery('#reset_custom_interface').click(function(event){
			event.preventDefault();
			set_color( "._primary_color" , "#000" );
			set_color( "._primary_second_color" , "#d70000" );
			set_color( "._primary_background_color" , "#fff" );
			set_color( "._heading_color" , "#000000" );
			set_color( "._primary_text_color" , "#000000" );
			set_color( "._border_color_primary" , "#cbcbcb" );
			set_color( "._primary_link_color" , "#000000" );
			
			set_color( "._button_background" , "#d70000" );
			set_color( "._button_text_color" , "#fff" );
			set_color( "._button_border_color" , "#d70000" );
			
			set_color( "._button_second_background" , "#fff" );
			set_color( "._button_second_text_color" , "#000" );
			set_color( "._border_second_button" , "#bfbfbf" );
			
			
			
			set_color( "._header_top_text_color" , "#000" );
			set_color( "._header_bottom_background" , "#fff" );
			set_color( "._header_bottom_text_color" , "#000" );
			set_color( "._header_border_bottom_color" , "#cbcbcb" );
			set_color( "._header_menu_background" , "#fff" );
			set_color( "._header_menu_text_color" , "#000" );
			
			set_color( "._header_submenu_text_color" , "#202020" );
			set_color( "._header_submenu_link_text_color" , "#202020" );
			set_color( "._header_submenu_border_color" , "#cbcbcb" );
			set_color( "._header_submenu_background_hover" , "#e6e6e8" );
			set_color( "._header_submenu_background_color" , "#fff" );
			
			set_color( "._background_tab" , "#FFF" );
			set_color( "._tab_border_color" , "#cbcbcb" );
			set_color( "._tab_text_color" , "#000" );
			set_color( "._tab_text_color_active" , "#fff" );
			
			set_color( "._tab_background_color_active" , "#000" );
			set_color( "._tab_border_color_active" , "#000" );
			
			//set_color( "._header_sub_menu_background" , "" );
			
			
			set_color( "._accordion_text_color" , "#000" );
			set_color( "._accordion_background_color" , "#fff" );
			
			
			set_color( "._footer_border_color" , "#cbcbcb" );
	//		set_color( "._footer_area_border_color" , "#000" );
			
			set_color( "._footer_first_area_background_color" , "#fff" );
			set_color( "._footer_first_area_text_color" , "#000" );
			set_color( "._footer_first_area_heading_color" , "#000" );
			
			set_color( "._footer_second_area_background_color" , "#fff" );
			set_color( "._footer_second_area_text_color" , "#000" );
			set_color( "._footer_second_area_heading_color" , "#000" );
							
				
			set_color( "._footer_thrid_area_text_color" , "#000" );	
			set_color( "._footer_thrid_area_background" , "#fff" );				
			
	//		set_color( "._footer_four_area_text_color" , "#000" );
	//		set_color( "._footer_four_area_heading_color" , "#000" );
			
	//		set_color( "._coppy_right_backgound_color" , "#fff" );
	//		set_color( "._coppy_right_text" , "#000" );
	//		set_color( "._coppy_right_border" , "#cbcbcb" );
			
			set_color( "._sidebar_text_color" , "#000" );
			set_color( "._sidebar_border_color" , "#b2b2b2" );
			set_color( "._sidebar_link_color" , "#d70000" );
			set_color( "._icon_color" , "#d70000" );
			set_color( "._filter" , "#2a2a2a" );
			set_color( "._sidebar_heading_color" , "#000" );

			set_color( "._feedback_background" , "#000" );
			set_color( "._totop_background" , "#000" );
			set_color( "._feedback_color_hover" , "#d70000" );
			//set_color( "._sale_background_color" , "#cc4c51" );		
		//	set_color( "._sale_text_color" , "#fff" );
		//	set_color( "._feature_background_color" , "#d70000" );
		//	set_color( "._feature_text_color" , "#fff" );
			set_color( "._rating_color" , "#d70000" );
			
			//set_color( "._text_shortcode" , "#2a2a2a" );
			set_color( "._label_text_color" , "#fff" );

			
			jQuery('#body_font').val('-1').trigger('change');
			jQuery('#heading_font').val('-1').trigger('change');
			jQuery('#menu_font').val('-1').trigger('change');
			jQuery('#sub_menu_font').val('-1').trigger('change');
		});		
		
	});
//]]>
</script>


<div id="tab-custom-interface" class="custom-interface-tab">
    <div class="tab-title">
        <h2><span><?php _e('Custom Interface','wpdance'); ?></span></h2>
    </div>
	<div class="tab-content">
		<form name="config-custom-interface" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data" id="config-custom-interface">
			
			<div class="select-layout area-config area-config1">
				<div class="area-inner">
					<div class="area-inner1">
						<h3 class="area-title"><?php _e('Preview Panel','wpdance'); ?></h3>
						<?php $this->wd_showTooltip(__(" Preview Panel ",'wpdance'),__('Enable/Disable The Frontend Preview Panel.','wpdance')); ?>
						<div class="area-content">
						
							<div class="toggle-enable">
								<label>Enable Preview Panel</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="select-toggle-enable" name="enable-custom-preview" id="enable_custom_preview">
												<option value="0" <?php if(!$enable_custom_preview) echo 'selected';?>>No</option>
												<option value="1" <?php if($enable_custom_preview) echo 'selected';?>>Yes</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->		
							</div>
						</div><!-- .area-content -->
					</div>	
				</div>	
			</div><!-- .select-layout -->			
			
			
			<div class="select-layout area-config area-config1">
				<div class="area-inner">
					<div class="area-inner1">
						<h3 class="area-title"><?php _e('Site Layout','wpdance'); ?></h3>
						<?php $this->wd_showTooltip(__(" Site Layoutl ",'wpdance'),__('Change Site Layout Style.Box Style going to support custom Background and Color','wpdance')); ?>
						<div class="area-content">
						
							<div class="toggle-enable">
								<label>Site Layout Style</label>
								<div class="bg-input select-box " >
									<?php $page_layout = $custom_style_config_arr['page_layout'];?>
										<div class="bg-input-inner">
											<select class="select-toggle-enable" name="page_layout" id="_page_layout">
												<option value="wide" <?php if( strcmp($page_layout,'wide') == 0 ) echo 'selected';?>>Wide</option>
												<option value="box" <?php if( strcmp($page_layout,'box') == 0 ) echo 'selected';?>>Box</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->		
							</div>
						</div><!-- .area-content -->
					</div>	
				</div>	
			</div><!-- .select-layout -->				
			
			<div class="select-layout area-config area-config1">
				<div class="area-inner">
					<div class="area-inner1">
						<h3 class="area-title"><?php _e('Custom Font','wpdance'); ?></h3>
						<?php $this->wd_showTooltip(__(" Custom Font ",'wpdance'),__('Change font.Include more than 500 fonts from google','wpdance')); ?>
						<div class="area-content">
						
							<div class="toggle-enable">
								<label>Enable Custom Font</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="select-toggle-enable" name="enable-custom-font" id="enable_custom_font">
												<option value="0" <?php if(!$enable_custom_font) echo 'selected';?>>No</option>
												<option value="1" <?php if($enable_custom_font) echo 'selected';?>>Yes</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->		
							</div>
							
							
							<?php
								/*Naming Conversation
								* AAA = Conversation
								* SELECT LIST FONT NAME
								*		id : AAA_font
								*		name : AAA_font
								*		class : list-AAA-font
								* SELECT LIST FONT WEIGHT 
								*		id : AAA_font_weight
								*		name : AAA_font_style_str
								*		class : 
								* DEMO TEXT :
								*		id : AAA_font_demo
								*
								*
								*/
							?>
							<div class="select-box-content-sort">
							<label>Font Sort</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="font-sort" name="font_sort" id="font_sort">
												<?php if(!empty($font_sort_attr)):?>
													<?php foreach($font_sort_attr as $cs):?>
														<option value="<?php echo $cs; ?>" <?php if(trim($cs) == trim( $font_sort )):?>selected<?php endif;?>><?php echo $cs; ?></option>	
													<?php endforeach;?>
												<?php endif;?>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->													
							
							<!----------------START BODY FONT--------------->
							<div id="body_font_demo" class="demo-font" style="padding-top:20px;clear:both;">
								<h3>This is body font</h3>
							</div>
						
							<div class="select-box-content">
							<label>Body Font</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="list-body-font" name="body_font" id="body_font">
												<option value="-1">Default</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->	
							
							<div class="select-box-content-sort">
							<label>Body Font weight</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="font-weight" name="body_font_style_str" id="body_font_weight">
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->								
							

							<input type="hidden" name="body_font_hidden" class="body_font" value="<?php //echo $body_font; ?>"/>
							<br>
							<!----------------END BODY FONT--------------->							
							
							
							<!----------------START HEADING FONT--------------->
							
							<div id="heading_font_demo" class="demo-font" style="padding-top:20px;clear:both;">
								<h3>This is heading font</h3>
							</div>
						
							<div class="select-box-content">
							<label>Heading Font</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="list-heading-font" name="heading_font" id="heading_font">
												<option value="-1">Default</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->	
							
							<div class="select-box-content-sort">
							<label>Heading Font weight</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="font-weight" name="heading_font_style_str" id="heading_font_weight">
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->								
							
							<!----------------END HEADING FONT--------------->							
							
							<!----------------START MENU FONT--------------->
							<div id="menu_font_demo" class="demo-font" style="padding-top:20px;clear:both;">
								<h3>This is menu font</h3>
							</div>
							
							<div class="select-box-content">
							<label>Menu Font</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="list-menu-top-level-font" name="menu_font" id="menu_font">
												<option value="-1">Default</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->	
							
							<div class="select-box-content-sort">
							<label>Menu Font Weight</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="list-menu-top-level-font-weight" name="menu_font_style_str" id="menu_font_weight">
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->		
							
							<!----------------END MENU FONT--------------->	
							
							<!----------------START SUB MENU FONT--------------->
							<div id="sub_menu_font_demo" class="demo-font" style="padding-top:20px;clear:both;">
								<h3>This is sub menu font</h3>
							</div>
							
							<div class="select-box-content">
							<label>Sub Menu Font</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="list-menu-top-level-font" name="sub_menu_font" id="sub_menu_font">
												<option value="-1">Default</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->	
							
							<div class="select-box-content-sort">
							<label>Sub Menu Font Weight</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="list-menu-top-level-font-weight" name="sub_menu_font_style_str" id="sub_menu_font_weight">
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->	
							</div><!-- .select-box -->		
							
							<!----------------END MENU FONT--------------->	

						</div><!-- .area-content -->
					</div>	
				</div>	
			</div><!-- .select-layout -->			
			


			
			<div class="color-scheme area-config area-config1">
				<div class="area-inner">
					<div class="area-inner1">
						<h3 class="area-title"><?php _e('Color Scheme','wpdance'); ?></h3>
						<?php $this->wd_showTooltip(__("Color Scheme",'wpdance'),__('Select color scheme for theme','wpdance')); ?>
						<div class="area-content">

							<div class="toggle-enable">
								<label>Enable Custom Color</label>
								<div class="bg-input select-box " >
										<div class="bg-input-inner">
											<select class="select-toggle-enable" name="enable-custom-color" id="enable_custom_color">
												<option value="0" <?php if(!$enable_custom_color) echo 'selected';?>>No</option>
												<option value="1" <?php if($enable_custom_color) echo 'selected';?>>Yes</option>
											</select>
										</div><!-- .bg-input-inner -->
								</div><!-- .select-box -->		
							</div>						
						
							<div>
							<label>Background : Go to Appearance => Background</label>
							</div>	
							
							
							<hr style="clear:both;margin:10px 0px;">
							
							<div class="color-picker-wrapper">
								<label>Primary Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _primary_color" data-color="<?php echo esc_html($custom_style_config_arr['primary_color']);?>" data-color-format="hex">
											<input name="primary_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['primary_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['primary_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
							<label>Primary Second Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _primary_second_color" data-color="<?php echo esc_html($custom_style_config_arr['primary_second_color']);?>" data-color-format="hex">
											<input name="primary_second_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['primary_second_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['primary_second_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							<!--
							<div class="color-picker-wrapper">
								<label>Heading Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
											<div id="heading-color-picker" class="input-append color colorpicker-select _heading_color" data-color="<?php //echo esc_html($custom_style_config_arr['heading_color']);?>" data-color-format="hex">
												<input name="heading_color" type="text" class="span2" value="<?php //echo esc_html($custom_style_config_arr['heading_color']);?>" >
											<span class="add-on"><i style="background-color: <?php //echo esc_html($custom_style_config_arr['heading_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>									
							-->
							<div class="color-picker-wrapper">
								<label>Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _primary_text_color" data-color="<?php echo esc_html($custom_style_config_arr['primary_text_color']);?>" data-color-format="hex">
											<input name="primary_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['primary_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['primary_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							
							<div class="color-picker-wrapper">
								<label>Primary Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _border_color_primary" data-color="<?php echo esc_html($custom_style_config_arr['border_color_primary']);?>" data-color-format="hex">
											<input name="border_color_primary" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['border_color_primary']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['border_color_primary']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Primary Link Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _primary_link_color" data-color="<?php echo esc_html($custom_style_config_arr['primary_link_color']);?>" data-color-format="hex">
											<input name="primary_link_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['primary_link_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['primary_link_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							
							
							<div class="color-picker-wrapper">
							<label>Primary Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _primary_background_color" data-color="<?php echo esc_html($custom_style_config_arr['primary_background_color']);?>" data-color-format="hex">
											<input name="primary_background_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['primary_background_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['primary_background_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<hr style="clear:both;margin:10px 0px;">

							<div class="color-picker-wrapper">
								<label>Button Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _button_background" data-color="<?php echo esc_html($custom_style_config_arr['button_background']);?>" data-color-format="hex">
											<input name="button_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['button_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['button_background']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							<div class="color-picker-wrapper">
								<label>Button Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _button_text_color" data-color="<?php echo esc_html($custom_style_config_arr['button_text_color']);?>" data-color-format="hex">
											<input name="button_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['button_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['button_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Button Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _button_border_color" data-color="<?php echo esc_html($custom_style_config_arr['button_border_color']);?>" data-color-format="hex">
											<input name="button_border_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['button_border_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['button_border_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<hr style="clear:both;margin:10px 0px;">
							
							<div class="color-picker-wrapper">
								<label>Button Second Background</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _button_second_background" data-color="<?php echo esc_html($custom_style_config_arr['button_second_background']);?>" data-color-format="hex">
											<input name="button_second_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['button_second_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['button_second_background']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							<div class="color-picker-wrapper">
								<label>Button Second Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _button_second_text_color" data-color="<?php echo esc_html($custom_style_config_arr['button_second_text_color']);?>" data-color-format="hex">
											<input name="button_second_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['button_second_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['button_second_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							<div class="color-picker-wrapper">
								<label>Button Second Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _border_second_button" data-color="<?php echo esc_html($custom_style_config_arr['border_second_button']);?>" data-color-format="hex">
											<input name="border_second_button" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['border_second_button']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['border_second_button']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>	
							
							<hr style="clear:both;margin:10px 0px;">
							
							<div class="color-picker-wrapper">
								<label>Tab Background</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _background_tab" data-color="<?php echo esc_html($custom_style_config_arr['background_tab']);?>" data-color-format="hex">
											<input name="background_tab" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['background_tab']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['background_tab']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>					
							
							<div class="color-picker-wrapper">
							<label>Tab Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _tab_border_color" data-color="<?php echo esc_html($custom_style_config_arr['tab_border_color']);?>" data-color-format="hex">
											<input name="tab_border_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['tab_border_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['tab_border_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
								<label>Tab Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _tab_text_color" data-color="<?php echo esc_html($custom_style_config_arr['tab_text_color']);?>" data-color-format="hex">
											<input name="tab_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['tab_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['tab_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
							<label>Tab Text Color Active</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _tab_text_color_active" data-color="<?php echo esc_html($custom_style_config_arr['tab_text_color_active']);?>" data-color-format="hex">
											<input name="tab_text_color_active" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['tab_text_color_active']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['tab_text_color_active']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Tab Border Color Active</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _tab_border_color_active" data-color="<?php echo esc_html($custom_style_config_arr['tab_border_color_active']);?>" data-color-format="hex">
											<input name="tab_border_color_active" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['tab_border_color_active']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['tab_border_color_active']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Tab Background Color Active</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _tab_background_color_active" data-color="<?php echo esc_html($custom_style_config_arr['tab_background_color_active']);?>" data-color-format="hex">
											<input name="tab_background_color_active" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['tab_background_color_active']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['tab_background_color_active']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Accordion Text_color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _accordion_text_color" data-color="<?php echo esc_html($custom_style_config_arr['accordion_text_color']);?>" data-color-format="hex">
											<input name="accordion_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['accordion_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['accordion_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Accordion Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _accordion_background_color" data-color="<?php echo esc_html($custom_style_config_arr['accordion_background_color']);?>" data-color-format="hex">
											<input name="accordion_background_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['accordion_background_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['accordion_background_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<hr style="clear:both;margin:10px 0px;">
							
							

							<!--
							<div class="color-picker-wrapper">
							<label>Menu Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_menu_text_color" data-color="<?php //echo esc_html($custom_style_config_arr['header_menu_text_color']);?>" data-color-format="hex">
											<input name="header_menu_text_color" type="text" class="span2" value="<?php //echo esc_html($custom_style_config_arr['header_menu_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php //echo esc_html($custom_style_config_arr['header_menu_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>								
							-->
							<!--<div class="color-picker-wrapper">
							<label>Sub Menu Backgroud Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_sub_menu_background" data-color="<?php //echo esc_html($custom_style_config_arr['header_sub_menu_background']);?>" data-color-format="hex">
											<input name="header_sub_menu_background" type="text" class="span2" value="<?php //echo esc_html($custom_style_config_arr['header_sub_menu_background']);?>" >
											<span class="add-on"><i style="background-color: <?php //echo esc_html($custom_style_config_arr['header_sub_menu_background']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>	-->							
							
															
							
															
							
							
							
							<div class="color-picker-wrapper">
							<label>Header Top Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_top_text_color" data-color="<?php echo esc_html($custom_style_config_arr['header_top_text_color']);?>" data-color-format="hex">
											<input name="header_top_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_top_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_top_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							
							
							<div class="color-picker-wrapper">
							<label>Header Bottom Background</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_bottom_background" data-color="<?php echo esc_html($custom_style_config_arr['header_bottom_background']);?>" data-color-format="hex">
											<input name="header_bottom_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_bottom_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_bottom_background']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							<!--
							<div class="color-picker-wrapper">
							<label>Header Bottom Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_bottom_text_color" data-color="<?php echo esc_html($custom_style_config_arr['header_bottom_text_color']);?>" data-color-format="hex">
											<input name="header_bottom_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_bottom_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_bottom_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Header Bottom Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_border_bottom_color" data-color="<?php echo esc_html($custom_style_config_arr['header_border_bottom_color']);?>" data-color-format="hex">
											<input name="header_border_bottom_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_border_bottom_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_border_bottom_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							-->
							<div class="color-picker-wrapper">
							<label>Header Slider Background Color[in Homepage2]</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_menu_background" data-color="<?php echo esc_html($custom_style_config_arr['header_menu_background']);?>" data-color-format="hex">
											<input name="header_menu_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_menu_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_menu_background']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>	
							
							<div class="color-picker-wrapper">
							<label>Header Menu Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_menu_text_color" data-color="<?php echo esc_html($custom_style_config_arr['header_menu_text_color']);?>" data-color-format="hex">
											<input name="header_menu_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_menu_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_menu_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Sub Menu Link Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_submenu_link_text_color" data-color="<?php echo esc_html($custom_style_config_arr['header_submenu_link_text_color']);?>" data-color-format="hex">
											<input name="header_submenu_link_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_submenu_link_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_submenu_link_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Header Submenu Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_submenu_text_color" data-color="<?php echo esc_html($custom_style_config_arr['header_submenu_text_color']);?>" data-color-format="hex">
											<input name="header_submenu_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_submenu_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_submenu_text_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Header Submenu Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_submenu_border_color" data-color="<?php echo esc_html($custom_style_config_arr['header_submenu_border_color']);?>" data-color-format="hex">
											<input name="header_submenu_border_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_submenu_border_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_submenu_border_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Header Submenu Background Hover Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_submenu_background_hover" data-color="<?php echo esc_html($custom_style_config_arr['header_submenu_background_hover']);?>" data-color-format="hex">
											<input name="header_submenu_background_hover" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_submenu_background_hover']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_submenu_background_hover']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							<div class="color-picker-wrapper">
							<label>Header Submenu Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="header-color-picker" class="input-append color colorpicker-select _header_submenu_background_color" data-color="<?php echo esc_html($custom_style_config_arr['header_submenu_background_color']);?>" data-color-format="hex">
											<input name="header_submenu_background_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['header_submenu_background_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['header_submenu_background_color']);?>"></i></span>
										</div>
									</div>
								</div>
							</div>
							
							
							
							
							
							
							<hr style="clear:both;margin:10px 0px;">
							
							<div class="color-picker-wrapper">
								<label>Footer First Area Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="footer-color-picker" class="input-append color colorpicker-select _footer_first_area_background_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_first_area_background_color']);?>" data-color-format="hex">
											<input name="footer_first_area_background_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_first_area_background_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_first_area_background_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Footer Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="footer-color-picker" class="input-append color colorpicker-select _footer_border_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_border_color']);?>" data-color-format="hex">
											<input name="footer_border_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_border_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_border_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							<div class="color-picker-wrapper">
								<label>Footer Second Area Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="footer-color-picker" class="input-append color colorpicker-select _footer_second_area_background_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_second_area_background_color']);?>" data-color-format="hex">
											<input name="footer_second_area_background_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_second_area_background_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_second_area_background_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							
							
							<div class="color-picker-wrapper">
								<label>Footer First Area Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _footer_first_area_text_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_first_area_text_color']);?>" data-color-format="hex">
											<input name="footer_first_area_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_first_area_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_first_area_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Footer First Area Heading Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _footer_first_area_heading_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_first_area_heading_color']);?>" data-color-format="hex">
											<input name="footer_first_area_heading_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_first_area_heading_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_first_area_heading_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Footer Second Area Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _footer_second_area_text_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_second_area_text_color']);?>" data-color-format="hex">
											<input name="footer_second_area_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_second_area_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_second_area_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
														
							
							<div class="color-picker-wrapper">
								<label>Footer Second Area Heading Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _footer_second_area_heading_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_second_area_heading_color']);?>" data-color-format="hex">
											<input name="footer_second_area_heading_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_second_area_heading_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_second_area_heading_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Footer Third Area Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _footer_thrid_area_text_color" data-color="<?php echo esc_html($custom_style_config_arr['footer_thrid_area_text_color']);?>" data-color-format="hex">
											<input name="footer_thrid_area_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_thrid_area_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_thrid_area_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Footer Third Area Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="color-1-color-picker" class="input-append color colorpicker-select _footer_thrid_area_background" data-color="<?php echo esc_html($custom_style_config_arr['footer_thrid_area_background']);?>" data-color-format="hex">
											<input name="footer_thrid_area_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['footer_thrid_area_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['footer_thrid_area_background']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							
							<hr style="clear:both;margin:10px 0px;">
							
							<div class="color-picker-wrapper">
								<label>Sidebar Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _sidebar_text_color" data-color="<?php echo esc_html($custom_style_config_arr['sidebar_text_color']);?>" data-color-format="hex">
											<input name="sidebar_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['sidebar_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['sidebar_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							<div class="color-picker-wrapper">
								<label>Sidebar Border Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _sidebar_border_color" data-color="<?php echo esc_html($custom_style_config_arr['sidebar_border_color']);?>" data-color-format="hex">
											<input name="sidebar_border_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['sidebar_border_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['sidebar_border_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>

							<div class="color-picker-wrapper">
								<label>Sidebar Link Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _sidebar_link_color" data-color="<?php echo esc_html($custom_style_config_arr['sidebar_link_color']);?>" data-color-format="hex">
											<input name="sidebar_link_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['sidebar_link_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['sidebar_link_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>		
							
							<div class="color-picker-wrapper">
								<label>Sidebar Heading Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _sidebar_heading_color" data-color="<?php echo esc_html($custom_style_config_arr['sidebar_heading_color']);?>" data-color-format="hex">
											<input name="sidebar_heading_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['sidebar_heading_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['sidebar_heading_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Icon Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _icon_color" data-color="<?php echo esc_html($custom_style_config_arr['icon_color']);?>" data-color-format="hex">
											<input name="icon_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['icon_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['icon_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>Filter By Price Bar Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _filter" data-color="<?php echo esc_html($custom_style_config_arr['filter']);?>" data-color-format="hex">
											<input name="filter" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['filter']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['filter']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>	

															
						
							
							
							<hr style="clear:both;margin:10px 0px;">
							
							<div class="color-picker-wrapper">
								<label>Feedback Button Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _feedback_background" data-color="<?php echo esc_html($custom_style_config_arr['feedback_background']);?>" data-color-format="hex">
											<input name="feedback_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['feedback_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['feedback_background']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>	
							
							<div class="color-picker-wrapper">
								<label>Feedback Color Hover</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _feedback_color_hover" data-color="<?php echo esc_html($custom_style_config_arr['feedback_color_hover']);?>" data-color-format="hex">
											<input name="feedback_color_hover" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['feedback_color_hover']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['feedback_color_hover']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
							<div class="color-picker-wrapper">
								<label>To Top Button Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _totop_background" data-color="<?php echo esc_html($custom_style_config_arr['totop_background']);?>" data-color-format="hex">
											<input name="totop_background" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['totop_background']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['totop_background']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>	

								

							<!--<div class="color-picker-wrapper">
								<label>Sale Label Background Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="hover-color-picker" class="input-append color colorpicker-select _sale_background_color" data-color="<?php //echo esc_html($custom_style_config_arr['sale_background_color']);?>" data-color-format="hex">
											<input name="sale_background_color" type="text" class="span2" value="<?php //echo esc_html($custom_style_config_arr['sale_background_color']);?>" >
											<span class="add-on"><i style="background-color: <?php //echo esc_html($custom_style_config_arr['sale_background_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>-->	



							<div class="color-picker-wrapper">
								<label>Rating Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="rating-color-picker" class="input-append color colorpicker-select _rating_color" data-color="<?php echo esc_html($custom_style_config_arr['rating_color']);?>" data-color-format="hex">
											<input name="rating_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['rating_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['rating_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>								
							<!--
							<div class="color-picker-wrapper">
								<label>Text Shortcode</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="rating-color-picker" class="input-append color colorpicker-select _text_shortcode" data-color="<?php //echo esc_html($custom_style_config_arr['text_shortcode']);?>" data-color-format="hex">
											<input name="text_shortcode" type="text" class="span2" value="<?php //echo esc_html($custom_style_config_arr['text_shortcode']);?>" >
											<span class="add-on"><i style="background-color: <?php //echo esc_html($custom_style_config_arr['text_shortcode']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							-->
							<div class="color-picker-wrapper">
								<label>Label Text Color</label>
								<div class="bg-input color-picker-inner" >
									<div class="bg-input-inner">
										<div id="rating-color-picker" class="input-append color colorpicker-select _label_text_color" data-color="<?php echo esc_html($custom_style_config_arr['label_text_color']);?>" data-color-format="hex">
											<input name="label_text_color" type="text" class="span2" value="<?php echo esc_html($custom_style_config_arr['label_text_color']);?>" >
											<span class="add-on"><i style="background-color: <?php echo esc_html($custom_style_config_arr['label_text_color']);?>"></i></span>
										</div>
									</div>
								</div>	
							</div>
							
						</div><!-- .area-content -->
					</div>	
				</div>	
			</div><!-- .color-scheme -->
			
			<div class="bottom-actions">
			   <div class="actions">
				   <input type="hidden" name="edit-custom_interface" value="1"/>
				   <input type="hidden" name="load_font_succes" id="load_font_succes" class="load_font_succes" value="0"/>
				   <input type="hidden" name="action" value="custom_interface_config" />
				   <button type="button" id="reset_custom_interface" class="button btn-reset"><span><span><?php _e('Reset Default','wpdance')?></span></span></button>
				   <button type="submit" class="button btn-save"><span><span><?php _e('Save Changes','wpdance')?></span></span></button>
			   </div><!-- End .actions -->
			</div><!-- End .bottom-actions -->
			
		</form>
	</div><!-- .tab-content -->
</div><!-- .custom-interface-tab -->

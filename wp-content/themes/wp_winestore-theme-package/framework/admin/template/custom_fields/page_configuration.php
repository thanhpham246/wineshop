<?php 
	global $post;
	$revolution_exists = 1;//( class_exists('RevSlider') && class_exists('UniteFunctionsRev') );
	$datas = unserialize(get_post_meta($post->ID,THEME_SLUG.'page_configuration',true));
	$datas = wd_array_atts(array(
										"page_layout" 			=> '0'
										,"page_column"			=> '0-1-0'
										,"left_sidebar" 		=>'primary-widget-area'
										,"right_sidebar" 		=> 'primary-widget-area'
										,"page_slider" 			=> 'none'
										,"page_revolution" 		=> ''
										,"page_flex" 			=> ''
										,"page_nivo" 			=> ''		
										,"product_tag" 			=> ''	
										,"hide_breadcrumb" 		=> 0		
										,"hide_title" 			=> 0											
										,"hide_ads" 			=> 0													
								),$datas);								
?>
<div class="page_config_wrapper">
	<div class="page_config_wrapper_inner">
		<input type="hidden" value="1" name="_page_config">
		<?php wp_nonce_field( "_update_page_config", "nonce_page_config" ); ?>
		<ul class="page_config_list">
			<li class="first">
				<p>
					<label><?php _e('Layout Style','wpdance');?> : 
						<select name="page_layout" id="page_layout">
							<option value="0" <?php if( strcmp($datas['page_layout'],'0') == 0 ) echo "selected";?>>Default</option>
							<option value="wide" <?php if( strcmp($datas['page_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
							<option value="box" <?php if( strcmp($datas['page_layout'],'box') == 0 ) echo "selected";?>>Box</option>
						</select>
					</label>
				</p> 
			</li>
			<li>
				<p>
					<label><?php _e('Page Layout','wpdance');?> : 
						<select name="page_column" id="page_column">
							<option value="0-1-0" <?php if( strcmp($datas['page_column'],'0-1-0') == 0 ) echo "selected";?>>Fullwidth</option>
							<option value="1-1-0" <?php if( strcmp($datas['page_column'],'1-1-0') == 0 ) echo "selected";?>>Left Sidebar</option>
							<option value="0-1-1" <?php if( strcmp($datas['page_column'],'0-1-1') == 0 ) echo "selected";?>>Right Sidebar</option>
							<option value="1-1-1" <?php if( strcmp($datas['page_column'],'1-1-1') == 0 ) echo "selected";?>>Left & Right Sidebar</option>
						</select>
					</label>
				</p> 
			</li>
			

			<li>
				<p>
					<label><?php _e('Left Sidebar','wpdance');?> : 
						<select name="left_sidebar" id="_left_sidebar">
							<?php
								global $wd_default_sidebars;
								foreach( $wd_default_sidebars as $key => $_sidebar ){
									$_selected_str = ( strcmp($datas["left_sidebar"],$_sidebar['id']) == 0 ) ? "selected='selected'"  : "";
									echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
								}
							?>
						</select>
					</label>
				</p> 
			</li>
			<li>
				<p>
					<label><?php _e('Right Sidebar','wpdance');?> : 
						<select name="right_sidebar" id="_right_sidebar">
							<?php
								global $wd_default_sidebars;
								foreach( $wd_default_sidebars as $key => $_sidebar ){
									$_selected_str = ( strcmp($datas["right_sidebar"],$_sidebar['id']) == 0 ) ? "selected='selected'"  : "";
									echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
								}
							?>
						</select>
					</label>
				</p> 
			</li>			
			
			<li>
				<p>
					<label><?php _e('Page Slider','wpdance');?> : 
						<select name="page_slider" id="page_slider">
							<option value="none" <?php if( strcmp($datas['page_slider'],'none') == 0 ) echo "selected";?>>No Slider</option>
							<option value="revolution" <?php if( strcmp($datas['page_slider'],'revolution') == 0 ) echo "selected";?>>Revolution Slider</option>
							<option value="flex" <?php if( strcmp($datas['page_slider'],'flex') == 0 ) echo "selected";?>>Flex Slider</option>
							<option value="nivo" <?php if( strcmp($datas['page_slider'],'nivo') == 0 ) echo "selected";?>>Nivo Slider</option>
							<option value="product" <?php if( strcmp($datas['page_slider'],'product') == 0 ) echo "selected";?>>Product Slider</option>
						</select>
					</label>
				</p> 			
			</li>
			<?php if( $revolution_exists ):?>
			<li>
				<p>
					<label><?php _e('Revolution Slider','wpdance');?> : 
					
					<?php
						$slider = new RevSlider();
						$arrSliders = $slider->getArrSlidersShort();
						$sliderID = $datas['page_revolution'];
					?>
					
					<?php echo $select = UniteFunctionsRev::getHTMLSelect($arrSliders,$sliderID,'name="page_revolution" id="page_revolution_id"',true); ?>					
					</label>
				</p> 			
			</li>
			<?php endif;?>
			<li>
				<p>
					<label><?php _e('Flex Slider','wpdance');?> : 
						<select name="page_flex" id="page_flex_id">
						
						<?php 
							$_flex_slider = wd_get_all_post_list('slide');
							foreach( $_flex_slider as $_slide ){
						?>	
						
							<option value="<?php echo $_slide[0];?>" <?php if( $_slide[0] == (int)$datas['page_flex'] ) echo "selected";?>><?php echo $_slide[1];?></option>
						
						<?php	
							}
						?>
						
						</select>
					</label>
				</p> 			
			</li>
			<li>
				<p>
					<label><?php _e('Nivo Slider','wpdance');?> : 
						<select name="page_nivo" id="page_nivo_id">

						<?php 
							$_flex_slider = wd_get_all_post_list('slide');
							foreach( $_flex_slider as $_slide ){
						?>	
						
							<option value="<?php echo $_slide[0];?>" <?php if( $_slide[0] == (int)$datas['page_nivo'] ) echo "selected";?>><?php echo $_slide[1];?></option>
						
						<?php	
							}
						?>						
						
						</select>
					</label>
				</p> 			
			</li>			
			<li>
				<p>
					<label><?php _e('Product Slider','wpdance');?> : 
					<?php
						$tags = get_terms( array('product_tag') );
						$html = '<select class="product_tag" name="product_tag">';
						$selectedStr = '';
						foreach ($tags as $index => $tag){
							$tagSlug = $tag->slug ;
							if( !isset($datas['product_tag']) )
								$datas['product_tag'] = 'all-product-tags';
							$selectedStr = strcmp(esc_html($datas['product_tag']),$tagSlug) == 0 ? "selected" : '';	
							if( $index == 0 ){
								$html .= "<option value='all-product-tags' {$selectedStr}>All Tags</option>";
							}
							
							$html .= "<option value='{$tagSlug}' {$selectedStr}>";
							$html .= "{$tag->name}</option>";
						}
						$html .= '</select>';
						echo $html; 
					?>		
					</label>
				</p> 			
			</li>
			
			<li class="last">
				<p>
					<label><?php _e('Hide Breadcrumb','wpdance');?> : 
						<select name="hide_breadcrumb" id="_hide_breadcrumb">
							<option value="0" <?php if( absint($datas['hide_breadcrumb']) == 0 ) echo "selected";?>>No</option>
							<option value="1" <?php if( absint($datas['hide_breadcrumb']) == 1 ) echo "selected";?>>Yes</option>
						</select>
					</label>
				</p> 			
			</li>
			<li class="last">
				<p>
					<label><?php _e('Hide Page Title','wpdance');?> : 
						<select name="hide_title" id="_hide_title">
							<option value="0" <?php if( absint($datas['hide_title']) == 0 ) echo "selected";?>>No</option>
							<option value="1" <?php if( absint($datas['hide_title']) == 1 ) echo "selected";?>>Yes</option>
						</select>
					</label>
				</p> 			
			</li>
			<!--
			<li class="last">
				<p>
					<label><?php _e('Hide Header Advertisement','wpdance');?> : 
						<select name="hide_ads" id="_hide_ads">
							<option value="0" <?php if( absint($datas['hide_ads']) == 0 ) echo "selected";?>>No</option>
							<option value="1" <?php if( absint($datas['hide_ads']) == 1 ) echo "selected";?>>Yes</option>
						</select>
					</label>
				</p> 			
			</li>			
			-->
		</ul>
	</div>
</div>

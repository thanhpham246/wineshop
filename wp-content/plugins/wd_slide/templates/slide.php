<?php
/////////// Shortcode show slideshow //////////////
if(!function_exists ('slideshow_function')){
	function slideshow_function($atts,$content){
		extract(shortcode_atts(array(
			'width'     => '400'
			,'height'    => '250'
		),$atts));
		$portfolio_slider_config_width = $width;
		$portfolio_slider_config_height = $height;
		$portfolio_sliders = array();
		$math = preg_match_all('/\[slide(.*?)\]/ism',$content,$slides_math);
		if( $math ){
			for( $i = 0 ; $i < count($slides_math[1]) ; $i++ ){
				$slides_math[1][$i] = str_replace("'",'"',$slides_math[1][$i]);
				$math = preg_match_all('/\s*?(.*?)\s*?=\s*?"(.*?)"\s*?/ism',$slides_math[1][$i],$slides_math_slide);				
				if( $math ){
					$slides_math_end = array_combine(array_map("trim", $slides_math_slide[1]), $slides_math_slide[2]);
					array_push($portfolio_sliders,$slides_math_end);
				}
			}
		}
		$_rand_id = 'carousel_manual'.rand();
		
		$control_html = $slides_html = '';
		$active_class = "active";
		foreach( $portfolio_sliders as $index => $_this_slider ){
			$img_html = '';
			$crop_img = $_this_slider['image'];
			if( $portfolio_slider_config_width > 0 ){
				$img_html .= " width=\"{$portfolio_slider_config_width}\"";
				//$crop_img = print_thumbnail($_this_slider['image'],true,'',$portfolio_slider_config_width,'','',false,true);
			}	
			if( $portfolio_slider_config_height > 0 ){
				$img_html .= " height=\"{$portfolio_slider_config_height}\"";
				//$crop_img = print_thumbnail($_this_slider['image'],true,'','',$portfolio_slider_config_height,'',false,true);
			}	
			if( $portfolio_slider_config_height > 0 &&  $portfolio_slider_config_width > 0 )
				//$crop_img = print_thumbnail($_this_slider['image'],true,'',$portfolio_slider_config_width,$portfolio_slider_config_height,'',false,true);
				
			$control_html .= "<li data-target=\"#{$_rand_id}\" data-slide-to=\"{$index}\" class=\"{$active_class}\"></li>";
            $slides_html .= "
				<div class=\"item {$active_class}\">
						<img src=\"{$_this_slider['image']}\" alt=\"{$_this_slider['image_title']}\" title=\"{$_this_slider['image_title']}\" {$img_html}>
                    <div class=\"carousel-caption\">
						<a href=\"{$_this_slider['slide_link']}\"><h4>{$_this_slider['title']}</h4></a>
						<p>{$_this_slider['description']}</p>
                    </div>
                </div>";		
			
			$active_class = '';
		}
		$control_html = "<ol class=\"carousel-indicators\">".$control_html."</ol>";
		$slides_html = "<div class=\"carousel-inner\">".$slides_html."</div>";
		 
		$end_html = "
		    <a class=\"left carousel-control\" href=\"#{$_rand_id}\" data-slide=\"prev\">&lsaquo;</a>
            <a class=\"right carousel-control\" href=\"#{$_rand_id}\" data-slide=\"next\">&rsaquo;</a>
		";
		$result = "<div class='wd_slide carousel slide'  id='{$_rand_id}'>{$control_html}{$slides_html}{$end_html}</div>";		
		return $result; 
	}
}
add_shortcode('slideshow','slideshow_function');

if(!function_exists ('slide_function')){
	function slide_function($atts){
		extract(shortcode_atts(array(
			'id'    		 => -1

		),$atts));
		if ( !post_type_exists( 'slide' ) ) {
			return;
		}
		return wd_show_fredsel_slider($id);
	}
}
add_shortcode('slider','slide_function');
	
if(!function_exists ('wd_show_fredsel_slider')){
	function wd_show_fredsel_slider($post_id){
		if( (int)$post_id > 0 ){
			$slider_datas = get_post_meta($post_id,THEME_SLUG.'_portfolio_slider',true);
			$slider_datas = unserialize($slider_datas);

			
			$slider_configs = get_post_meta($post_id,THEME_SLUG.'_portfolio_slider_config',true);
			$slider_configs = wd_array_atts(array(
															"portfolio_slider_config_autoslide" => 1
															,"portfolio_slider_config_size" => 'slider'
														),unserialize($slider_configs));	

			
			$_custom_size = $slider_configs['portfolio_slider_config_size'];
			$_width = 208;
										
			switch ($_custom_size) {
				case 'slideshow':
					$_width = 960;
					break;
				case 'slider':
					$_width = 208;
					break;
				case 'blog_thumb':
					$_width = 280;
					break;
				case 'prod_midium_thumb_1':
					$_width = 510;
					break;
				case 'prod_midium_thumb_2':
					$_width = 366;
					break;
				case 'prod_small_thumb':
					$_width = 141;
					break;
				case 'prod_homepage2':
					$_width = 120;
					break;
				case 'prod_tini_thumb':
					$_width = 75;
					break;
				case 'slider_thumb_wide':
					$_width = 150;
					break;
				case 'slider_thumb_box':
					$_width = 100;
					break;
				case 'related_thumb':
					$_width = 190;
					break;					
			}							

							
			if( is_array($slider_datas) && count($slider_datas) > 0 ){
				$_random_id = "fredsel_" . $post_id . "_" . rand();
				
				ob_start();
				
				?>
				<div class="featured_product_slider_wrapper shortcode_slider" id="<?php echo $_random_id;?>">
					<div class="fredsel_slider_wrapper_inner">
						<ul>
							<?php
								foreach( $slider_datas as $_slider ){
							?>	
								<li>
									<a href="#" title="<?php echo $_slider['slide_title'];?>">
										<?php echo wp_get_attachment_image( $_slider['thumb_id'], $_custom_size , false, array('title' => $_slider['title'], 'alt' => $_slider['title']) ); ?>
									</a>
								</li>
							<?php
								}
							?>						
						</ul>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						// Using custom configuration
						jQuery("#<?php echo $_random_id?> > .fredsel_slider_wrapper_inner > ul").carouFredSel({
							items 				: {
								width: <?php echo $_width;?>
								,height: 'auto'<?php //echo $slider_configs['portfolio_slider_config_height'];?>
								,visible: {
									min: 1
									,max: 6
								}							
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { onMouse: true, onTouch: true }		
							,scroll				: { items : 1,
													duration : 1000
													, pauseOnHover:true
													, easing : "easeInOutCirc"}
							,width				: '100%'
							,height				: '100%'<?php //echo $slider_configs['portfolio_slider_config_height'];?>
							,circular			: true
							,infinite			: true
							,auto				: <?php echo (int)$slider_configs['portfolio_slider_config_autoslide'] == 1 ? "true" : "false";?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							,pagination 		: '#<?php echo $_random_id;?>_pager'						
						});	
					});
					//]]>
				</script>
				<?php	
				return ob_get_clean();
			}
		}		
	}
}

/////////// Shortcode show slider of recent portfolio list //////////////
// if(!function_exists ('ew_recent_slider')){
	// function ew_recent_slider($atts){
		// extract(shortcode_atts(array(
			// 'width'     => 227,
			// 'height'    => 147,
			// 'showposts' => 30,
			// 'post_type' => 'portfolio',
			// 'auto_play' => 'true',
			// 'delay' 	=> 5,
			// 'class'		=>	'recent',
			// 'num_pic_per_slide'	=>	4,
			// 'category'	=>	'',
			// 'gallery'	=>	''
		// ),$atts));
		// return show_slider($width,$height,$showposts,$post_type,$auto_play,$delay,$class,$num_pic_per_slide,$category,$gallery);
	// }
// }
// add_shortcode('ew_recent_slider','ew_recent_slider');
?>
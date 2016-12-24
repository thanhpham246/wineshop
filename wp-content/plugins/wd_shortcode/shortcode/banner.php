<?php

	if(!function_exists('banner_shortcode_function')){
		function banner_shortcode_function($atts,$content){
			extract(shortcode_atts(array(
				'style'					=> ""
				,'link_url'				=> "#" 
				,'bg_image' 			=> ""
				,'bg_color'				=> "none" 
				,'title'				=> "Big title goes here" 
				,'title_color'			=> "#fff" 
				,'subtitle'				=> "Subtitle goes here" 
				,'subtitle_color'		=> "#fff" 
				,'top_padding'			=> "20px"
				,'bottom_padding'		=> "20px" 				
				,'left_padding'			=> "20px" 
				,'border_color' 		=> "#000"
				,'inner_stroke' 		=> "2px"
				,'inner_stroke_color' 	=> "#fff"				
				,'sep_color' 			=> "#fff"
				,'sep_padding'			=> "5px" 
				,'label'				=> "no"
				,'label_bg_color'		=> "#000"
				,'label_text_color'		=> "#fff" 
				,'label_text' 			=> "Label Text"
				,'label_img' 			=> ""		

			),$atts));
			ob_start();
			$title_class = '';
			if(strlen(trim($style)) > 0){
				$style = ' '.$style;
			}
			?>
			
			<div class="shortcode_wd_banner<?php echo $style; ?>" onclick="location.href='<?php echo $link_url;?>'" style="background-color:<?php echo $border_color;?>; background-image:url('<?php echo $bg_image;?>')">
				<?php if( absint($label) == 1 || strcmp($label,'yes') == 0 || strcmp($label,'Yes') == 0 ):?>
					<?php $title_class="has_label"; ?>
				<?php endif;?>
				<div class="shortcode_wd_banner_inner" style="padding:<?php echo $top_padding;?> <?php echo $left_padding;?> <?php echo $bottom_padding;?> <?php echo $left_padding;?>; background-color:<?php echo $bg_color;?>; border: <?php echo $inner_stroke;?> solid <?php echo $inner_stroke_color;?>">
					<?php if( absint($label) == 1 || strcmp($label,'yes') == 0 || strcmp($label,'Yes') == 0 ):?>
						<div class="shortcode_banner_simple_bullet" style="background:<?php echo $label_bg_color;?>; color:<?php echo $label_text_color;?>"><img title="label_banner" alt="label_banner" src="<?php echo $label_img; ?>" /><span><?php echo $label_text;?></span></div>
					<?php endif;?>
				
					<div><h3 class="heading-title banner-title <?php echo $title_class; ?>" style="color:<?php echo $title_color;?>"><?php echo do_shortcode($title);?></h3></div>
					<div class="shortcode_banner_simple_sep" style="margin:<?php echo $sep_padding;?> auto; background-color:<?php echo $sep_color;?>;"></div>
					<div><h4 class="heading-title banner-sub-title" style="color:<?php echo $subtitle_color;?>"><?php echo do_shortcode($subtitle);?></h4></div>
				</div>
				
			</div>
					
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
	add_shortcode('banner','banner_shortcode_function');
?>
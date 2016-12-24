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
			}	
			if( $portfolio_slider_config_height > 0 ){
				$img_html .= " height=\"{$portfolio_slider_config_height}\"";
			}	

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
		$result = "<div class='carousel slide' id='{$_rand_id}'>{$control_html}{$slides_html}{$end_html}</div>";		
		
		return $result; 
	}
}
add_shortcode('slideshow','slideshow_function');

if(!function_exists ('slide_function')){
	function slide_function($atts){
		extract(shortcode_atts(array(
			'id'    		 => -1

		),$atts));
		return wd_show_fredsel_slider($id);
	}
}
add_shortcode('slider','slide_function');


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
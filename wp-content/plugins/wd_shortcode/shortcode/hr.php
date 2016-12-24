<?php
if(!function_exists ('ew_hr')){
	function ew_hr($atts,$content = false){
		extract(shortcode_atts(array(
			'style'			=>	'long-background',
		),$atts));
		//add_filter('the_content','ew_do_shortcode',1001);
		return "<div class='hr' style='{$style}'></div>";
	}
} 
add_shortcode('hr','ew_hr');
?>
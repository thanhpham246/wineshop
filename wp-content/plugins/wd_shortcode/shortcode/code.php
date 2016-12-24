<?php
if(!function_exists ('ew_code')){
	function ew_code($atts,$content = false){
		extract(shortcode_atts(array(
		),$atts));
		return "<div class='border-code'><div class='background-code'><pre class='code'>".esc_html($content)."</pre></div></div>";
	}
} 
add_shortcode('code','ew_code');
?>
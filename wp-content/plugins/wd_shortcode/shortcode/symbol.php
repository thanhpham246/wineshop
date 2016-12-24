<?php 

if(!function_exists ('hightlight_text')){
	function hightlight_text($atts,$content){
		extract(shortcode_atts(array(
			'background'=>'000'
		),$atts));
		return "<span style='background-color:{$background};padding-left:2px'>{$content}</span>";
	}
}
add_shortcode('hightlight_text','hightlight_text');

if(!function_exists ('add_line')){
	function add_line($atts)
	{
		extract(shortcode_atts(array(
						'height_line'	=>	'1'
						,'color'		=>	'black'
						,'class'		=>	''
		),$atts));
		return "<span class='add-line {$class}' style='height:{$height_line}px;background-color:{$color};'>wpdance</span>";

	}
}
add_shortcode('add_line','add_line');



if(!function_exists ('icon_function')){
	function icon_function($atts)
	{
		extract(shortcode_atts(array(
						'icon'=>''
		),$atts));
		if( strlen($icon)>0 )
			return "<i class=\"{$icon}\"></i>";
		return '';

	}
}

add_shortcode('icon','icon_function');

if(!function_exists ('hide_phone_function')){
	function hide_phone_function($atts,$content){
		return "<div class='hidden-phone'>".do_shortcode($content)."</div>";
	}
}

add_shortcode('hidden_phone','hide_phone_function');


if(!function_exists ('dropcap_function')){
	function dropcap_function($atts,$content)
	{
		extract(shortcode_atts(array(
						'color'=>''
		),$atts));
		if( strlen($color) > 0 ){
			$inline_css = " style=\"color:{$color}\"";
		}
		return "<span class=\"dropcap\"{$inline_css}>{$content}</span>";

	}
}
add_shortcode('dropcap','dropcap_function');
?>
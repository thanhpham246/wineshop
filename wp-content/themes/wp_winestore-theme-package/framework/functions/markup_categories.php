<?php
// add first-cat-item, last-cat-item class for categories html
if(!function_exists('wd_add_markup_categories')){
	function wd_add_markup_categories($output) {
		$output= preg_replace('/cat-item/', ' first-cat-item cat-item', $output, 1);
		$output=substr_replace($output, " last-cat-item cat-item", strripos($output, "cat-item"), strlen("cat-item"));
		return $output;
	}
}
add_filter('wp_list_categories', 'wd_add_markup_categories');
?>

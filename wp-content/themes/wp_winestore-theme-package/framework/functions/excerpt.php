<?php 
//print an excerpt by specifying a maximium number of characters
if(!function_exists ('wd_the_excerpt_max_charlength')){
	function wd_the_excerpt_max_charlength($charlength,$post = '',$echo = true) {
		if($post){
			$excerpt = wp_strip_all_tags(wd_get_the_excerpt_here($post->ID));
		}
		else
			$excerpt = get_the_excerpt();
		$charlength++;
		
		if(strlen($excerpt)>$charlength) {
		   $subex = substr($excerpt,0,$charlength-5);
		   $exwords = explode(" ",$subex);
		   $excut = -(strlen($exwords[count($exwords)-1]));
		   if($excut<0) {
				$result =  substr($subex,0,$excut);
		   } else {
				$result = $subex;
		   }
			$result .= "...";
	   } else {
		   $result =  $excerpt;
	   }
		if($echo)
			echo $result;
		return $result;
	}
}

if(!function_exists ('wd_string_limit_words')){
	function wd_string_limit_words($string, $word_limit){
	  $words = explode(' ', $string, ($word_limit + 1));
	  if(count($words) > $word_limit)
	  array_pop($words);
	  return implode(' ', $words);
	}
}

if(!function_exists ('wd_the_excerpt_max_words')){
	function wd_the_excerpt_max_words($word_limit,$post = '',$echo = true) {
		if($post){
			$excerpt = wp_strip_all_tags(wd_get_the_excerpt_here($post->ID));
		}
		else
			$excerpt = get_the_excerpt();
		$result = wd_string_limit_words($excerpt,$word_limit);
		if($echo)
			echo $result;
		return $result;
	}
}

if(!function_exists ('wd_get_the_excerpt_here')){
	function wd_get_the_excerpt_here($post_id)
	{
		global $wpdb;
		$query = "SELECT post_excerpt,post_content FROM $wpdb->posts WHERE ID = $post_id LIMIT 1";
		$result = $wpdb->get_results($query, ARRAY_A);
		if($result[0]['post_excerpt'])
			return $result[0]['post_excerpt'];
		else
			return $result[0]['post_content'];
	}
}
?>
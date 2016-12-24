<?php
/* Print ads in header */
if(!function_exists ('wd_printHeaderAds')){
	function wd_printHeaderAds(){
		$headerAdsType = esc_attr(get_option(THEME_SLUG.'headerAdsType'));
		$headerAdsImg = esc_url(get_option(THEME_SLUG.'headerAdsImg'));
		$headerAdsUrl = esc_url(get_option(THEME_SLUG.'headerAdsUrl'));
		$headerAdsTitle = esc_attr(get_option(THEME_SLUG.'headerAdsTitle'));
		$headerAdsCode = esc_attr(get_option(THEME_SLUG.'headerAdsCode'));
		if(strcmp('code',$headerAdsType)==0){
			echo $headerAdsCode;
		}
		elseif(strcmp('banner',$headerAdsType)==0){
			strlen($headerAdsUrl) <= 0 ? $headerAdsUrl = "#" : $headerAdsUrl;
			if(strlen($headerAdsImg) <= 0) {
				$headerAdsImg = get_template_directory_uri().'/images/advertisement.png'; 
			}
			echo "<a href='$headerAdsUrl'><img src='$headerAdsImg' title ='$headerAdsTitle' alt ='$headerAdsTitle'/></a>";
		}else{
			echo "<img src=\"";
			echo get_template_directory_uri();
			echo "/images/advertisement.png\"/ alt=\"your ads here\"><p>advertisement</p>";
		}
	}
}

/* Print ads in content */
if(!function_exists ('wd_printContentAds')){
	function wd_printContentAds(){
		$headerAdsType = esc_attr(get_option(THEME_SLUG.'contentAdsType'));
		$headerAdsImg = esc_url(get_option(THEME_SLUG.'contentAdsImg'));
		$headerAdsUrl = esc_url(get_option(THEME_SLUG.'contentAdsUrl'));
		$headerAdsTitle = esc_attr(get_option(THEME_SLUG.'contentAdsTitle'));
		$headerAdsCode = esc_attr(get_option(THEME_SLUG.'contentAdsCode'));
		if(strcmp('code',$headerAdsType)==0){
			echo $headerAdsCode;
		}
		elseif(strcmp('banner',$headerAdsType)==0){
			strlen($headerAdsUrl) <= 0 ? $headerAdsUrl = "#" : $headerAdsUrl;
			if(strlen($headerAdsImg) <= 0) {
				$headerAdsImg = get_template_directory_uri().'/images/advertisement_content.png'; 
			}
			echo "<a href='$headerAdsUrl'><img src='$headerAdsImg' title ='$headerAdsTitle' alt ='$headerAdsTitle'/></a>";
		}else{
			echo "<img src=\"";
			echo get_template_directory_uri();
			echo "/images/advertisement_content.png\"/ alt=\"your ads here\"><p>advertisement</p>";
		}
	}
}
?>
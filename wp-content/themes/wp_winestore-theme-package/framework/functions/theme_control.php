<?php
/**************************important hook**************************/

//add_filter( 'option_posts_per_page' , 'wd_change_posts_per_page'); //filter and change posts_per_page
add_action ('pre_get_posts','wd_prepare_post_query',9); //hook into pre_get_posts to reset some querys

/*merge query post type function*/

function wd_merge_post_type($query,$new_type = array()){
	$defaut_post_type = ( post_type_exists( 'portfolio' ) ? array('portfolio','post') : array('post') );
	$new_type = (is_array($new_type) && count($new_type) > 0) ? $new_type : $defaut_post_type;
	$default_post_type = $query->get('post_type');
	if(is_array($default_post_type)){
		$new_type = array_merge($default_post_type, $new_type);
	}else{
		$new_type = array_merge(array($default_post_type), $new_type);
	}
	return ( $new_type = array_unique($new_type) );
}
/*end merge query post type function*/

function wd_remove_page_from_search_query($where_query){
	$where_query .= " AND wp_posts.post_type NOT IN ('page') ";
	return $where_query;
}

function wd_add_a2z_query($where_query){
	$_start_char = get_query_var('start_char');
	$_up_char = strtoupper($_start_char);
	$_down_char = strtolower($_start_char);
	$where_query .= " AND left(wp_posts.post_title,1) IN ('{$_up_char}','{$_down_char}') ";
	return $where_query;
}


function wd_prepare_post_query($query){
	global $wd_page_datas,$post;
	$paged = (int)get_query_var('paged');
		
	if($paged>0){
		set_query_var('page',$paged);
	}
	if($query->is_tag()){
		$query->set('post_type',wd_merge_post_type($query) );
	}
	if($query->is_search()){	
//		add_action( "posts_where", "wd_remove_page_from_search_query", 10 );
	}	
	if($query->is_date()){
		$query->set('post_type',wd_merge_post_type($query) );
	}

	if($query->is_author()){
		$query->set('post_type',wd_merge_post_type($query) );
	}
	return $query;
}

add_action( 'template_redirect', 'wd_page_template_redirect' );

function wd_page_template_redirect(){
	global $wp_query,$post,$wd_page_datas;
	if($wp_query->is_page()){
		global $wd_page_datas,$wd_custom_style_config;
		$wd_page_datas = unserialize(get_post_meta($post->ID,THEME_SLUG.'page_configuration',true));
		$wd_page_datas = wd_array_atts(array(	
											"page_layout" 			=> '0'
											,"page_column" 			=> '0-1-0'
											,"left_sidebar" 		=> 'primary-widget-area'
											,"right_sidebar" 		=> 'primary-widget-area'
											,"page_slider" 			=> 'none'
											,"page_revolution" 		=> ''
											,"page_flex" 			=> ''
											,"page_nivo" 			=> ''		
											,"product_tag"			=> ''
											,"hide_breadcrumb" 		=> 0	
											,"hide_ads" 			=> 0	
											,"hide_title" 			=> 0	
										),$wd_page_datas);		
		$wd_custom_style_config['page_layout'] = strcmp($wd_page_datas['page_layout'],'0') == 0 ? $wd_custom_style_config['page_layout'] : $wd_page_datas['page_layout'] ;
		
	
	}
	
	if( is_tax( 'product_cat' ) ){
		global $wp_query,$wd_category_prod_datas;
		$category_product_config = get_option(THEME_SLUG.'category_product_config','');
		$category_product_config = unserialize($category_product_config);
		
		$wd_category_prod_datas = wd_array_atts(
			array(
						'cat_columns' 				=> 3
						,'cat_layout' 				=> "1-1-0"
						,'cat_left_sidebar' 		=> "category-widget-area"
						,'cat_right_sidebar' 		=> "category-widget-area"
				)
			,$category_product_config);	
			
		/******************* Start Load Config On Category Product ******************/
		$term = $wp_query->queried_object;
		
		$_term_config = get_metadata( 'woocommerce_term', $term->term_id, "cat_config", true );
		
		
		if( strlen($_term_config) > 0 ){
			$_term_config = unserialize($_term_config);	
			
			if( is_array($_term_config) && count($_term_config) > 0 ){
				$wd_category_prod_datas['cat_columns'] = ( isset($_term_config['cat_columns']) && strlen($_term_config['cat_columns']) > 0 && (int)$_term_config['cat_columns'] != 0 ) ? $_term_config['cat_columns'] : $wd_category_prod_datas['cat_columns'];
				$wd_category_prod_datas['cat_layout'] = ( isset($_term_config['cat_layout']) && strlen($_term_config['cat_layout']) > 0 && strcmp($_term_config["cat_layout"],'0') != 0 ) ? $_term_config['cat_layout'] : $wd_category_prod_datas['cat_layout'];
				$wd_category_prod_datas['cat_left_sidebar'] = ( isset($_term_config['cat_left_sidebar']) && strlen($_term_config['cat_left_sidebar']) > 0 && strcmp($_term_config["cat_left_sidebar"],'0') != 0 ) ? $_term_config['cat_left_sidebar'] : $wd_category_prod_datas['cat_left_sidebar'];
				$wd_category_prod_datas['cat_right_sidebar'] = ( isset($_term_config['cat_right_sidebar']) && strlen($_term_config['cat_right_sidebar']) > 0 && strcmp($_term_config["cat_right_sidebar"],'0') != 0 ) ? $_term_config['cat_right_sidebar'] : $wd_category_prod_datas['cat_right_sidebar'];
				$wd_category_prod_datas['cat_custom_content'] = ( isset($_term_config['cat_custom_content']) && strlen($_term_config['cat_custom_content']) > 0 ) ? $_term_config['cat_custom_content'] : "";
			}
			
		}			
		/******************* End Config On Category Product ******************/	
			
	}
	if ( is_singular('product') ) {
		global $wd_single_prod_datas,$post;
		$wd_single_prod_datas = get_option(THEME_SLUG.'single_product_config','');
		$wd_single_prod_datas = unserialize($wd_single_prod_datas);
		$wd_single_prod_datas = wd_array_atts(
			array(
					'show_image' 			=> 1
					,'show_label' 			=> 1
					,'show_title' 			=> 1
					,'show_sku' 			=> 1
					,'show_review' 			=> 1
					,'show_availability' 	=> 1
					,'show_add_to_cart' 	=> 1
					,'show_price' 			=> 1
					,'show_short_desc'		=> 1
					,'show_meta' 			=> 1
					,'show_related' 		=> 1
					,'show_sharing'			=> 1
					,'related_title' 		=> __("Related Products","wpdance")
					,'sharing_title' 		=> "Share this"
					,'sharing_intro' 		=> "Love it?Share with your friend"
					,'sharing_custom_code' 	=> ""
					,'show_ship_return' 	=> 1				
					,'ship_return_title' 	=> 'FREE SHIPPING & RETURN'	
					,'ship_return_content' 	=>  htmlentities('<a href="#"><img src="http://demo.wpdance.com/imgs/woocommerce/return_shipping.png" alt="free shipping and return" title="free shipping and return"></a><div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'."'".'s standard dummy text ever since the 1500s</div>')
					,'show_tabs' 			=> 1
					,'show_custom_tab' 		=> 1	
					,'custom_tab_title' 	=> "Custom Title"				
					,'custom_tab_content' 	=> "<div>Table content goes here</div>"				
					,'show_upsell' 			=> 1
					,'upsell_title'			=> __("YOU MAY ALSO BE INTERESTED IN THE FOLLOWING PRODUCT(S)",'wpdance')
					,'layout' 				=> '0-1-0'
					,'left_sidebar' 		=> 'product-widget-area'
					,'right_sidebar' 		=> 'product-widget-area'	
				)
			,$wd_single_prod_datas);	
		/******************* Start Load Config On Single Post ******************/
		$_prod_config = get_post_meta($post->ID,THEME_SLUG.'custom_product_config',true);
		if( strlen($_prod_config) > 0 ){
			$_prod_config = unserialize($_prod_config);
			if( is_array($_prod_config) && count($_prod_config) > 0 ){
				$wd_single_prod_datas['layout'] = ( isset($_prod_config['layout']) && strlen($_prod_config['layout']) > 0 && strcmp($_prod_config["layout"],'0') != 0 ) ? $_prod_config['layout'] : $wd_single_prod_datas['layout'];
				$wd_single_prod_datas['left_sidebar'] = ( isset($_prod_config['left_sidebar']) && strlen($_prod_config['left_sidebar']) > 0 && strcmp($_prod_config["left_sidebar"],'0') != 0 ) ? $_prod_config['left_sidebar'] : $wd_single_prod_datas['left_sidebar'];
				$wd_single_prod_datas['right_sidebar'] = ( isset($_prod_config['right_sidebar']) && strlen($_prod_config['right_sidebar']) > 0 && strcmp($_prod_config["right_sidebar"],'0') != 0 ) ? $_prod_config['right_sidebar'] : $wd_single_prod_datas['right_sidebar'];
			}
		}			
		/******************* End Config On Single Post ******************/

		
		if( !$wd_single_prod_datas['show_image'] ){
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );	
		}
		if( !$wd_single_prod_datas['show_label'] ){
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		}
		if( !$wd_single_prod_datas['show_title'] ){
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		}
		if( !$wd_single_prod_datas['show_sku'] ){
			remove_action( 'woocommerce_single_product_summary', 'wd_template_single_sku', 9 );
		}
		if( !$wd_single_prod_datas['show_review'] ){
			remove_action( 'woocommerce_single_product_summary', 'wd_template_single_review', 7 );
		}
		if( !$wd_single_prod_datas['show_availability'] ){
			remove_action( 'woocommerce_single_product_summary', 'wd_template_single_availability', 8 );
		}
		if( !$wd_single_prod_datas['show_add_to_cart'] ){	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		}

		if( !$wd_single_prod_datas['show_price'] ){
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		}
		if( !$wd_single_prod_datas['show_short_desc'] ){	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}
		if( !$wd_single_prod_datas['show_meta'] ){	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}
		if( !$wd_single_prod_datas['show_related'] ){	
			//remove_action( 'woocommerce_after_single_product_summary', 'wd_output_related_products', 9 );
			//add_filter( "single_product_wrapper_class", "wd_update_single_product_wrapper_class", 10);
		}else{
			global $post;
			$_product = get_product($post);
			if ( sizeof( $_product->get_related() ) == 0 )
				add_filter( "single_product_wrapper_class", "wd_update_single_product_wrapper_class", 10);
		}

		if( !$wd_single_prod_datas['show_sharing'] ){
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_template_single_sharing', 25 );
		}
		if( !$wd_single_prod_datas['show_ship_return'] ){
			remove_action( 'woocommerce_product_thumbnails', 'wd_template_shipping_return', 30 );
		}
		if( !$wd_single_prod_datas['show_tabs'] ){
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		}	
		if( !$wd_single_prod_datas['show_custom_tab'] ){
			remove_filter( 'woocommerce_product_tabs', 'wd_addon_custom_tabs',13 );
		}		

		if( !$wd_single_prod_datas['show_upsell'] ){
		//	remove_action( 'woocommerce_after_single_product_summary', 'wd_upsell_display', 15 );
		}	
		
	}
	
	if( is_archive() || is_page_template('page-templates/blog-template.php') || is_home() ){
		global $archive_page_config;
		$archive_page_config = get_option(THEME_SLUG.'archive_page_config','');
		$archive_page_config = unserialize($archive_page_config);
		
		$archive_page_config = wd_array_atts(
			array(
					'show_category' 					=> 1
					,'show_author_post_link' 			=> 1
					,'show_time' 						=> 1
					,'show_tags' 						=> 1
					,'show_comment_count' 				=> 1
					,'show_excerpt' 					=> 1
					,'show_thumb' 						=> 1
					,'show_content' 					=> 1
					,'show_read_more' 					=> 1				
					,'show_category_phone' 				=> 1
					,'show_author_post_link_phone' 		=> 1
					,'show_time_phone' 					=> 1
					,'show_tags_phone' 					=> 1
					,'show_comment_count_phone' 		=> 1
					,'show_excerpt_phone' 				=> 1
					,'show_thumb_phone' 				=> 1
					,'show_content_phone' 				=> 1
					,'show_read_more_phone' 			=> 1			
				)
			,$archive_page_config);		
	}
}


function wd_change_posts_per_page($option_posts_per_page){
	global $wp_query;
	if($wp_query->is_search()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_search') > 0 ? (int)get_option(THEME_SLUG.'num_post_search') : $option_posts_per_page );
        return $posts_per_page;
	}
	//if($wp_query->is_front_page() || $wp_query->is_home()){
	if( $wp_query->is_home() ){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_home') > 0 ? (int)get_option(THEME_SLUG.'num_post_home') : $option_posts_per_page );
        return $posts_per_page;
	}
	//if( is_page_template('page-templates/blog-template.php') ){
	if( $wp_query->is_page() ){
		$blog_template_array = array('blog-template.php','blogtemplate.php','portfolio.php');
		//$template_name = get_post_meta( $wp_query->queried_object_id, '_wp_page_template', true );
		$template_name = get_post_meta( $wp_query->query_vars['page_id'], '_wp_page_template', true );
		if(in_array($template_name,$blog_template_array)){
			$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_blog_page') > 0 ? (int)get_option(THEME_SLUG.'num_post_blog_page') : $option_posts_per_page );
			return $posts_per_page;
		}
	}

	if($wp_query->is_single()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_related') > 0 ? (int)get_option(THEME_SLUG.'num_post_related') : $option_posts_per_page );
        return $posts_per_page;
	}
	if($wp_query->is_category()){
		
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_cat') > 0 ? (int)get_option(THEME_SLUG.'num_post_cat') : $option_posts_per_page );
        return $posts_per_page;
	}
	if($wp_query->is_tag()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_tag') > 0 ? (int)get_option(THEME_SLUG.'num_post_tag') : $option_posts_per_page );
        return $posts_per_page;
	}
    if ($wp_query->is_category() ) {
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_cat') > 0 ? (int)get_option(THEME_SLUG.'num_post_cat') : $option_posts_per_page );
        return $posts_per_page;
    }
	if($wp_query->is_archive()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_archive') > 0 ? (int)get_option(THEME_SLUG.'num_post_archive') : $option_posts_per_page );
        return $posts_per_page;
	}
    return $option_posts_per_page;
}

/**************************end the hook**************************/
?>
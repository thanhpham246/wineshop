<?php 
class CustomFields extends AdminTheme 
{
	public function __construct(){
		add_action("admin_init", array($this,"wd_generateCustomFields"));
		define('THEME_ADMIN_CUSTMOM_FIELDS_TPL', THEME_ADMIN_TPL . '/custom_fields');
		add_action('save_post', array($this,'wd_saveCustomField'));
		$this->wd_resetArrLayout();
	}
	
	public function wd_generateCustomFields(){
		// Add shortcode Generator
		add_meta_box("wp_cp_shortcode_generator", "Shortcode Generator", array($this,"wd_createShortcodeGenerator"), "post", "normal", "high");
		add_meta_box("wp_cp_shortcode_generator", "Shortcode Generator", array($this,"wd_createShortcodeGenerator"), "page", "normal", "high");	
		add_meta_box("page_config", "Page Configuration", array($this,"wd_page_configuration"), "page", "normal", "high");
		// add_meta_box("wp_cp_custom_video", "Portfolio Config", array($this,"wd_showvideo"), "portfolio", "normal", "high");
		// add_meta_box("wp_cp_custom_images", "Portfolio Images", array($this,"wd_showimages"), "portfolio", "normal", "high");
		add_meta_box("wp_cp_custom_carousels", "Insert Slider", array($this,"wd_showcarousel"), "slide", "normal", "high");
		
		if(post_type_exists('product')) {
			add_meta_box("wp_cp_custom_product_layout", "Config Product", array($this,"wd_product_layout"), "product", "normal", "high");
		}		
	}
	
	
	public function wd_product_layout(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/custom_layout.php';
	}
	
	/* 
		Save config of custom fields for current post
		Input : int $post_id (the id of current post).
		No output.
	*/
	public function wd_saveCustomField($post_id){
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		if(isset($_POST['_inline_edit'])) 
        return $post_id;
		if( isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'list' )
			return $post_id;	
		if( isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'trash' )
			return $post_id;			
		// Save featured for post
		if(isset($_POST['featured_post']))
			update_post_meta($post_id,THEME_SLUG.'featured_post',$_POST['featured_post']);
			
		// Save video link for post
		if(isset($_POST['video_portfolio']))
			update_post_meta($post_id,THEME_SLUG.'video_portfolio',$_POST['video_portfolio']);
			
		// Save video link for portfolio
		if(isset($_POST['custom_link_portfolio']))
			update_post_meta($post_id,THEME_SLUG.'custom_link_portfolio',$_POST['custom_link_portfolio']);	
			
		// Save layout for custom page
		if(isset($_POST['custom_page_layout']))
			update_post_meta($post_id,THEME_SLUG.'custom_page_layout',$_POST['custom_page_layout']);
			
		// Save product custom layout & sidebar
		if( isset($_POST['custom_product_layout']) && $_POST['custom_product_layout'] == "custom_single_prod_layout" ){
			$_default_prod_config = array(
				'layout' 					=> $_POST['single_layout']
				,'left_sidebar' 			=> $_POST['single_left_sidebar']
				,'right_sidebar' 			=> $_POST['single_right_sidebar']		
			);		
			$ret_str = serialize($_default_prod_config);
			update_post_meta($post_id,THEME_SLUG.'custom_product_config',$ret_str);	
		}
		
		if(isset($_POST['custom_sidebar']))
			update_post_meta($post_id,THEME_SLUG.'custom_sidebar',$_POST['custom_sidebar']);
			
			
		// Save Gallery for slideshow
		if(isset($_POST['gal_slideshow']))
			update_post_meta($post_id,THEME_SLUG.'gal_slideshow',$_POST['gal_slideshow']);
		
		// Save select for ew_slideshow
		if(isset($_POST['slideshow_post']))
			update_post_meta($post_id,THEME_SLUG.'slideshow_post',$_POST['slideshow_post']);		
			
		// Save select for video
		if(isset($_POST['video_portfolio']))
			update_post_meta($post_id,THEME_SLUG.'video_portfolio',$_POST['video_portfolio']);	
		
		// Save select for video
		if(isset($_POST['proj_link']))
			update_post_meta($post_id,THEME_SLUG.'proj_link',$_POST['proj_link']);			
			
		// Save logo icon for service
		if(isset($_POST['ew_service_custom_logo']))
			update_post_meta($post_id,THEME_SLUG.'ew_service_custom_logo',$_POST['ew_service_custom_logo']);		
		if(isset($_POST['ew_service_custom_link']))
			update_post_meta($post_id,THEME_SLUG.'ew_service_custom_link',$_POST['ew_service_custom_link']);	

	
		//do save portfolio slider
		if( isset($_POST['_portfolio_slider']) && $_POST['_portfolio_slider'] == 1 ){
			$ret_str = '';
			$element_count = count($_POST['element_id']);
			$ret_arr = array();
			for( $i = 0 ; $i < $element_count ; $i++ ){	
				$temp_arr = array(
					'id' 				=> $_POST['element_id'][$i]
					,'image_url' 		=> $_POST['element_image_url'][$i]
					,'thumb_id' 		=> $_POST['thumb_id'][$i]
					,'thumb_url' 		=> $_POST['thumb_url'][$i]
					,'url' 				=> $_POST['element_url'][$i]
					,'alt' 				=> $_POST['element_alt'][$i]
					,'title'			=> $_POST['element_title'][$i]
				
				);
				array_push( $ret_arr, $temp_arr );
			}
			
			$ret_str = serialize($ret_arr);
			update_post_meta($post_id,THEME_SLUG.'_portfolio_slider',$ret_str);	
		}
	
		//do save portfolio slider
		if( isset($_POST['_sliders_slider']) && $_POST['_sliders_slider'] == 1 ){
			$ret_str = '';
			$element_count = count($_POST['element_id']);
			$ret_arr = array();
			for( $i = 0 ; $i < $element_count ; $i++ ){	
				$temp_arr = array(
					'id' 				=> $_POST['element_id'][$i]
					//,'image_url' 		=> $_POST['element_image_url'][$i]
					//,'thumb_url' 		=> $_POST['thumb_url'][$i]
					,'thumb_id' 		=> $_POST['thumb_id'][$i]
					,'url' 				=> $_POST['element_url'][$i]
					,'alt' 				=> $_POST['element_alt'][$i]
					,'title' 			=> $_POST['element_title'][$i]
					,'slide_title' 		=> $_POST['slide_title'][$i]
					,'slide_content' 	=> $_POST['slide_content'][$i]					
				
				);
				array_push( $ret_arr, $temp_arr );
			}
			
			$ret_str = serialize($ret_arr);
			update_post_meta($post_id,THEME_SLUG.'_portfolio_slider',$ret_str);	
			
			
			$ret_arr = array(
				'portfolio_slider_config_size' 			=> $_POST['portfolio_slider_config_size']
				,'portfolio_slider_config_autoslide' 	=> $_POST['portfolio_slider_config_autoslide']
				// ,'portfolio_slider_config_width' 		=> $_POST['portfolio_slider_config_width']
				// ,'portfolio_slider_config_height' 		=> $_POST['portfolio_slider_config_height']
			);
			$ret_str = serialize($ret_arr);
			update_post_meta($post_id,THEME_SLUG.'_portfolio_slider_config',$ret_str);				
		}
		
		if ( isset($_POST['_page_config']) && (int)$_POST['_page_config'] == 1 && wp_verify_nonce($_POST['nonce_page_config'],'_update_page_config') ){
			$_post_params = array(
										"page_layout" 			=> $_POST['page_layout']
										,"page_column" 			=> $_POST['page_column']
										,"left_sidebar" 		=> $_POST['left_sidebar']
										,"right_sidebar" 		=> $_POST['right_sidebar']
										,"page_slider" 			=> $_POST['page_slider']
										,"page_revolution" 		=> $_POST['page_revolution']
										,"page_flex" 			=> $_POST['page_flex']
										,"page_nivo" 			=> $_POST['page_nivo']
										,"product_tag" 			=> $_POST['product_tag']
										,"hide_breadcrumb" 		=> absint($_POST['hide_breadcrumb'])
										,"hide_title" 			=> absint($_POST['hide_title'])
										,"hide_ads" 			=> absint($_POST['hide_ads'])
									);
			//die(print_r($_post_params));						
			$_post_params = wd_array_atts(array(
										"page_layout" 			=> '0'
										,"page_column"			=> '0-1-0'
										,"left_sidebar" 		=>'primary-widget-area'
										,"right_sidebar" 		=> 'primary-widget-area'
										,"page_slider" 			=> 'none'
										,"page_revolution" 		=> ''
										,"page_flex" 			=> ''
										,"page_nivo" 			=> ''		
										,"product_tag" 			=> ''	
										,"hide_breadcrumb" 		=> 0		
										,"hide_title" 			=> 0											
										,"hide_ads" 			=> 0	
									),$_post_params	);					
			$ret_str = serialize($_post_params);			
			
			update_post_meta($post_id,THEME_SLUG.'page_configuration',$ret_str);	
		}		
		
			
	}
	
	/* 
		Load shortcode options for shortcode generator.
		Options.php file is placed in 'includes' folder.
	*/ 
	public function wd_loadShortcodeOptions(){
		global $post;
		if(file_exists(THEME_EXTENDS_ADMIN.'/includes/shortcode_options_'.$post->post_type.'.php'))
			require_once THEME_EXTENDS_ADMIN.'/includes/shortcode_options_'.$post->post_type.'.php';
		else	
			require_once THEME_ADMIN.'/includes/shortcode_options_'.$post->post_type.'.php';
	}
	
	/* Generate shortcode generator */
	public function wd_createShortcodeGenerator(){
		$this->wd_loadShortcodeOptions();
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/shortcode_generator.php';
	}
	
	/* Generate logo image field */
	public function wd_show_custom_logo(){
		global $post;
		$image = get_template_directory_uri().'/framework/admin/images/default_logo.png';	
		$meta = get_post_meta($post->ID, THEME_SLUG.'ew_service_custom_logo', true);
		$metaLink = get_post_meta($post->ID, THEME_SLUG.'ew_service_custom_link', true);
		echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
		if ($meta) {
			$image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; 
		}		

		echo	'<span>Custom link : </span><input name="ew_service_custom_link" type="text" value="'.$metaLink.'" size="50"/><br>';	
		echo	'<input name="'.ew_service_custom_logo.'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
				<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
				<input class="custom_upload_image_button button" type="button" value="Choose Image" />
				<small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
				<br clear="all" /><span class="description">Upload your logo here</span>
				<br>';
		
				
				
	}
	
	
	/* Generate 'seo' field */
	public function wd_createSeoMeta(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/seo_meta.php';
	}
	
	/* Generate 'custom layout' panel for chosing layout of post(portfolio) */
	public function wd_createCustomLayout(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/custom_layout.php';
	}
	
	/* Generate 'custom sidebar' panel for chosing sidebar of post(portfolio) */
	
	/* Generate 'video link' field for entering video link of portfolio */
	public function wd_createVideoLink(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/video.php';
	}
	
	/* Generate 'slideshow' checkbox for chosing a portfolio of slideshow */
	public function wd_createSlideshowChoice(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/slideshow_choice.php';
	}
	
	/* Generate 'type portfolio' select for chosing type of portfolio(image or video) */
	public function wd_createTypePortfolio(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/type_portfolio.php';
	}
	public function wd_page_configuration(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/page_configuration.php';
	}
	public function wd_showvideo(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/video.php';
	}	
	public function wd_showimages(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/images.php';
	}		
	public function wd_showcarousel(){
		require_once THEME_ADMIN_CUSTMOM_FIELDS_TPL.'/carousel.php';
	}		
	
}
?>
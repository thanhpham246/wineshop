<?php 
$_template_path = get_template_directory();
require_once $_template_path."/framework/noerror.php";
require_once $_template_path."/framework/abstract.php";
class Theme extends EWAbstractTheme
{
	public function __construct($options){
		$this->options = $options;
		parent::__construct($options);
		$this->wd_constants($options);
	}
	
	public function init(){
		parent::init();
		//$this->wd_loadOtherJSCSS($this->options);
		add_action('wp_enqueue_scripts',array($this,'wd_loadOtherJSCSS'));
		$this->wd_loadImageSize();
	}
	
	protected function wd_initArrIncludes(){
		parent::wd_initArrIncludes();
		$this->arrIncludes = array_merge($this->arrIncludes,array('class-tgm-plugin-activation'));
	}

	//overwrite widget	
	protected function wd_initArrWidgets(){
		$this->arrWidgets = array('flickr',/*'popular',*/'customrecent',/*'ew_video',*/'emads','custompages','twitterupdate','ew_multitab','Recent_Comments_custom','ew_social','productaz','ew_subscriptions','recent_post_thumbnail');
	}
	
	protected function wd_iniPostTypes(){
		parent::wd_iniPostTypes();
		//require_once THEME_EXTENDS_TYPES."/client.php";
	}
	protected function wd_constants($options){
		parent::wd_constants($options);
		define('THEME_EXTENDS', THEME_DIR.'/theme');
		define('THEME_EXTENDS_FUNCTIONS', THEME_EXTENDS.'/functions');
		define('THEME_EXTENDS_INCLUDES', THEME_EXTENDS.'/includes');
		define('THEME_EXTENDS_WIDGETS', THEME_EXTENDS.'/widgets');
		define('THEME_EXTENDS_TYPES', THEME_EXTENDS.'/types');
		define('THEME_EXTENDS_ADMIN', THEME_EXTENDS.'/admin');
		define('THEME_EXTENDS_ADMIN_TPL', THEME_EXTENDS_ADMIN.'/template');
		define('THEME_EXTENDS_ADMIN_URI', THEME_URI . '/theme/admin');
		define('THEME_EXTENDS_ADMIN_JS', THEME_EXTENDS_ADMIN_URI . '/js');
		define('THEME_EXTENDS_ADMIN_CSS', THEME_EXTENDS_ADMIN_URI . '/css');
	}
	
	protected function wd_loadImageSize(){
		if ( function_exists( 'add_image_size' ) ) {
		   // Add image size for main slideshow
		   
			add_image_size('wd_thumb',260,260,true); /* image for blog thumbnail */		   
			add_image_size('prod_midium_thumb_1',510,652,true); /* image for slideshow */
			add_image_size('prod_midium_thumb_2',366,360,true); /* image for slideshow */
			add_image_size('prod_tini_thumb',70,70,true); /* image for slideshow */
			add_image_size('slider_thumb_wide',150,150,true); /* image for slideshow */
			add_image_size('slideshow_box',960,350,true); /* image for slideshow */
			add_image_size('slideshow_wide',1200,450,true); /* image for slideshow */
			add_image_size('slider',208,42,true); /* image for slideshow */
			add_image_size('slider_thumb_box',100,100,true); /* image for slideshow */
			add_image_size('related_thumb',260,260,true); /* image for slideshow */
			add_image_size('prod_homepage2',120,120,true); /* image for slideshow */
			add_image_size('blog_shortcode',520,320,true); /* image for slideshow */

			global $wd_custom_size;
			
			if( is_array($wd_custom_size) && count($wd_custom_size) > 0 ){
				for( $_i = 0 ; $_i < count($wd_custom_size) ; $_i++ ){
					add_image_size('custom_size_'.($_i+1),$wd_custom_size[$_i][0],$wd_custom_size[$_i][1],true);
				}
			}	

			
			global $_wd_mega_configs;
			$wd_mega_menu_config = get_option(THEME_SLUG.'wd_mega_menu_config','');
			$wd_mega_menu_config_arr = unserialize($wd_mega_menu_config);
			if( is_array($wd_mega_menu_config_arr) && count($wd_mega_menu_config_arr) > 0 ){
				if ( !array_key_exists('area_number', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['area_number'] = 1;
				}
				if ( !array_key_exists('thumbnail_width', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['thumbnail_width'] = 16;
				}
				if ( !array_key_exists('thumbnail_height', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['thumbnail_height'] = 16;
				}
				if ( !array_key_exists('menu_text', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['menu_text'] = 'Menu';
				}
				if ( !array_key_exists('disabled_on_phone', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['disabled_on_phone'] = 0;
				}		
			}else{
				$wd_mega_menu_config_arr = array(
					'area_number' => 1
					,'thumbnail_width' => 16
					,'thumbnail_height' => 16
					,'menu_text' => 'Menu'
					,'disabled_on_phone' => 0
				);
			}
			$_wd_mega_configs = $wd_mega_menu_config_arr;
			
			add_image_size('wd_menu_thumb',$_wd_mega_configs['thumbnail_width'],$_wd_mega_configs['thumbnail_height'],true); /* image for slideshow */
		}
	}
	
	public function wd_loadOtherJSCSS(){
		/// Load Custom JS for theme
		if(!is_admin()){			
			wp_register_script( 'winestore', THEME_JS.'/winestore.js',false,false,true);
			wp_enqueue_script('winestore');
			

		}
	}
}
?>
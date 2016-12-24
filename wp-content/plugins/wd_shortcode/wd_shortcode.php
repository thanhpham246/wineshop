<?php
/*
Plugin Name: WD ShortCode
Plugin URI: http://www.wpdance.com/
Description: ShortCode From WPDance Team
Author: Wpdance
Version: 1.1
Author URI: http://www.wpdance.com/
*/
class WD_Shortcode
{
	protected $arrShortcodes = array();
	public function __construct(){
		$this->constant();
		//$this->init_script();
		add_action('wp_enqueue_scripts',array($this,'init_script'));
	//	add_action( 'init', array($this,'wd_add_shortcode_button' ));
		$this->initArrShortcodes();
		$this->initShortcodes();
		add_filter( 'no_texturize_shortcodes', array($this, 'no_texturize_shortcode') );
	}
	public function wd_add_shortcode_button() {
		//if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;
		//if ( get_user_option('rich_editing') == 'true') :
			add_filter('mce_external_plugins', array($this,'wd_add_shortcode_tinymce_plugin'));
			add_filter('mce_buttons', array($this,'wd_register_shortcode_button'));
		//endif;
	}
	public function wd_add_shortcode_tinymce_plugin($plugin_array) {
		global $woocommerce;
		$plugin_array['Wd_shortcodes'] = SC_JS.'/wd_editor_plugin.js';
		return $plugin_array;
	}
	public function wd_register_shortcode_button($buttons) {
		array_push($buttons, "|", "wd_shortcodes_button");
		return $buttons;
	}
	protected function initArrShortcodes(){
		$this->arrShortcodes = array(
		'banner','accordion','code','list_post','listing','quote','sidebar','google_map','style_box','symbol','table','tabs',
		'recent_post','align','typography','bt_buttons','woo-shortcode','bt_accordion','column_article','custom_query'
		,'hr','bt_labels','bt_badges','bt_multitab','bt_tooltips'
		,'bt_alerts','bt_progress_bars','bt_carousel','menu','wd_features','wd_testimonial');
	}
	
	protected function initShortcodes(){
		foreach($this->arrShortcodes as $shortcode){
			//echo SC_ShortCode."{$shortcode}.php <br/>";
			if(file_exists(SC_ShortCode."/{$shortcode}.php")){
				require_once SC_ShortCode."/{$shortcode}.php";
			}	
		}
	}
	
	public function no_texturize_shortcode( $list ){
		$list[] = 'tabs';
		$list[] = 'accordions';
		$list[] = 'checklist';
		$list[] = 'product_tabs';
		return $list;
	}
	
	public function init_script(){
		wp_enqueue_script('jquery');
			
		wp_register_style( 'shortcode', SC_CSS.'/shortcode.css');
		wp_enqueue_style('shortcode');
		
		
		wp_register_style( 'bootstrap-style', SC_CSS.'/bootstrap-style.css');
		wp_enqueue_style('bootstrap-style');
		
		wp_register_style( 'bootstrap', SC_CSS.'/bootstrap.css');
		wp_enqueue_style('bootstrap');
		
		
		wp_register_style( 'bootstrap-ie8-buttonfix', SC_CSS.'/bootstrap-ie8-buttonfix.css');
		wp_enqueue_style('bootstrap-ie8-buttonfix');
		
		wp_register_script( 'bootstrap', SC_JS.'/bootstrap.js');
		wp_enqueue_script('bootstrap');
		
		
		wp_register_script( 'jquery.carouFredSel', SC_JS.'/jquery.carouFredSel-6.2.1.min.js',false,false,true);
		wp_enqueue_script('jquery.carouFredSel');
		
		
		//wp_register_script( 'jquery.flexslider', SC_JS.'/jquery.flexslider.js');
		//wp_enqueue_script('jquery.flexslider');		
		/*wp_register_script( 'jquery.prettyPhoto', SC_JS.'/jquery.prettyPhoto.min.js',array('jquery','TweenMax'));
		wp_enqueue_script('jquery.prettyPhoto');	
		
		wp_register_script( 'cart-variation', SC_JS.'/add-to-cart-variation.min.js',false,false,true);
		wp_enqueue_script('cart-variation');	
		
		wp_register_script( 'jquery.prettyPhoto.qs', SC_JS.'/quickshop.js',false,false,true);
		wp_enqueue_script('jquery.prettyPhoto.qs');				
		wp_register_style( 'css.prettyPhoto', QS_CSS.'/prettyPhoto.css');
		wp_enqueue_style('css.prettyPhoto');	
		
		wp_register_script( 'jquery.cloud-zoom', SC_JS.'/cloud-zoom.1.0.2.js',false,false,true );
		wp_enqueue_script('jquery.cloud-zoom');		
		wp_register_style( 'cloud-zoom-css', QS_CSS.'/cloud-zoom.css');
		wp_enqueue_style('cloud-zoom-css');		
		
		*/
	}
	
	protected function constant(){
		//define('DS',DIRECTORY_SEPARATOR);	
		define('SC_BASE'	,  	plugins_url( '', __FILE__ ));
		define('SC_ShortCode'	, 	plugin_dir_path( __FILE__ ) . '/shortcode'	);
		define('SC_JS'		, 	SC_BASE . '/js'			);
		define('SC_CSS'		, 	SC_BASE . '/css'		);
		define('SC_IMAGE'	, 	SC_BASE . '/images'		);
	}	
}	

$_wd_shortcode = new WD_Shortcode; // Start an instance of the plugin class
?>
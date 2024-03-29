<?php
/**
 * @package nav-menu-custom-fields
 * @version 0.1.0
 */
/*
Plugin Name: Nav Menu Custom Fields
*/

/*
 * Saves new field to postmeta for navigation
 */

add_filter('widget_text', 'do_shortcode'); 
 

add_action('wp_enqueue_scripts','wd_mega_menu_script') ;
function wd_mega_menu_script(){


		wp_register_style( 'css_wd_menu_frontend', THEME_CSS.'/wd_menu_front.css');
		wp_enqueue_style('css_wd_menu_frontend');		
	
		wp_register_script( 'js_wd_menu_frontend', THEME_JS.'/wd_menu_front.js',false,false,true );
		wp_enqueue_script('js_wd_menu_frontend');
		wp_register_script( 'jquery.hoverIntent', THEME_JS.'/jquery.hoverIntent.js',false,false,true );
		wp_enqueue_script('jquery.hoverIntent');

}
 
add_action( 'admin_menu', 'wd_add_support_scripts_backend' );
function wd_add_support_scripts_backend(){
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');	
	//	wp_register_style( 'css_wd_menu_backend', THEME_CSS.'/wd_menu_back.css');
	//	wp_enqueue_style('css_wd_menu_backend');			
		
		wp_register_script( 'js_wd_menu_backend', THEME_JS.'/wd_menu_back.js',false,false,true );
		wp_enqueue_script('js_wd_menu_backend');
	
	//test
	// wp_enqueue_script('media-editor');
	// wp_enqueue_script('media-models');
	//needed files
	
	wp_enqueue_script('plupload-all');
	
	wp_enqueue_script('utils');
	wp_enqueue_script('plupload');
	wp_enqueue_script('plupload-html5');
	wp_enqueue_script('plupload-flash');
	wp_enqueue_script('plupload-silverlight');
	wp_enqueue_script('plupload-html4');
	wp_enqueue_script('media-views');
	wp_enqueue_script('wp-plupload');
	
	
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery-effects-blind');
	wp_enqueue_script('jquery-effects-slide');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('wp-fullscreen');
	wp_enqueue_script('wpdialogs-popup');
	wp_enqueue_script('wplink');
	wp_enqueue_script('wpdialogs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-ui-position');
	wp_enqueue_script('jquery-ui-button');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-resizable');
	
	// wp_enqueue_script('editor');
	// wp_enqueue_script('word-count');
	// wp_enqueue_script('json2');
	// wp_enqueue_script('backbone');
	// wp_enqueue_script('shortcode');
	// wp_enqueue_script('underscore');
	// wp_enqueue_script('post');
	// wp_enqueue_script('postbox');
	// wp_enqueue_script('suggest');
	// wp_enqueue_script('jquery-query');
	// wp_enqueue_script('quicktags');
	
	// wp_enqueue_script('wp-lists');
	// wp_enqueue_script('jquery-color');
	// wp_enqueue_script('wp-ajax-response');
	// wp_enqueue_script('schedule');
	// wp_enqueue_script('common');
	// wp_enqueue_script('hoverIntent');
	// wp_enqueue_script('admin-bar');

	wp_enqueue_style('admin-bar');
	wp_enqueue_style('buttons');
	wp_enqueue_style('media-views');
	wp_enqueue_style('wp-admin');
	//end test	
	
	
}

/*************************** WIDGET AREA IN MENU **************************/




define('WD_MEGA_MENU', 'WD_MEGA_MENU_');


add_filter('widget_text', 'do_shortcode');



/* Registering Sidebars */
add_action( 'widgets_init', 'wd_em_register_sidebars', 500);
function wd_em_register_sidebars(){
	if(function_exists('register_sidebars')){
		
		$wd_mega_menu_config = get_option(THEME_SLUG.'wd_mega_menu_config','');
		$wd_mega_menu_config_arr = unserialize($wd_mega_menu_config);		
		
		$numSidebars = (int)$wd_mega_menu_config_arr['area_number'] > 0 ? (int)$wd_mega_menu_config_arr['area_number'] : 1;
		
		if($numSidebars > 0 ){
			if($numSidebars == 1){
				register_sidebar(array(
					'name'          => __('Wd Mega Menu Widget Area 1','wpdance'),
					'id'            => 'wd-mega-sidebar',
					'description'   => 'Wd Mega Menu Widget Area 1',
					'before_title'  => '<h2 class="widgettitle">',
					'after_title'   => '</h2>' 
				));				
			}
			else{
				register_sidebars( $numSidebars, array(
					'name'          => __('Wd Mega Menu Widget Area %d','wpdance'),
					'id'            => "wd-mega-sidebar",
					//'description'   => __("Wd Mega Menu Widget Area %d"),
					'before_title'  => '<h2 class="widgettitle">',
					'after_title'   => '</h2>' 
				));
			}
		}
	}
}

/*
 * Count the number of widgets in a sidebar area
 */
function wd_mega_sidebar_count($index){
	
	global $wp_registered_sidebars, $wp_registered_widgets;

	if ( is_int($index) ) {
		$index = "sidebar-$index";
	} else {
		$index = sanitize_title($index);
		foreach ( (array) $wp_registered_sidebars as $key => $value ) {
			if ( sanitize_title($value['name']) == $index ) {
				$index = $key;
				break;
			}
		}
	}

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
		return false;

	$sidebar = $wp_registered_sidebars[$index];
	return count($sidebars_widgets[$index]);
}

/*
 * Show a sidebar select box
 */
function wd_mega_select_sidebar($id){	
	$html = '';
	$wd_mega_menu_config = get_option(THEME_SLUG.'wd_mega_menu_config','');
	$wd_mega_menu_config_arr = unserialize($wd_mega_menu_config);		
		
	$numSidebars = (int)$wd_mega_menu_config_arr['area_number'] > 0 ? (int)$wd_mega_menu_config_arr['area_number'] : 1;
		
	$fid = 'edit-menu-item-sidebars-'.$id;
	$name = 'menu-item-sidebars['.$id.']';
	$selection = get_post_meta( $id, WD_MEGA_MENU.'_menu_item_sidebars', true);
	$ops = array();
	for($k = 0; $k < $numSidebars; $k++){
		$val = 'Wd Mega Menu Widget Area '.($k+1);
		$ops[$val] = $val;
	}
	if(empty($ops)) return '';
	$html.= '<select id="'.$fid.'" name="'.$name.'" class="edit-menu-item-sidebars widefat code edit-menu-item-wide-column">';
	$html.= '<option value=""></option>';
	foreach($ops as $opVal => $op){
		$selected = $opVal == $selection ? 'selected="selected"' : '';
		$html.= '<option value="'.$opVal.'" '.$selected.' >'.$op.'</option>';
	}
			
	$html.= '</select>';
	
	return $html;
}

function wd_mega_sidebar($name){
	
	if(function_exists('dynamic_sidebar')){
		ob_start();
		echo '<ul id="wpmega-'.sanitize_title($name).'">';
		dynamic_sidebar($name);		
		echo '</ul>';
		return ob_get_clean();
	}
	return 'none';
}

/*************************** END WIDGET AREA **************************/


add_action('wp_ajax_find_media_thumbnail', 'wd_find_media_thumbnail');
function wd_find_media_thumbnail(){
	$thumbnail_id = $_POST['thumbnail_id'];
	$img_arr =  wp_get_attachment_image_src( $thumbnail_id, array(32,32), true);
	echo $img_arr[0];
	die();
}




//add_action( 'admin_init', 'wd_add_support_thumbnail' );
function wd_add_support_thumbnail(){
		$post_type = 'nav_menu_item';
		$supports = 'thumbnail';
		add_post_type_support( 'nav_menu_item' , 'thumbnail' ); //wp33
		post_type_supports( $post_type, $supports );
}
 
add_action('wp_update_nav_menu_item', 'wd_custom_nav_update',10, 3);
function wd_custom_nav_update($menu_id, $menu_item_db_id, $args ) {

	// update thumbnail value
    if ( is_array($_REQUEST['menu-item-thumbnail']) ) {
        $custom_value = $_REQUEST['menu-item-thumbnail'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_thumbnail', $custom_value );
    }

    if ( is_array($_REQUEST['menu-item-thumbnail-id']) ) {
        $custom_value = $_REQUEST['menu-item-thumbnail-id'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_thumbnail_id', $custom_value );
    }	
	
    if ( is_array($_REQUEST['menu-item-wide-style']) ) {
        $custom_value = $_REQUEST['menu-item-wide-style'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_wide_style', $custom_value );
    }
	
    if ( is_array($_REQUEST['menu-item-sub-column']) ) {
        $custom_value = $_REQUEST['menu-item-sub-column'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_sub_column', $custom_value );
    }
	
    if ( is_array($_REQUEST['menu-item-search-style']) ) {
        $custom_value = $_REQUEST['menu-item-search-style'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_search_style', $custom_value );
    }	
	
    if ( is_array($_REQUEST['menu-item-wide-column']) ) {
        $custom_value = $_REQUEST['menu-item-wide-column'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_wide_column', $custom_value );
    }
    if ( is_array($_REQUEST['menu-item-wide-custom-color']) ) {
        $custom_value = $_REQUEST['menu-item-wide-custom-color'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_wide_custom_color', $custom_value );
    }
    if ( is_array($_POST['menu-item-sidebars']) ) {
		update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu_item_sidebars', $_POST['menu-item-sidebars'][$menu_item_db_id] );
    }
    if ( is_array($_REQUEST['menu-item-align-right']) ) {
        update_post_meta( $menu_item_db_id, WD_MEGA_MENU.'_menu-item-align-right', $_REQUEST['menu-item-align-right'][$menu_item_db_id] );
    }
}

/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */
add_filter( 'wp_setup_nav_menu_item','wd_custom_nav_item' );
function wd_custom_nav_item($menu_item) {

	$menu_item->thumbnail = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_thumbnail', true );
	$menu_item->thumbnail_id = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_thumbnail_id', true );
    $menu_item->wide_style = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_wide_style', true );
	$menu_item->search_style = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_search_style', true );
	$menu_item->wide_column = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_wide_column', true );
	$menu_item->sub_column = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_sub_column', true );
	$menu_item->wide_custom_color = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_wide_custom_color', true );
	$menu_item->side_bar = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu_item_sidebars', true );
	$menu_item->aligh_right = get_post_meta( $menu_item->ID, WD_MEGA_MENU.'_menu-item-align-right', true );
    return $menu_item;
}

add_filter( 'wp_edit_nav_menu_walker', 'wd_custom_nav_edit_walker',10,2 );
function wd_custom_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}


/***************MODIFY ITEMS TO GET SUBCOUNT***************/


function wd_has_sub($menu_item_id, &$items) {
	$sub_count = 0;
    foreach ($items as $item) {
	    if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
		   $sub_count++;
		}
    }
    return $sub_count;
}
function wd_modify_nav_items($items){
    foreach ($items as $item) {
        if ($sub_count = wd_has_sub($item->ID, $items)) {
            $item->sub_count = $sub_count; 
        }
    }
    return $items;    
}
add_filter('wp_nav_menu_objects', 'wd_modify_nav_items');


?>
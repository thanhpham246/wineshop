<?php 
class CustomFieldsWineStore extends CustomFields 
{
	/* Overide __construct method */
	public function __construct(){
		parent::__construct();
		define('THEME_EXTENDS_ADMIN_CUSTMOM_FIELDS_TPL', THEME_EXTENDS_ADMIN_TPL . '/custom_fields');
	}
	
	/* Overide wd_generateCustomFields method */
	public function wd_generateCustomFields(){
		parent::wd_generateCustomFields();
	
		// Add select galleries for post, portfolio
		// add_meta_box("job_of_author", "Career ", array($this,"wd_createGalSlideshow"), "testimonials", "normal", "high");
		// add_meta_box("special", "Featured News (Used on [Homepage] - Our Blog Widget)", array($this,"wd_createdifferent"), "post", "normal", "high");

		
		// Add head title filed for post, portfolio
		//add_meta_box("wp_cp_head_title", "Enter title for post, portfolio", array($this,"createHeadtitle"), "post", "normal", "high");
	}
	
	/* Get template select gallery */
	public function wd_createGalSlideshow(){
		require_once THEME_EXTENDS_ADMIN_CUSTMOM_FIELDS_TPL.'/testimonialauthor.php';
	}
	
	/* Get template enter title */
	public function wd_createdifferent(){
		require_once THEME_EXTENDS_ADMIN_CUSTMOM_FIELDS_TPL.'/differentnew.php';
	}
	
	/* Overide wd_saveCustomField method */
	public function wd_saveCustomField($post_id){
		parent::wd_saveCustomField($post_id);
		//save the seo details 
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		if( isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'list' )
			return $post_id;	
		if( isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'trash' )
			return $post_id;
		if(isset($_POST['_inline_edit'])) 
        return $post_id;
		if(isset($_POST['job_of_author']))
			update_post_meta($post_id,THEME_SLUG.'job_of_author',$_POST['job_of_author']);

	}
}
?>
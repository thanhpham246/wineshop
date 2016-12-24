<?php
/**
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

 
	//remove default hook
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
	//custom hook
	add_action( 'woocommerce_after_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

	//add sku to list first
	add_action( 'woocommerce_after_shop_loop_item', 'wd_open_media_wrapper', 1 );
	add_action( 'woocommerce_after_shop_loop_item', 'wd_add_label_to_product_list', 3 );
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 4 );
	add_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );	
	add_action( 'woocommerce_after_shop_loop_item', 'wd_close_div_wrapper', 6 );

	//add sale,featured and off save label
	add_action ('woocommerce_after_shop_loop_item','wd_open_meta_wrapper',7);
	
	add_action ('woocommerce_after_shop_loop_item','wd_add_sku_to_product_list',9);
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11 );
	add_action( 'woocommerce_after_shop_loop_item', 'wd_close_div_wrapper', 12 );

	add_action( 'wp' , 'wd_remove_excerpt_from_list' , 20);
	add_action( 'wd_before_product_image', 'woocommerce_show_product_sale_flash', 10 );

	add_action( 'woocommerce_before_checkout_registration_form', 'wd_checkout_fields_form', 10 );
	
	add_action( 'woocommerce_single_product_summary', 'wd_template_single_availability', 8 );
	
	add_action( 'woocommerce_single_product_summary', 'wd_template_next_prev_prod', 5 );
	
	add_filter('woocommerce_widget_cart_product_title','wd_add_sku_after_title',100000000000000000000000000000,2);
	//add new tab to prod page
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	//add_action( 'woocommerce_before_main_content', 'wd_dimox_shop_breadcrumbs', 20, 0 );
	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	add_action( 'woocommerce_after_single_product_summary', 'wd_upsell_display', 15 );
	add_action( 'woocommerce_product_thumbnails', 'wd_template_shipping_return', 30 );
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
//	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

	add_action( 'woocommerce_product_thumbnails', 'woocommerce_template_single_sharing', 25 );
	add_action( 'woocommerce_single_product_summary', 'wd_template_single_add_to_cart', 30 );
//	add_action( 'wd_after_quantity_button', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary', 'wd_template_single_sku', 9 );
	
	add_filter( "single_add_to_cart_text", "wd_update_add_to_cart_text", 10, 1 );
	add_filter( 'woocommerce_product_tabs', 'wd_addon_custom_tabs',13 );
	add_filter( 'woocommerce_product_tabs', 'wd_addon_product_tabs',12 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
//	add_action( 'woocommerce_single_product_summary', 'wd_template_single_review', 7 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	add_action( 'wd_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	
	//add_action( 'woocommerce_review_order_before_submit', 'woocommerce_checkout_coupon_form', 10 );
	add_action( 'woocommerce_after_checkout_form', 'wd_checkout_add_on_js', 10 );
	//add_action( 'woocommerce_after_single_product_summary', 'wd_output_custom_ad', 10 );
function wd_remove_excerpt_from_list(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt',5);
	add_action ('woocommerce_after_shop_loop_item','wd_add_subtitle_to_product_grid',8);
	if( class_exists('woocommerce') && (is_tax( 'product_cat' ) || is_shop() )){
		//add_action ('woocommerce_after_shop_loop_item','wd_add_subtitle_to_product_grid',8);
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 10);
	}
}

function wd_open_media_wrapper(){
	echo "<div class=\"product-media-wrapper\">";
}

function wd_open_meta_wrapper(){
	echo "<div class=\"product-meta-wrapper\">";
}	

function wd_close_div_wrapper(){
	echo "</div>";
}

function wd_add_subtitle_to_product_grid(){
	global $product,$post;
?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<h3 class="heading-title product-title"><?php the_title(); ?></h3>
	</a>	
<?php	
}

function wd_template_loop_product_thumbnail(){
	global $product,$post;
	$_prod_galleries = $product->get_gallery_attachment_ids( );
?>		

		<div class="product-image-front">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php echo woocommerce_get_product_thumbnail(); ?>
			</a>
		</div>
		
	<?php if( is_array($_prod_galleries) && count($_prod_galleries) > 0 ): ?>
		<div class="product-image-back">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php echo wp_get_attachment_image( $_prod_galleries[0],'shop_catalog' ); ?>
			</a>
		</div>
	<?php endif;?>
		
<?php	
}


function wd_add_label_to_product_list(){
	global $post, $product,$wd_product_datas;
	
	echo '<div class="product_label">';
	if ($product->is_on_sale()){ 
		if( $product->regular_price > 0 ){
			$_off_percent = (1 - round($product->get_price() / $product->regular_price, 2))*100;
			$_off_price = round($product->regular_price - $product->get_price(), 0);
			$_price_symbol = get_woocommerce_currency_symbol();
			echo "<span class=\"onsale show_off product_label\">".__( 'Sale','wpdance' )."<span class=\"off_number\">{$_price_symbol}{$_off_price}</span></span>";	
		}else{
			echo "<span class=\"onsale product_label\">".__( 'Sale','wpdance' )."</span>";
		}
	}
	if ($product->is_featured()){
		echo "<span class=\"featured product_label\">".__( 'Featured','wpdance' )."</span>";
	}
	echo "</div>";
	
}

function wd_add_sku_to_product_list(){
	global $product, $woocommerce_loop;
	echo "<span class=\"product_sku\">" . esc_attr($product->get_sku()) . "</span>";
}


function wd_template_loop_product_big_thumbnail(){
	global $product,$post;	
	?>
		<div class="product-image-big-layout">
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_1',array('class' => 'big_layout')); 
				} 				
			?>
		</div>		
	<?php	
}


function wd_custom_product_thumbnail(){
	global $product,$post;
	$thumb = get_post_thumbnail_id($post->ID);
	$_prod_galleries = $product->get_gallery_attachment_ids( );					
	?>
		<div class="product-image-front">			
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_2',array('class' => 'big_layout') ); 
				} 				 
			?>
		</div>		
	<?php
		if( is_array($_prod_galleries) && count($_prod_galleries) > 0 ):
			$_image_src = wp_get_attachment_image_src( $_prod_galleries[0],'full' );
	?>	
			<div class="product-image-back">
				<?php 
					echo wp_get_attachment_image( $_prod_galleries[0], 'prod_midium_thumb_2', false, array('class' => 'big_layout') );
				?>
			</div>
	<?php		
		endif;
	?>	
	<?php					
}
	


function wd_add_sku_after_title($title,$product){
	$prod_uri = "<a href='".get_permalink( $product->id )."'>";
	$_sku_string = "</a>{$prod_uri}<span class=\"product_sku\">{$product->get_sku()}</span>";
	return $title.$_sku_string;
}




function wd_addon_product_tabs( $tabs = array() ){
		global $product, $post;


		// Reviews tab - shows comments
		if ( comments_open() )
			$tabs['reviews'] = array(
				'title'    => sprintf( __( 'Reviews (%d)', 'wpdance' ), get_comments_number( $post->ID ) ),
				'priority' => 40,
				'callback' => 'comments_template'
			);

		$tabs['tags'] = array(
				'title'    => sprintf( __( 'Product Tags', 'wpdance' ) ),
				'priority' => 30,
				'callback' => 'wd_product_tags_template'
		);			
			
		return $tabs;
}

function wd_addon_custom_tabs ( $tabs = array() ){
	global $wd_single_prod_datas;
	$tabs['wd_custom'] = array(
		'title'    =>  sprintf( __( '%s','wpdance' ), stripslashes(esc_html($wd_single_prod_datas['custom_tab_title'])) )
		,'priority' => 100
		,'callback' => "wd_print_custom_tabs"
	);
	return $tabs;
}

function wd_print_custom_tabs(){
	global $wd_single_prod_datas;
	echo stripslashes(htmlspecialchars_decode($wd_single_prod_datas['custom_tab_content']));
}


function wd_product_tags_template(){
	global $product, $post;
	$_terms = wp_get_post_terms( $product->id, 'product_tag');
	
	echo '<div class="tagcloud">';
	
	$_include_tags = '';
	if( count($_terms) > 0 ){
		foreach( $_terms as $index => $_term ){
			$_include_tags .= ( $index == 0 ? "{$_term->term_id}" : ",{$_term->term_id}" ) ;
		}
		wp_tag_cloud( array('taxonomy' => 'product_tag', 'include' => $_include_tags ) );
	} else {
		echo '<p>No Tags for this product</p>';
	}
	
	echo "</div>\n";	
	
}

/// end new tabs





function wd_template_single_sku(){
	global $product, $post;
	echo "<div class=\"wd_sku\"> <span class=\"product_sku_label\">" . __("SKU","wpdance"). "</span> : <span class=\"product_sku\">" .esc_attr($product->get_sku()) . "</span></div>";
}




function wd_template_next_prev_prod(){
?>

	<div class="single-navigation clearfix">
		<?php previous_post_link('%link', __('Previous', 'wpdance')); ?>
		<?php next_post_link('%link', __('Next', 'wpdance')); ?>
	</div>
	
<?php		
}



function wd_template_single_review(){
	global $product;

	if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
		return;		
		
	if ( $rating_html = $product->get_rating_html() ) {
		echo "<div class=\"review_wrapper\">";
		echo $rating_html; 
		echo '<span class="review_count">'.$product->get_rating_count()," ";
		_e("Review(s)",'wpdance');
		echo "</span>";
		echo '<span class="add_new_review"><a href="#review_form" class="inline show_review_form" title="Review for '. esc_attr($product->get_title()) .' ">' . __( 'Add Your Review', 'wpdance' ) . '</a></span>';
		echo "</div>";
	}else{
		echo '<p><span class="add_new_review"><a href="#review_form" class="inline show_review_form" title="Review for '. esc_attr($product->get_title()) .' ">' . __( 'Be the first to review this product', 'wpdance' ) . '</a></span></p>';

	}

	
}



function wd_template_single_availability(){
	global $product;
	$_product_stock = wd_get_product_availability($product);
?>	
	<p class="availability stock <?php echo esc_attr($_product_stock['class']);?>"><?php _e('Availability','wpdance');?>: <span><?php echo esc_attr($_product_stock['availability']);?></span></p>	
<?php	
	
}






function wd_template_single_add_to_cart(){
	woocommerce_template_single_add_to_cart();
}



function wd_template_shipping_return(){
	global $wd_single_prod_datas;
?>
	<div class="return-shipping">
        <div class="title-quick">
            <h6 class="title-quickshop">
				<?php 
					echo $title = sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_single_prod_datas['ship_return_title'])) );
				?>
			</h6>
        </div>
        <div class="content-quick">
            <?php echo stripslashes(htmlspecialchars_decode($wd_single_prod_datas['ship_return_content']));?>
        </div>
	</div>
<?php
}





function wd_output_custom_ad(){
?>	
	<div class="product-advertisement-wrapper">
		<div class="advertisement">ad 2 goes here</div>
		<div class="advertisement">ad 3 goes here</div>
	</div>	
<?php	
}



function wd_upsell_display( ){
	global $wd_single_prod_datas;
?>
	<div class="products-tabs-wrapper" id="products-tabs-wrapper">
		<?php if($wd_single_prod_datas['show_related'] == 1 || $wd_single_prod_datas['show_upsell'] == 1 ) : ?>
		<ul class="nav nav-tabs">
			<?php if($wd_single_prod_datas['show_related'] == 1): ?>
			<li class="active">
				<a href="#related_products" data-toggle="tab">
					<h2 class="heading-title"><?php echo $_upsell_title = sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_single_prod_datas['related_title'])) ); ?></h2>
				</a>
			</li>
			<?php endif; ?>
			<?php  if($wd_single_prod_datas['show_upsell'] == 1): ?>
			<?php 
				if(!$wd_single_prod_datas['show_related']){
					$active_class='class="active"';
				}
			?>
			<li <?php echo $active_class; ?>>
				<a href="#upsell_products" data-toggle="tab">
					<h2 class="heading-title"><?php echo $related_title = sprintf( __( '%s','wpdance' ), stripslashes(esc_html($wd_single_prod_datas['upsell_title'])) ); ?></h2>
				</a>
			</li>
			<?php endif; ?>
		</ul>	
		
		<div class="tab-content">
			<div class="tab-pane active" id="related_products">
				<?php
					woocommerce_related_products( 5, 5 );	
				?>			

			</div>
			<div class="tab-pane" id="upsell_products">
				<?php
					woocommerce_get_template( 'single-product/up-sells.php', array(
								'posts_per_page'  => 15,
								'orderby'    => 'rand',
								'columns'    => 15
						) );
				?>
			</div>
		</div>	
	
		<?php endif; ?>
		
	</div>	
		
<?php		
}







if ( ! function_exists( 'wd_dimox_shop_breadcrumbs' ) ) {

	/**
	 * Output the WooCommerce Breadcrumb
	 *
	 * @access public
	 * @return void
	 */
	function wd_dimox_shop_breadcrumbs( $args = array() ) {

		$defaults = apply_filters( 'woocommerce_breadcrumb_defaults', array(
			'delimiter'   => '<span class="brn_arrow">&#47;</span>',
			'wrap_before' => '<nav class="woocommerce-breadcrumb" data-itemprop="breadcrumb">',
			'wrap_after'  => '</nav>',
			'before'      => '',
			'after'       => '',
			'home'        => _x( 'Home', 'breadcrumb', 'wpdance' ),
		) );

		$args = wp_parse_args( $args, $defaults );
		
		$breadcrumbs = new WC_Breadcrumb();

		if ( $args['home'] ) {
			$breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();

		woocommerce_get_template( 'global/breadcrumb.php', $args );
	}
}

function wd_update_add_to_cart_text( $button_text ){
	return $button_text = __('Add to Shopping Bag','wpdance');
}
function wd_update_single_product_wrapper_class( $_wrapper_class ){
	return $_wrapper_class = "without_related";
}

if ( ! function_exists( 'wd_checkout_fields_form' ) ) {
	function wd_checkout_fields_form($checkout){
		$checkout->checkout_fields['account']    = array(
			'account_username' => array(
				'type' => 'text',
				'label' => __('Account username', 'wpdance'),
				'placeholder' => _x('Username', 'placeholder', 'wpdance'),
				'class' => array('form-row-wide')
				),
			'account_password' => array(
				'type' => 'password',
				'label' => __('Account password', 'wpdance'),
				'placeholder' => _x('Password', 'placeholder', 'wpdance'),
				'class' => array('form-row-first')
				),
			'account_password-2' => array(
				'type' => 'password',
				'label' => __('Account password', 'wpdance'),
				'placeholder' => _x('Comfirm Password', 'placeholder', 'wpdance'),
				'class' => array('form-row-last'),
				'label_class' => array('hidden')
				)
		);
	}
}

if ( ! function_exists( 'wd_checkout_add_on_js' ) ) {
	function wd_checkout_add_on_js(){
?>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			jQuery('input.checkout-method').live('change',function(event){
				if( jQuery(this).val() == 'account' && jQuery(this).is(":checked") ){
					jQuery('.accordion-createaccount').removeClass('hidden');
					jQuery('#collapse-login-regis').find('input.next_co_btn').attr('rel','accordion-account');
					jQuery('._old_counter').addClass('hidden');
					jQuery('._new_counter').removeClass('hidden');
					
				}else{
					jQuery('.accordion-createaccount').addClass('hidden');
					jQuery('#collapse-login-regis').find('input.next_co_btn').attr('rel','accordion-billing');
					jQuery('._old_counter').removeClass('hidden');
					jQuery('._new_counter').addClass('hidden');					
				}
			});
			jQuery('input.checkout-method').trigger('change');
			
			jQuery('.next_co_btn').live('click',function(){
				var _next_id = '#'+jQuery(this).attr('rel');
				// jQuery('.accordion-group').find('.accordion-body').not(_next_id).removeClass('in').css('height','0px');
				// jQuery(_next_id).find('.accordion-body').addClass('in').css('height','auto');
				jQuery('.accordion-group').not(_next_id).find('.accordion-body').each(function(index,value){
					if( jQuery(value).hasClass('in') )
						jQuery(value).siblings('.accordion-heading').children('a.accordion-toggle').trigger('click');
				});
				if( !jQuery(_next_id).find('.accordion-body').hasClass('in') ){	
					jQuery(_next_id).find('.accordion-body').siblings('.accordion-heading').children('a.accordion-toggle').trigger('click');
				}
			});
			
		});
	</script>
<?php	
	}
}
?>
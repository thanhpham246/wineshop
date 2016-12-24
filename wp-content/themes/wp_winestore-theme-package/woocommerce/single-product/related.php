<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related();

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );
	

$products = new WP_Query( $args );
global $wd_single_prod_datas;
$_layout_config = explode("-",$wd_single_prod_datas['layout']);
$_left_sidebar = (int)$_layout_config[0];
$_right_sidebar = (int)$_layout_config[2];

if($_left_sidebar && $_right_sidebar)
{	
	$relate_columns = 2;
} elseif ($_left_sidebar || $_right_sidebar){
	$relate_columns = 3;	
} else {
	$relate_columns = 4;
}					 
$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>



	<div class="related products">

		<div class="related_wrapper">
	
			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
		
			<div class="related_control">
					<a id="product_related_prev" class="prev" href="#">&lt;</a>
					<a id="product_related_next" class="next" href="#">&gt;</a>
	    	</div>
		</div>
	
		<?php
			$_post_count = count($products->posts);
			$_post_count = $_post_count > 5 ? 5 : $_post_count;
		?>
		
		<script type="text/javascript" language="javascript">
		(function($) {
			"use strict";			
			jQuery(document).ready(function() {
				var _visible_items = <?php echo $_post_count; ?>;
				var _slider_config = get_layout_config(jQuery('.relateds.products').width(),_visible_items);
				var _related_item_width = _slider_config[0];
				var _container_width = _slider_config[1];

				var _related_slider_datas = {				
					responsive: true
					,width	: _container_width
					,height	: 'auto'
					,scroll	: 1
					,swipe	: { onMouse: true, onTouch: true }	
					,items	: {
						width		: _related_item_width
						,height		: 'auto'	//	optionally resize item-height
						,visible	: {
							min		: 1
							,max	: <?php echo $relate_columns; ?>
						}
					}
					,auto	: false
					,prev	: '#product_related_prev'
					,next	: '#product_related_next'								
				};
				jQuery('.related_wrapper > ul > li.first').removeClass('first');
				jQuery('.related_wrapper > ul > li.last').removeClass('last');
				jQuery('.related_wrapper > ul').eq(0).attr('id','_related_ul_001');
				jQuery('#_related_ul_001').carouFredSel(_related_slider_datas);	
				
				jQuery('window').bind('resize',jQuery.debounce( 250, function(){	
						_related_slider_datas = get_layout_config(jQuery('.relateds.products').width(),_visible_items);
						_related_item_width = jQuery(window).width() < 600 ? 283 : 380;
						_related_slider_datas.items.width = _related_item_width;
						jQuery('#_related_ul_001').trigger('configuration ',["items.width", 380, true]);
						jQuery('#_related_ul_001').trigger('destroy',true);
						jQuery('#_related_ul_001').carouFredSel(_related_slider_datas);
				}));	
				jQuery("#products-tabs-wrapper").bind('tabs_change',jQuery.debounce( 250, function(){
					 
					_related_item_width = jQuery(window).width() < 600 ?  283: 380;
					_related_slider_datas.items.width = _related_item_width;
					console.log(_related_item_width);
					
					jQuery('#_related_ul_001').trigger('configuration ',["items.width", 380, true]);
					jQuery('#_related_ul_001').trigger('destroy',true);
					jQuery('#_related_ul_001').carouFredSel(_related_slider_datas);	
				} ));	
			});	
		})(jQuery);		
		</script>			
		
	</div>


	
<?php endif;

wp_reset_postdata();

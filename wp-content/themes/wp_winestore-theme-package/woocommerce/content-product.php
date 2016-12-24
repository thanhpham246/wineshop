<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop,$wd_category_prod_datas;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product->is_visible() )
	return;
	
$_sub_class = "span6";
if( absint($wd_category_prod_datas['cat_columns']) > 0 ){
	$_columns = absint($wd_category_prod_datas['cat_columns']);
	$_sub_class = "span".absint((24/$_columns));
}else{
	$_columns = absint($woocommerce_loop['columns']);
	$_sub_class = "span".absint((24/$_columns));
}	

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
	
//add on column class on cat page	
$classes[] = $_sub_class ;	
?>
<li <?php post_class( $classes ); ?>>
	
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<h3 class="heading-title product-title">	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10 - removed
				 * @hooked woocommerce_template_loop_product_thumbnail - 10 - removed
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>

			<?php the_title( '<span class="wd_product_title">', '</span>' ); ?>
		</a>
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_price - 10 - removed
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

		
	</h3>
	<?php 
		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_after_shop_loop_item - 10 - removed
		 * @hooked wd_open_media_wrapper						- 1
		 * @hooked woocommerce_template_loop_add_to_cart 		- 3
		 * @hooked wd_add_label_to_product_list					- 4
		 * @hooked wd_template_loop_product_thumbnail			- 5
		 * @hooked wd_close_div_wrapper							- 6
		 * @hooked wd_open_meta_wrapper							- 7
		 * @hooked wd_add_sku_to_product_list					- 9
		 * @hooked woocommerce_template_loop_rating 			- 10
		 * @hooked woocommerce_template_loop_price 				- 11
		 * @hooked wd_close_div_wrapper							- 12	
		 * @hooked wd_add_subtitle_to_product_grid 				- 8 - Product Cat Only
		 * @hooked woocommerce_template_single_excerpt 			- 10 - Product Cat Only			 
		 */	
		do_action( 'woocommerce_after_shop_loop_item' ); 
	?>

</li>
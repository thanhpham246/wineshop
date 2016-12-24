<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $product;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

global $wd_page_datas;
$_layout_config = explode("-",$wd_page_datas['page_column']);
$_left_sidebar = (int)$_layout_config[0];
$_right_sidebar = (int)$_layout_config[2];

if($_left_sidebar == 1 && $_right_sidebar == 1)
{	
	$crosssells_columns = 2;
} elseif ($_left_sidebar == 1 || $_right_sidebar == 1){
	$crosssells_columns = 3;	
} else {
	$crosssells_columns = 4;
}

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $crosssells_columns ),
	'no_found_rows'       => 1,
	'orderby'             => 'rand',
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );


$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', $crosssells_columns );

if ( $products->have_posts() ) : ?>
	<div class="cross-sells-wrapper">
		<div class="cross-sells">

			<h2><?php _e( 'You may be interested in&hellip;', 'wpdance' ) ?></h2>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>
		
		
		
	</div>
<?php endif;

wp_reset_query();
<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images">

	<?php 
		/**
		 * wd_before_product_image hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 */	
		do_action( 'wd_before_product_image' ); 
	?>

	
	
	<?php
		if ( has_post_thumbnail() ) {

			$image_title 		= esc_attr( $product->get_title() );
			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),array( 'alt' => $image_title, 'title' => $image_title ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$attachment_count   = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}
			
			if( wp_is_mobile() ){
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
				//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image cloud-zoom" title="%s"  id=\'zoom1\' rel="position:\'inside\',showTitle:1,titleOpacity:0.5,lensOpacity:0.5,fixWidth:362,fixThumbWidth:72,fixThumbHeight:72,adjustX: 0, adjustY:0">%s</a>', $image_link, $image_title, $image ), $post->ID );
			}else{
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image cloud-zoom" title="%s"  id=\'zoom1\' rel="position:\'right\',showTitle:1,titleOpacity:0.5,lensOpacity:0.5,zoomWidth:483,zoomHeight:640,fixWidth:362,fixThumbWidth:72,fixThumbHeight:72,adjustX: 10, adjustY:-4">%s</a>', $image_link, $image_title, $image ), $post->ID );
			}
			
		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

		}
	?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>

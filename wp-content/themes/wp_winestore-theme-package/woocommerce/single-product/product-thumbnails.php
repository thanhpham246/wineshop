<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();
$temp_attachment_ids = array();
if ( has_post_thumbnail() ) {
	$thumbnail_id =  get_post_thumbnail_id();
	$temp_attachment_ids = $attachment_ids = array_unique(array_merge(array($thumbnail_id),$attachment_ids));
}

if($product->is_type('variable')){
	$available_variations = $product->get_available_variations();
	if(! empty( $available_variations )):
		$variation_attachment_ids = array();
		foreach($available_variations as $variation){
			$variation_attachment_id = get_post_thumbnail_id( $variation['variation_id'] );
			array_push($variation_attachment_ids,$variation_attachment_id);
		}
		$attachment_ids = array_unique(array_merge($attachment_ids,$variation_attachment_ids));
	endif;
}
		
if ( $attachment_ids ) {
	$loop = 0;
	$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 6 );
	?>
	<div class="thumbnails list_carousel <?php echo 'columns-' . $columns; ?>">
		<ul class="product_thumbnails">
			<?php

				foreach ( $attachment_ids as $attachment_id ) {
					$classes = array(  );

					if ( $loop == 0 || $loop % $columns == 0 )
					{                   
						$classes[] = 'first';
					}
					
					if ( ( $loop + 1 ) % $columns == 0 )
						$classes[] = 'last';

					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;
						
						
					$image_title 		= esc_attr( $product->get_title() );
					//$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),array( 'alt' => $image_title, 'title' => $image_title ) );
			
					$_thumb_size =  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' );
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ),array( 'alt' => $image_title, 'title' => $image_title ) );
					$image_src   = wp_get_attachment_image_src( $attachment_id, $_thumb_size );
					$image_class = esc_attr( implode( ' ', $classes ) );
					$image_class = $image_class." pop_cloud_zoom cloud-zoom-gallery";
					
					if($product->is_type('variable') && count($variation_attachment_ids) > 0 && count($temp_attachment_ids) > 0 && in_array($attachment_id,$variation_attachment_ids) && !in_array($attachment_id,$temp_attachment_ids)){
						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li style="display:none;"><a href="%s" class="%s" title="%s" rel="useZoom: \'zoom1\', smallImage: \'%s\'">%s</a></li>', $image_link, $image_class, $image_title, $image_src[0], $image ), get_post_thumbnail_id(), $post->ID, $image_class );	
					} else {
					//echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s" rel="useZoom: \'zoom1\', smallImage: \'%s\'">%s</a></li>', $image_link, $image_class, $image_title, $image_src[0], $image ), $attachment_id, $post->ID, $image_class );
						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s" rel="useZoom: \'zoom1\', smallImage: \'%s\'">%s</a></li>', $image_link, $image_class, $image_title, $image_src[0], $image ), get_post_thumbnail_id(), $post->ID, $image_class );	
					}
					$loop++;
				}

			?>
		</ul>
		<div class="slider_control">
			<a id="product_thumbnails_prev" class="prev" href="#">&lt;</a>
			<a id="product_thumbnails_next" class="next" href="#">&gt;</a>
		</div>		
	</div>
	
	<?php if( count($attachment_ids) > 0 ) : ?>
	
	<?php 
		$_found_post = count($attachment_ids);
		$_found_post = $_found_post > 6 ? 6 : $_found_post;	
	?>
	
		<script type="text/javascript" language="javascript">
			jQuery(function() {
				jQuery('.product_thumbnails').carouFredSel({				
					responsive: true
					,width	: '<?php echo ($_found_post*16.666666);?>%'
					,height	: 'auto'
					,scroll	: 1
					,swipe	: { onMouse: false, onTouch: true }	
					,items	: {
						width		: 70
						,height		: 70
						,visible	: {
							min		: 1
							,max	: 6
						}
					}
					,auto	: false
					,prev	: '#product_thumbnails_prev'
					,next	: '#product_thumbnails_next'								
				});	
				
			});		
		</script>
		
	<?php endif;?>	
		
	<?php
}
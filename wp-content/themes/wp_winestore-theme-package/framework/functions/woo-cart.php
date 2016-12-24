<?php
if ( ! function_exists( 'wd_tini_cart' ) ) {
	function wd_tini_cart(){
		global $woocommerce;
		
		//return in case $woocommerce empty or pluggin not set
		if( !isset($woocommerce) ){
			return;
		}
		
		$_cart_empty = sizeof( $woocommerce->cart->get_cart() ) > 0 ? false : true ;
		
		ob_start();
		
		?>
		<?php do_action( 'wd_before_tini_cart' ); ?>
		<div class="wd_tini_cart_wrapper">
		
			<div class="wd_tini_cart_control ">
				<a href="<?php echo $woocommerce->cart->get_cart_url();?>" title="<?php _e('View Cart','wpdance');?>" class="cart_size">
					<span id="cart_size_value_head"><?php echo $woocommerce->cart->cart_contents_count;?></span>
				</a>
			</div>
			
			<div class="cart_dropdown drop_down_container">
				<?php if ( !$_cart_empty ) : ?>
				<div class="dropdown_header">
					<ul class="cart_list product_list_widget">
							
							<?php
								$_cart_array = $woocommerce->cart->get_cart();
								$_index = 0;
							?>
							
							<?php foreach ( $_cart_array as $cart_item_key => $cart_item ) :
								
								$_product = $cart_item['data'];

								// Only display if allowed
								if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
									continue;

								// Get price
								//$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
								//$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
								//	echo $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>

								<li class="<?php echo $_cart_li_class = ($_index == 0 ? "first" : ($_index == count($_cart_array) - 1 ? "last" : "")) ?>">
									<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
										<?php echo $_product->get_image(); ?>
									</a>
									<?php
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'wpdance' ) ), $cart_item_key );
									?>									
									<div class="cart_item_wrapper">		
										<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
											<?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
										</a>
										<?php echo $woocommerce->cart->get_item_data( $cart_item ); ?>
										<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $product_price, $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
									</div>
								</li>

								<?php $_index++; ?>
								
							<?php endforeach; ?>
					</ul><!-- end product list -->
				</div>
				<?php endif; ?>
				<?php 
					$no_cart = '';
					if ( $_cart_empty ) {
						$no_cart = "wd_no_item";
					}
				?>	
				<div class="dropdown_foooter <?php echo $no_cart; ?>">
					<?php if ( !$_cart_empty ) : ?>

						<p class="total"><strong>
							<?php _e( 'Subtotal', 'wpdance' ); ?>:</strong> <?php echo $woocommerce->cart->get_cart_subtotal(); ?>
						</p>
						<p class="buttons">
							<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="button_checkout" title="<?php _e( 'Checkout', 'wpdance' ); ?>"><?php _e( 'Checkout', 'wpdance' ); ?></a>
						</p>
						<p class="buttons">
							<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="button_shopping_cart" title="<?php _e( 'Go to Shopping Cart', 'wpdance' ); ?>"><?php _e( 'Go to Shopping Cart', 'wpdance' ); ?></a>
						</p>
														
						<?php else: ?>		
							<?php _e('You have no items in your shopping cart.','wpdance');?>
					<?php endif; ?>	
				</div>				
				
			</div>
		</div>
		<?php do_action( 'wd_after_tini_cart' ); ?>
<?php
		$tini_cart = ob_get_clean();
		return $tini_cart;
	}
}

if ( ! function_exists( 'wd_update_tini_cart' ) ) {
	function wd_update_tini_cart() {
		die($_tini_cart_html = wd_tini_cart());
	}
}

add_action('wp_ajax_update_tini_cart', 'wd_update_tini_cart');
add_action('wp_ajax_nopriv_update_tini_cart', 'wd_update_tini_cart');

?>
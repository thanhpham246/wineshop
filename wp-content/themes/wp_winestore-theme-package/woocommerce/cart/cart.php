<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();
?>

<?php do_action( 'woocommerce_before_cart' ); ?>

<form class="wd_form_cart" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-thumbnail first">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'wpdance' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'wpdance' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'wpdance' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'wpdance' ); ?></th>
			<th class="product-remove last">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );;
				if ( $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class = "<?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $cart_item, $cart_item_key ) ); ?>">

						<!-- The thumbnail -->
						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() )
									echo $thumbnail;
								else
									printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $cart_item['product_id'] ) ) ), $thumbnail );
							?>
						</td>

						<!-- Product Name -->
						<td class="product-name">
							<?php
								if ( ! $_product->is_visible())
									echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $cart_item, $cart_item_key );
								else
									printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $cart_item['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $cart_item, $cart_item_key ) );

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

                   				// Backorder notification
                   				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
                   					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'wpdance' ) . '</p>';
							?>
						</td>

						<!-- Product price -->
						<td class="product-price">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0'
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
							?>
						</td>

						<!-- Product subtotal -->
						<td class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
						
						<!-- Remove from cart link -->
						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'wpdance' ) ), $cart_item_key );
							?>
						</td>						
						
					</tr>
					<?php
				}
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr class="hidden">
			<td colspan="6" class="actions">

			<input type="submit" class="button wd_update_hidden" name="update_cart" value="<?php _e( 'Update Cart', 'wpdance' ); ?>" /> <input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout', 'wpdance' ); ?>" />

			<?php do_action('woocommerce_proceed_to_checkout'); ?>

			<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php woocommerce_shipping_calculator(); ?>	
		
	<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">	
		<div class="coupon_wrapper">
		
				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'wpdance' ); ?></label> <input name="coupon_code" class="input-text" id="coupon_code" value="" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'wpdance' ); ?>" />

						<?php do_action('woocommerce_cart_coupon'); ?>

					</div>
				<?php } ?>

		</div>
	</form>
	
	<div class="cart-total-wrapper">
	
		<?php woocommerce_cart_totals(); ?>

		<div class="cart-actions">
			<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
				<input type="button" class="button wd_update_cart" value="<?php _e( 'Update Cart', 'wpdance' ); ?>" /> 
				<input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout', 'wpdance' ); ?>" />
				<?php //do_action('woocommerce_proceed_to_checkout'); ?>
				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</form>
		</div>	
	
	</div>
	
	<?php do_action('woocommerce_cart_collaterals'); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
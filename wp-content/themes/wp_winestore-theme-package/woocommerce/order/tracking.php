<?php
/**
 * Order tracking
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php
	$order_status_text = sprintf( __( 'Order %s which was made %s has the status &ldquo;%s&rdquo;', 'wpdance' ), $order->get_order_number(), human_time_diff(strtotime($order->order_date), current_time('timestamp')) . ' ' . __( 'ago', 'wpdance' ), $_status_name );

	if ( $order->has_status( 'completed' ) ) $order_status_text .= ' ' . __( 'and was completed', 'wpdance' ) . ' ' . human_time_diff(strtotime($order->completed_date), current_time('timestamp')).__( ' ago', 'wpdance' );

	$order_status_text .= '.';

	echo wpautop( esc_attr( apply_filters( 'woocommerce_order_tracking_status', $order_status_text, $order ) ) );
?>

<?php
	$notes = $order->get_customer_order_notes();
	if ($notes) :
		?>
		<h2><?php _e( 'Order Updates', 'wpdance' ); ?></h2>
		<ol class="commentlist notes">
			<?php foreach ($notes as $note) : ?>
			<li class="comment note">
				<div class="comment_container">
					<div class="comment-text">
						<p class="meta"><?php echo date_i18n('l jS \of F Y, h:ia', strtotime($note->comment_date)); ?></p>
						<div class="description">
							<?php echo wpautop( wptexturize( wp_kses_post( $note->comment_content ) ) ); ?>
						</div>
		  				<div class="clear"></div>
		  			</div>
					<div class="clear"></div>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>
		<?php
	endif;
?>

<?php do_action( 'woocommerce_view_order', $order->id ); ?>
<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $current_user;

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<?php if (!$load_address) : ?>

	<?php woocommerce_get_template('myaccount/my-address.php'); ?>

<?php else : ?>

	<form class="edit-address-from" method="post">

		<h3><?php if ($load_address=='billing') _e( 'Billing Address', 'wpdance' ); else _e( 'Shipping Address', 'wpdance' ); ?></h3>

		<?php foreach ( $address as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

		<?php endforeach; ?>

		<p>
			<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'wpdance' ); ?>" />
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>

<?php endif; ?>
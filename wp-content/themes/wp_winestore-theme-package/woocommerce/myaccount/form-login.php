<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php wc_print_notices(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration')==='yes') : ?>

<div class="col2-set" id="customer_login">

	<div class="col-1">

<?php endif; ?>

		<h2><?php _e( 'Login', 'wpdance' ); ?></h2>
		<form method="post" class="login">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
			
			<p class="form-row form-row-first">
				<label for="username"><?php _e( 'Username or email', 'wpdance' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="form-row form-row-last">
				<label for="password"><?php _e( 'Password', 'wpdance' ); ?> <span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" />
			</p>
			<div class="clear"></div>
			
			<?php do_action( 'woocommerce_login_form' ); ?>	
			
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'wpdance' ); ?>" />
				<label for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'wpdance' ); ?>
				</label>
				<p class="lost_password">
					<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost Password?', 'wpdance' ); ?></a>
				</p>
			</p>
		</form>

<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

	</div>

	<div class="col-2">

		<h2><?php _e( 'Register', 'wpdance' ); ?></h2>
		<form method="post" class="register">
			
			<?php do_action( 'woocommerce_register_form_start' ); ?>
			
			<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>

				<p class="form-row form-row-first">
					<label for="reg_username"><?php _e( 'Username', 'wpdance' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

				<p class="form-row form-row-last">

			<?php else : ?>

				<p class="form-row form-row-wide">

			<?php endif; ?>

				<label for="reg_email"><?php _e( 'Email', 'wpdance' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<div class="clear"></div>

			<p class="form-row form-row-first">
				<label for="reg_password"><?php _e( 'Password', 'wpdance' ); ?> <span class="required">*</span></label>
				<input type="password" class="input-text" name="password" id="reg_password" />
			</p>
			<div class="clear"></div>

			<!-- Spam Trap -->
			<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>
			
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'wpdance' ); ?>" />
			</p>
			
			<?php do_action( 'woocommerce_register_form_end' ); ?>
		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
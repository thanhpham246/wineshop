<?php

if ( ! function_exists( 'wd_tini_account' ) ) {
	function wd_tini_account(){
		global $woocommerce;
		$myaccount_page_id = '';
		if( !isset($woocommerce) ){
			return;
		}
		$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
		if ( $myaccount_page_id ) {
		  $myaccount_page_url = get_permalink( $myaccount_page_id );
		}		
		ob_start();
		
		$_user_logged = is_user_logged_in();
		
		?>
		<?php do_action( 'wd_before_tini_account' ); ?>
		
		
		<div class="wd_tini_account_wrapper">
			<div class="wd_tini_account_control">
				<a href="<?php echo $myaccount_page_url;?>" title="<?php _e('My Account','wpdance');?>">
					<span><?php _e('My Account','wpdance');?></span>
				</a>	
			</div>
			<div class="form_drop_down drop_down_container <?php echo $_user_logged ? "hidden" : "";?>">
				<?php 
					if( !$_user_logged ):
				?>
					
					<div class="form_wrapper">
						<div class="form_wrapper_header">
							<h4 class="heading-title account-form-title"><?php _e('My Account','wpdance');?></h4>
							<span class=""><?php _e(' Please, Login or Create an Account','wpdance');?></span>
						</div>					
						<div class="form_wrapper_body">
							<?php    
								$args = array(
									//'redirect' => admin_url()
									'redirect' => $myaccount_page_url
									,'form_id' => 'loginform-custom'
									,'label_username' => __( 'Username *','wpdance' )
									,'label_password' => __( 'Password *','wpdance' )
									,'label_remember' => __( '','wpdance' )
									,'label_log_in' => __( 'Login','wpdance' )
									,'remember' => false
								);
								wp_login_form( $args );
							?>
							<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php _e('Forgot Your Password?','wpdance');?>"><?php _e('Forgot Your Password?','wpdance');?></a>
						</div>
						<div class="form_wrapper_footer">
							<span><?php _e('New Customer ?','wpdance');?></span><span><a href="<?php echo $myaccount_page_url; ?>"><?php _e('Create An Acount','wpdance');?></a></span>
						</div>
					</div>	
				<?php else: ?>	
					<span class="my_account_wrapper"><a href="<?php echo $url = admin_url( 'profile.php', 'https' ); ?>" title="<?php _e('My Account','wpdance');?>"><?php _e('My Account','wpdance');?></a></span>
					<span class="logout_wrapper"><a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Logout','wpdance');?>"><?php _e('Logout','wpdance');?></a></span>
				<?php
					endif
				?>
			</div>
		</div>
		<?php do_action( 'wd_after_tini_account' ); ?>
<?php
		$tini_account = ob_get_clean();
		return $tini_account;
	}
}

if ( ! function_exists( 'wd_update_tini_account' ) ) {
	function wd_update_tini_account() {
		die($_tini_account_html = wd_tini_account());
	}
}

add_action('wp_ajax_update_tini_account', 'wd_update_tini_account');
add_action('wp_ajax_nopriv_update_tini_account', 'wd_update_tini_account');

?>

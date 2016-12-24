<?php 

	/**
	*	Convert from yes/no to boolen
	*
	**/
	if(!function_exists ('wd_yn_2_bool')){
		function wd_yn_2_bool( $input = 'yes' ) {
			return  ( strcmp( trim(strtoupper($input)),"YES" )  == 0 );
		}
	}

	/**
	*	Check valid html color
	*
	**/
	if(!function_exists ('wd_valid_color')){
		function wd_valid_color( $color = '' ) {
			if( strlen(trim($color)) > 0 ) {
				$named = array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');
				if (in_array(strtolower($color), $named)) {
					return true;
				}else{
					return preg_match('/^#[a-f0-9]{6}$/i', $color);			
				}
			}
			return false;
		}
	}

	/**
	*	Combine a input array with defaut array
	*
	**/
	if(!function_exists ('wd_array_atts')){
		function wd_array_atts($pairs, $atts) {
			$atts = (array)$atts;
			$out = array();
		   foreach($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) ){
					if( strlen(trim($atts[$name])) > 0 ){
						$out[$name] = $atts[$name];
					}else{
						$out[$name] = $default;
					}
				}
				else{
					$out[$name] = $default;
				}	
			}
			return $out;
		}
	}
	
	if(!function_exists ('wd_array_atts_str')){
		function wd_array_atts_str($pairs, $atts) {
			$atts = (array)$atts;
			$out = array();
		   foreach($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) ){
					if( strlen(trim($atts[$name])) > 0 ){
						$out[$name] = $atts[$name];
					}else{
						$out[$name] = $default;
					}
				}
				else{
					$out[$name] = $default;
				}	
			}
			return $out;
		}
	}	
	
	if(!function_exists ('wd_get_all_post_list')){
		function wd_get_all_post_list( $_post_type = "post" ){
			wp_reset_query();
			$args = array(
				'post_type'=> $_post_type
				,'posts_per_page'  => -1
			);
			$_post_lists = get_posts( $args );
			
			if( $_post_lists ){
				foreach ( $_post_lists as $post ) {
					setup_postdata($post);
					$ret_array[] = array(
						$post->ID
						,get_the_title($post->ID)
					);
				}
			}else{
				$ret_array = array();
			}
			wp_reset_query();	
			return $ret_array ;
			
		}
	}	
	
	if(!function_exists ('wd_show_page_slider')){
		function wd_show_page_slider(){
			global $wd_page_datas;
			$revolution_exists = ( class_exists('RevSlider') && class_exists('UniteFunctionsRev') );
			switch ($wd_page_datas['page_slider']) {
				case 'revolution':
					if( $revolution_exists )
						RevSliderOutput::putSlider($wd_page_datas['page_revolution'],"");
					break;
				case 'flex':
					wd_show_flex_slider($wd_page_datas['page_flex']);
					break;	
				case 'nivo':
					wd_show_nivo_slider($wd_page_datas['page_nivo']);
					break;	
				case 'product' :
					wd_show_prod_slider($wd_page_datas['product_tag']);
					break;							
				case 'none' :
					break;							
				default:
				   break;
			}	
		}
	}
	add_action( 'wd_header_init', 'wd_print_header_head', 10 );
	if(!function_exists ('wd_print_header_head')){
		function wd_print_header_head(){
	?>	
	
			<div class="header-top">
				<div class="header-main-content container">

					<div class="header-top-left">
					
						<div class="wellcome_message">
							<?php echo $_wellcome_msg = sprintf( __( '%s','wpdance' ), get_bloginfo( 'description' ) ); ?>
						</div>
						
						<div class="account_links">
							<?php if ( is_user_logged_in() ) : ?>
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','wpdance'); ?>"><?php _e('My Account','wpdance'); ?></a>
							<?php else : ?>
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login','wpdance'); ?>"><?php _e('Login','wpdance'); ?></a>
								<span><?php _e('or','wpdance');?></span>
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Create An Account','wpdance'); ?>"><?php _e('Create An Account','wpdance'); ?></a>
							<?php endif; ?>
						</div>
						
					</div>
					
					<div class="header-top-right">
					
						<div class="quick_access_menu">
							<?php
								if ( is_active_sidebar( 'top-header-widget-area' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'top-header-widget-area' ); ?>
									</ul>
							<?php endif; ?>			
							
							<?php //wp_nav_menu( array( 'container_class' => 'top-menu','theme_location' => 'top-menu' ) ); ?>
						</div>
						
					</div>					

					<div class="mobile_cart_container visible-phone">
						<div class="mobile_cart">

						<div class="header-bottom-wishlist">
							<?php echo wd_tini_account();//TODO : account form goes here?>
						</div>						
						
						<?php
							if(class_exists('woocommerce')){
								global $woocommerce;
								$cart_url = $woocommerce->cart->get_cart_url();
								echo "<a href='{$cart_url}' title='View Cart'>View Cart</a>";
							}
						?>
						</div>
						<div class="mobile_cart_number">0</div>
					</div>					
				</div>
			</div><!-- end header top -->
			
			<script type="text/javascript">
			//<![CDATA[
				jQuery('.top-menu > ul.menu > li.menu-item:first').addClass('first');
				jQuery('.top-menu > ul.menu > li.menu-item:last').addClass('last');
			//]]>	
			</script>			
			
		<?php	
		}	
	}
	
	add_action( 'wd_header_init', 'wd_print_header_body', 20 );
	if(!function_exists ('wd_print_header_body')){
		function wd_print_header_body(){
	?>	
			<div class="header-middle">
				<div class="header-middle-content container">
					
						<div id="header-logo">
								<?php wd_theme_logo();?>
						</div>
					
						<div id="header-search">
							<?php 
								if( function_exists('get_product_search_form') ){
									get_product_search_form( true );
								}else{
									get_search_form();
								}
							?>
						</div>					
							
				</div>
			</div><!-- end .header-middle -->	
			<?php wp_reset_query();?>			
		
	<?php	
		}	
	}

	add_action( 'wd_header_init', 'wd_print_header_footer', 30 );
	if(!function_exists ('wd_print_header_footer')){
		function wd_print_header_footer(){
	?>	
			<div class="header-bottom">
				<div class="heade-bottom-content container">
				
					<div class="nav">
					<?php 
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array( 'container_class' => 'main-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'primary','walker' => new WD_Walker_Nav_Menu() ) );
						}else{
							wp_nav_menu( array( 'container_class' => 'main-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'primary' ) );
						}
					?>
					</div>				
				
					<div class="shopping-cart shopping-cart-wrapper">
						<?php echo wd_tini_cart();?>
					</div>
					
				</div>
			</div><!-- end .header-bottom -->
	<?php		
		}	
	}	
	
	
	add_action( 'wd_bofore_main_container', 'wd_print_inline_script', 10 );
	if(!function_exists ('wd_print_inline_script')){
		function wd_print_inline_script(){
	?>	
		<script type="text/javascript">
		//<![CDATA[
			_ajax_uri = '<?php echo admin_url('admin-ajax.php');?>';
			_on_phone = <?php echo WD_IS_MOBILE === true ? 1 : 0 ;?>;
			_on_tablet = <?php echo WD_IS_TABLET === true ? 1 : 0 ;?>;
			//jQuery("html").niceScroll({cursorcolor:"#000"});
			jQuery('.menu li').each(function(){
				if(jQuery(this).children('.sub-menu').length > 0) jQuery(this).addClass('parent');
			});
		//]]>	
		</script>
	<?php
		}
	}	
	
	add_action( 'wd_bofore_main_container', 'wd_print_ads_block', 20 );
	if(!function_exists ('wd_print_ads_block')){
		function wd_print_ads_block(){
			global $wd_page_datas;
	?>	
			<div class="header_ads_wrapper">
				<?php 
					if( !is_home() && !is_front_page() ){
						if( !is_page() ){
							wd_printHeaderAds();
						}else{
							if( isset($wd_page_datas['hide_ads']) && absint($wd_page_datas['hide_ads']) == 0 )
								wd_printHeaderAds();
						}
						
					}
						
				?>
			</div>
	<?php
		}
	}	

	add_action( 'wd_bofore_main_container', 'wd_show_breadcumb', 30 );
	if(!function_exists ('wd_show_breadcumb')){
		function wd_show_breadcumb(){
			global $wd_page_datas;
	?>	
		<?php if(is_page()):?>
			<?php if( !is_home() && !is_front_page() ):?>
				<div class="top-page container">
					<?php if( isset($wd_page_datas['hide_breadcrumb']) && absint($wd_page_datas['hide_breadcrumb']) == 0 ) wd_dimox_breadcrumbs(); ?>
				</div>	
			<?php endif;?>
		<?php else: ?>	
			<div class="top-page container">
				<?php if ( is_singular('product') || is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
					wd_dimox_shop_breadcrumbs();
				} else {
					wd_dimox_breadcrumbs();
				}
				?>
			</div>		
		<?php endif;?>
	<?php
		}
	}		
	
	//add_action( 'wd_before_body_end', 'wd_before_body_end_widget_area', 10 );
	if(!function_exists ('wd_before_body_end_widget_area')){
		function wd_before_body_end_widget_area(){
	?>	
	
		<div class="container">
				<div class="body-end-widget-area">
					<?php
						if ( is_active_sidebar( 'body-end-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'body-end-widget-area' ); ?>
							</ul>
						<?php endif; ?>						
				</div><!-- end #footer-first-area -->
		</div>	
		<?php wp_reset_query();?>
	
	<?php
		}
	}	
		
	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_1', 10 );
	if(!function_exists ('wd_footer_init_widget_area_1')){
		function wd_footer_init_widget_area_1(){
	?>	
	
		<?php if( !wp_is_mobile() || true ): ?>
		<div class="wd_block_first">			
			<div id="footer-first-area" class="hidden-phone">
				<div class="container">
					<div class="first-footer-widget-area-1 hidden-phone span6">
						<?php if ( is_active_sidebar( 'first-footer-widget-area-1' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'first-footer-widget-area-1' ); ?>
							</ul>
						<?php endif; ?>						
					</div><!-- end #footer-first-area -->
					
					<div class="first-footer-widget-area-2 hidden-phone span6">
						<?php if ( is_active_sidebar( 'first-footer-widget-area-2' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'first-footer-widget-area-2' ); ?>
							</ul>
						<?php endif; ?>						
					</div><!-- end #footer-first-area -->
					
					<div class="first-footer-widget-area-3 hidden-phone span6">
						<?php if ( is_active_sidebar( 'first-footer-widget-area-3' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'first-footer-widget-area-3' ); ?>
							</ul>
						<?php endif; ?>						
					</div><!-- end #footer-first-area -->
					
					<div class="first-footer-widget-area-4 hidden-phone span6">
						<?php if ( is_active_sidebar( 'first-footer-widget-area-4' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'first-footer-widget-area-4' ); ?>
							</ul>
						<?php endif; ?>						
					</div><!-- end #footer-first-area -->	
				</div>	
			</div>	
		</div>	
			<?php wp_reset_query();?>
		<?php endif; ?>	
		
	<?php
		}
	}

	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_2', 20 );
	if(!function_exists ('wd_footer_init_widget_area_2')){
		function wd_footer_init_widget_area_2(){
	?>	
	
		<?php if( !wp_is_mobile() || true ): ?>
		<div class="wd_block_second">
			<div id="top-second-footer-area" class="hidden-phone">
				<div class="top-footer-widget-area hidden-phone">
					<?php if ( is_active_sidebar( 'top-second-footer-widget-area' ) ) : ?>
						<ul class="xoxo">
							<?php dynamic_sidebar( 'top-second-footer-widget-area' ); ?>
						</ul>
					<?php endif; ?>						
				</div><!-- end #top-footer-area -->
			</div>
			
			<div id="footer-second-area" class="hidden-phone">
				<div class="container">
						<div class="second-footer-widget-area-1 span6">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-1' ) ) : ?>
									<ul class="xoxo omega">
										<?php dynamic_sidebar( 'second-footer-widget-area-1' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
						<div class="second-footer-widget-area-2 span6">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-2' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-2' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
						<div class="second-footer-widget-area-3 span6">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-3' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-3' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
						<div class="second-footer-widget-area-4 span6">
							<?php
								if ( is_active_sidebar( 'second-footer-widget-area-4' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-4' ); ?>
									</ul>
							<?php endif; ?>								
						</div>		
				</div>		
			</div><!-- end #footer-second-area -->	
		</div>	
			<?php wp_reset_query();?>
		<?php endif; ?>	
		
	<?php
		}
	}





	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_3', 30 );
	if(!function_exists ('wd_footer_init_widget_area_3')){
		function wd_footer_init_widget_area_3(){
	?>	
			<div class="wd_block_third">
				<div id="copy-right">
					<div class="container">
						<div class="copyright span10">
							<?php echo stripslashes(get_option(THEME_SLUG.'copyright_text')); ?>
						</div>
						<div class="payment span14">
							<?php
								if ( is_active_sidebar( 'payment-footer-widget-area' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'payment-footer-widget-area' ); ?>
									</ul>
							<?php endif; ?>								
						</div>
					</div>
				</div><!-- end #copyright -->
			</div>	
				<?php wp_reset_query();?>
	
	<?php
		}
	}

	add_action( 'wd_before_footer_end', 'wd_before_body_end_content', 10 );
	if(!function_exists ('wd_before_body_end_content')){
		function wd_before_body_end_content(){
	?>	
		<?php $_content = stripslashes(htmlspecialchars_decode(get_option(THEME_SLUG.'contact_content',''))); ?>
		<div id="feedback" class="hidden-phone">
			<a class="feedback-button wd-prettyPhoto" href="#<?php if (strlen($_content) > 0) {  ?>wd_contact_content<?php } ?>" ></a>
		</div>
		
		
		<?php if( strlen($_content) > 0 ):?>
			<div class="contact_form hidden-phone hidden" >
				<div class="contact_form_inner" style="overflow:hidden;" id="wd_contact_content"><?php echo do_shortcode($_content);?></div>
			</div>
		<?php endif;?>
		
		<?php if(!wp_is_mobile()): ?>
		<div id="to-top" class="scroll-button">
			<a class="scroll-button" href="javascript:void(0)" title="<?php _e('Back to Top','wpdance');?>"></a>
		</div>
		<?php endif; ?>
		
	<?php
		}
	}
	
?>
<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>

	
		<div id="container" class="page-template default-template">
			<div id="content" class="container" role="main">
				<div id="main">	
				
				<?php
					global $wd_single_prod_datas;					
					$_layout_config = explode("-",$wd_single_prod_datas['layout']);
					$_left_sidebar = (int)$_layout_config[0];
					$_right_sidebar = (int)$_layout_config[2];
					$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "span12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "span18" : "span24" );
				?>
				
				<?php if( $_left_sidebar ): ?>
							<div id="left-sidebar" class="span6 hidden-phone">
								<div class="left-sidebar-content omega">
								<?php
									if ( is_active_sidebar( $wd_single_prod_datas['left_sidebar'] ) ) : ?>
										<ul class="xoxo">
											<?php dynamic_sidebar( $wd_single_prod_datas['left_sidebar'] ); ?>
										</ul>
								<?php endif; ?>
								</div>
							</div><!-- end left sidebar -->
				<?php endif;?>					
				
				
				
				<div id="main_content" class="<?php echo $_main_class?>">
				
					<div class="<?php if($_left_sidebar) echo "alpha";?> <?php if($_right_sidebar) echo "omega"?>">
						
						<?php
							/**
							 * woocommerce_before_main_content hook
							 *
							 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
							 * @hooked woocommerce_breadcrumb - 20
							 */
							do_action('woocommerce_before_main_content');
						?>


					
						<?php while ( have_posts() ) : the_post(); ?>

							<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

						<?php endwhile; // end of the loop. ?>
					
						<?php
							/**
							 * woocommerce_after_main_content hook
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action('woocommerce_after_main_content');
						?>

					</div>

				</div>	
	
				<?php if( $_right_sidebar  ): ?>
							<div id="right-sidebar" class="span6">
								<div class="right-sidebar-content alpha">
								<?php
									if ( is_active_sidebar( $wd_single_prod_datas['right_sidebar'] ) ) : ?>
										<ul class="xoxo">
											<?php dynamic_sidebar( $wd_single_prod_datas['right_sidebar'] ); ?>
										</ul>
								<?php endif; ?>
								</div>
							</div><!-- end right sidebar -->
				<?php endif;?>	
	
	
				</div><!-- end content -->			
			
			</div>
		</div><!-- #container -->
		
	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>
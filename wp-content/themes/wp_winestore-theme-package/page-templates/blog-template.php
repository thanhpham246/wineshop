<?php
/**
 *	Template Name: Blog Template
 */	
get_header(); ?>

	<?php
		global $wd_page_datas;
		$_layout_config = explode("-",$wd_page_datas['page_column']);
		$_left_sidebar = (int)$_layout_config[0];
		$_right_sidebar = (int)$_layout_config[2];
		$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "span12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "span18" : "span24" );		
	?>

		<div id="container" class="page-template blog-template">
			<div id="content" class="container" role="main">
				
				<div id="main">
				
				<?php if( $_left_sidebar ): ?>
						<div id="left-sidebar" class="span6 hidden-phone">
							<div class="left-sidebar-content omega">
								<?php
									if ( is_active_sidebar( $wd_page_datas['left_sidebar'] ) ) : ?>
										<ul class="xoxo">
											<?php dynamic_sidebar( $wd_page_datas['left_sidebar'] ); ?>
										</ul>
								<?php endif; ?>
							</div>
						</div><!-- end left sidebar -->	
					<?php wp_reset_query();?>
				<?php endif;?>					
				
				<div id="container-main" class="<?php echo $_main_class;?>">
					<div class="main-content <?php if($_left_sidebar) echo "alpha";?> <?php if($_right_sidebar) echo "omega"?>">					
						<?php if( (!is_home() && !is_front_page()) && absint($wd_page_datas['hide_title']) == 0 ):?>
							<h1 class="heading-title page-title blog-title"><?php the_title();?></h1>
						<?php endif;?>
						
						<div class="page-content">
							<div class="content-inner"><?php the_content();?></div>
						</div>
						
						<?php	
							$count=0;
							global $wp_query;
							query_posts('post_type=post'.'&paged='.get_query_var('page'));						
							get_template_part( 'content', get_post_format() ); 
						?>
						
						<div class="page_navi">
							<div class="nav-previous"><?php previous_posts_link( __( 'Prev Entries', 'wpdance' ) ); ?></div>
							<div class="nav-content"><?php wd_ew_pagination();?></div>
							<div class="nav-next"><?php next_posts_link( __( 'Next Entries', 'wpdance' ) ); ?></div>
							<?php wp_reset_query();?>
						</div>
	
					</div>
				</div><!-- end content -->
				
				
				<?php if( $_right_sidebar ): ?>
					<div id="right-sidebar" class="span6">
						<div class="right-sidebar-content alpha">
						<?php
							if ( is_active_sidebar( $wd_page_datas['right_sidebar'] ) ) : ?>
								<ul class="xoxo">
									<?php dynamic_sidebar( $wd_page_datas['right_sidebar'] ); ?>
								</ul>
						<?php endif; ?>
						</div>
					</div><!-- end right sidebar -->
					<?php wp_reset_query();?>
				<?php endif;?>		
			
				</div><!-- #main -->
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>
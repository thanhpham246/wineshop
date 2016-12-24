<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage RoeDok
 * @since WD_Responsive
 */	
get_header(); ?>
		<div id="container" class="page-container container-404">
			<div id="content" role="main" class="container">		
				<div id="main">
					<div id="container-main" class="span24">
						<div class="main-content">	
							<h1 class="heading-title page-title">W.P.L.O.C.K.E.R.COM - ERROR 404</h1>
								<div class="entry-content">
									<div class="warning">
										<img width="593" height="215" src="http://demo.wpdance.com/imgs/wp_wine_store/404.png" alt="wpdance" class="img-404">
									</div>
									<div class="alert alert-info">
										<p><?php 
												_e( 'You may have stumbled here by accident or the post you are looking for is no longer here.', 'wpdance');
												_e('Please try one of the following:', 'wpdance' ); 
											?></p>
										<ul class="listing-style listing-style-3">
											<li><?php _e('Hit the "back" button on your browser.','wpdance')?></li>
											<li><?php _e('Return to the Usability.','wpdance')?></li>
											<li><?php _e('Use the navigation menu at the top of the page','wpdance')?></li>
										</ul>
									</div>
							</div>
				    	</div>
					</div>	
				</div><!-- end content -->
				
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>

<?php
/**
 *	Template Name: Fullwidth Template
 */	
get_header(); ?>
	<div id="container">
		<div id="content" class="container" role="main">	
			<div id="main" class="span24">
				<div class="main-content">
					<div class="entry-content">
							<?php
							/* Run the loop to output the posts.
							 * If you want to overload this in a child theme then include a file
							 * called loop-index.php and that will be used instead.
							 */	
								if(have_posts()) : while(have_posts()) : the_post();
								?>
									<div class="page-item">
										
										<div><?php the_content(); ?></div>
									</div>
								<?php						
								endwhile;
								endif;	
							?>
					</div>	
				</div>
			</div>
		</div>	
	</div><!-- #container -->
<?php get_footer(); ?>
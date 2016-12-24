<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */

get_header(); ?>
		<div id="container">
			<div id="content" class="container single-blog">
			
				<div id="left-sidebar" class="span6 hidden-phone">
					<div class="left-sidebar-content alpha">
					<?php
						if ( is_active_sidebar( 'blog-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'blog-widget-area' ); ?>
							</ul>
					<?php endif; ?>
					</div>
				</div><!-- end left sidebar -->			
		
				<div id="main" class="span18">
					<div class="main-content omega">					
						<div class="single-content">
							<?php	
								if(have_posts()) : while(have_posts()) : the_post(); global $post,$wd_single_post_config;
								$wd_single_post_config = unserialize( get_option(THEME_SLUG.'single_post_config','') );
								$wd_single_post_config = wd_array_atts(
									array(
											'show_category' => 1
											,'show_author_post_link' => 1
											,'show_time' => 1
											,'show_tags' => 1
											,'show_comment_count' => 1
											,'show_social' => 1
											,'show_author' => 1
											,'show_related' => 1
											,'related_label' => "Related Posts"
											,'show_comment_list' => 1				
											,'comment_list_label' => "Responds"				
											,'num_post_related' => 4
											,'show_category_phone' => 1
											,'show_author_post_link_phone' => 1
											,'show_time_phone' => 1
											,'show_tags_phone' => 1
											,'show_comment_count_phone' => 1
											,'show_social_phone' => 1
											,'show_author_phone' => 1
											,'show_related_phone' => 1
											,'show_comment_list_phone' => 1													
										)
									,$wd_single_post_config);										
								?>
									<div <?php post_class("single-post");?>>
										<?php echo stripslashes(htmlspecialchars_decode(get_option(THEME_SLUG.'code_to_top_post')));?>
													
										<?php edit_post_link( __( 'Edit', 'wpdance' ), '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>										
										
										<div class="post-title">
											<h1 class="heading-title"><?php the_title(); ?></h1>
											<div class="single-navigation clearfix">
												<?php previous_post_link('%link', __('Previous', 'wpdance')); ?>
												<?php next_post_link('%link', __('Next', 'wpdance')); ?>
											</div>
											<div class="heading-author-last">
												<?php if( absint($wd_single_post_config['show_time']) == 1 ) : ?>			
													<div class="time<?php if( $wd_single_post_config['show_time_phone'] != 1 ) echo " hidden-phone";?>">
														<span class="entry-date"><?php echo get_the_date('l,M j,Y') ?></span>
													</div>
												<?php endif; ?>												
												
											
												<?php if( absint($wd_single_post_config['show_author_post_link']) == 1 ) : ?>
													<span class="author<?php if( $wd_single_post_config['show_author_post_link_phone'] != 1 ) echo " hidden-phone";?>"><?php _e('Post By','wpdance');?> <?php the_author_posts_link();?></span>
												<?php endif; ?>
												
													
												<?php if( absint($wd_single_post_config['show_comment_count']) == 1 ) : ?>
													<span class="comments-count<?php if( $wd_single_post_config['show_comment_count_phone'] != 1 ) echo " hidden-phone";?>">
														<?php $comments_count = wp_count_comments($post->ID); echo $comments_count->approved," "; _e('Comment(s)','wpdance'); ?>
													</span>
												<?php endif; ?>		
											</div>
										</div>
										
										<div class="post-detail">
											
												<?php wp_link_pages(); ?>	

												<div class="post-content"><?php the_content(); ?></div>												

												<div class="post-social-wrapper">
												
													<?php if( absint($wd_single_post_config['show_tags']) == 1 ) : ?>
														<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
														<?php
															/* translators: used between list items, there is a space after the comma */
															$tags_list = get_the_tag_list( '', __( '', 'wpdance' ) );
															if ( $tags_list ):
															?>
																<div class="tags">
																	<span class="tag-title"><?php _e('Tags','wpdance');?></span>
																	<span class="tag-links<?php if( $wd_single_post_config['show_tags_phone'] != 1 ) echo " hidden-phone";?>">
																		<?php printf( __( '<span class="%1$s"></span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
																		$show_sep = true; ?>
																	</span>
																</div>
															<?php endif; // End if $tags_list ?>
														<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>
													<?php endif; ?>
												
												
												<?php if( absint($wd_single_post_config['show_social']) == 1 ) : ?>
													<div class="share-list<?php if( $wd_single_post_config['show_social_phone'] != 1 ) echo " hidden-phone";?>">
													<?php 
														if(function_exists('sharethis_button')){
															sharethis_button();
														}
													?>
													</div>
												<?php endif;?>	
											
											</div>

											<!--Category List-->
											<?php if( $wd_single_post_config['show_category'] == 1 ) : ?>
												<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
												
												<div class="categories">
												<span class="tag-title"><?php _e('Categories','wpdance');?></span>
												<?php
													/* translators: used between list items, there is a space after the comma */
													$categories_list = get_the_category_list( __( ', ', 'wpdance' ) );
														if ( $categories_list ):
													?>
													<span class="cat-links<?php if( $wd_single_post_config['show_category_phone'] != 1 ) echo " hidden-phone";?>">
														<?php printf( __( '<h3 class="%1$s heading-title"></h3> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );?>
													</span>
													<?php endif; // End if categories ?>
													
												</div>	
													
												<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>	
											<?php endif;?>											
												
										</div>
										

									
										<?php echo stripslashes(htmlspecialchars_decode(get_option(THEME_SLUG.'code_to_bottom_post')));?>	
									</div>

									<?php if( absint($wd_single_post_config['show_author']) == 1 ) : ?>
										<div id="entry-author-info" class="<?php if( $wd_single_post_config['show_author_phone'] != 1 ) echo "hidden-phone";?>">
											<div class="author-inner">
												<h3 class="title-box heading-title"><?php _e('About The Author','wpdance')?></h3>
												
												<div id="author-description">
													<div id="author-avatar" class="image-style">
														<div class="thumbnail">
														
														<?php
														
															$local_list = array('127.0.0.1','localhost','127.0.0.1',"::1");
															$is_local = false;
															if( in_array($_SERVER['REMOTE_ADDR'], $local_list) ){
																echo '<img width="71" height="71" class="avatar avatar-71 photo" src="' . get_bloginfo('template_url') . '/images/mycustomgravatar.png' . '" alt="">';
															}else{
																 echo get_avatar( get_the_author_meta( 'user_email' ), 71,get_bloginfo('template_url') . '/images/mycustomgravatar.png' );
															}
														
														?>
														
														</div>
													</div><!-- #author-avatar -->
													<span class="author-name"><?php the_author_posts_link();?></span>
													<?php the_author_meta( 'description' ); ?>
													<span class="view-all-author-posts">
														<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
															<?php _e("View all posts by",'wpdance');echo " ";the_author_meta( 'display_name' ); ?>
														</a>
													</span>
												</div><!-- #author-description -->
											</div><!-- #author-inner -->
										</div><!-- #entry-author-info -->
									<?php endif; ?>	
									
									<?php if( absint($wd_single_post_config['show_related']) == 1 ) : ?>
										<?php 
											get_template_part( 'templates/related_posts' );
										?>
									<?php endif;?>
									
									<?php comments_template( '', true );?>
									
								<?php						
								endwhile;
								endif;	
								wp_reset_query();
							?>	
						</div>
					</div>
				</div>
							
				
			</div><!-- #content -->
			
		</div><!-- #container -->
<?php get_footer(); ?>
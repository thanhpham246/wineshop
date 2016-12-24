<?php
/**
 * The template for displaying Content.
 *
 * @package WordPress
 * @subpackage RoeDok
 * @since WD_Responsive
 */
?>
<?php
	$archive_page_config = get_option(THEME_SLUG.'archive_page_config','');
	$archive_page_config = unserialize($archive_page_config);
	
	$archive_page_config = wd_array_atts(
		array(
				'show_category' => 1
				,'show_author_post_link' => 1
				,'show_time' => 1
				,'show_tags' => 1
				,'show_comment_count' => 1
				,'show_excerpt' => 1
				,'show_thumb' => 1
				,'show_content' => 1
				,'show_read_more' => 1				
				,'show_category_phone' => 1
				,'show_author_post_link_phone' => 1
				,'show_time_phone' => 1
				,'show_tags_phone' => 1
				,'show_comment_count_phone' => 1
				,'show_excerpt_phone' => 1
				,'show_thumb_phone' => 1
				,'show_content_phone' => 1
				,'show_read_more_phone' => 1			

			)
		,$archive_page_config);
?>
<ul class="list-posts">
	<?php	
	$count=0;
	if(have_posts()) : while(have_posts()) : the_post(); global $post;$count++;global $wp_query;
			if($count == 1) 
				$_sub_class =  " first";
			if($count == $wp_query->post_count) 
				$_sub_class = " last" 
		?>
		<li <?php post_class("".$_sub_class);?>>
			
			<?php if( $archive_page_config['show_thumb'] == 1 ) : ?>
				<div class="post-thumbnail-wrapper">
					<div class="thumbnail<?php if( $archive_page_config['show_thumb_phone'] != 1 ) echo " hidden-phone";?>">
						<?php 
							$video_url = get_post_meta( $post->ID, THEME_SLUG.'url_video', true);
							if( $video_url!= ''){
								echo get_embbed_video( $video_url, 280, 246 );
							}
							else{
								?>
								<div class="image">
									<a class="thumb-image" href="<?php the_permalink() ; ?>">
									<?php 
										if ( has_post_thumbnail() ) {
											the_post_thumbnail('wd_thumb',array('class' => 'thumbnail-effect-1'));
											the_post_thumbnail('wd_thumb',array('class' => 'thumbnail-effect-2'));
										} else	 { ?>
											<img alt="<?php the_title(); ?>" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-image-blog.gif"/>
									<?php	}			
									?>					
									</a>
								</div>
								<?php
							}
						?>	
					</div>
				</div>	
			<?php endif;?>
			
			
			<div class="post-infors-wrapper">
				<div class="post-title">
						<a class="post-title heading-title" href="<?php the_permalink() ; ?>"><h2 class="heading-title"><?php the_title(); ?></h2></a>
						<?php edit_post_link( __( 'Edit', 'wpdance' ), '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>
						<div class="clear"></div>
				</div>
				
				<?php if( $archive_page_config['show_time'] == 1 ) : ?>	
					<div class="time hidden-phone <?php if( $archive_page_config['show_time_phone'] != 1 ) echo " hidden-phone";?>">
						<span class="entry-date"><?php echo get_the_date() ?></span>
					</div>
				<?php endif;?>					
				
				<?php if( $archive_page_config['show_excerpt'] == 1 ) : ?>
					<p class="short-content<?php if( $archive_page_config['show_excerpt_phone'] != 1 ) echo " hidden-phone";?>"><?php /*the_content();*/wd_the_excerpt_max_words(60,$post); ?></p>
				<?php endif; ?>	
				
				<?php wp_link_pages(); ?>				
				
				<?php if( $archive_page_config['show_read_more'] == 1 ) : ?>
					<a class="read-more <?php if( $archive_page_config['show_read_more_phone'] != 1 ) echo " hidden-phone";?>" href="<?php the_permalink() ; ?>"><span><span><?php _e('Read more','wpdance'); ?></span></span></a>	
				<?php endif;?>

				<div class="wd_meta">
	
				<?php if( $archive_page_config['show_comment_count'] == 1 ) : ?>	
					<span class="comments-count<?php if( $archive_page_config['show_comment_count_phone'] != 1 ) echo " hidden-phone";?>">
						<?php $comments_count = wp_count_comments($post->ID); echo $comments_count->approved," "; _e('Comment(s)','wpdance'); ?>
					</span>
				<?php endif;?>	
		
				<?php if( $archive_page_config['show_author_post_link'] == 1 ) : ?>
					<span class="author<?php if( $archive_page_config['show_author_post_link_phone'] != 1 ) echo " hidden-phone";?>">	
						<?php _e('Post By','wpdance');?> <?php the_author_posts_link();?>
					</span>
				<?php endif;?>		
		
				
					

				<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) && $archive_page_config['show_category'] == 1 ) : // Hide category text when not supported ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'wpdance' ) );
						if ( $categories_list ):
					?>
					<span class="cat-links<?php if( $archive_page_config['show_category_phone'] != 1 ) echo " hidden-phone";?>">
						<?php _e('Post On ','wpdance');?>
						<?php printf( __( '<span class="%1$s"></span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );?>
					</span>
					<?php endif; // End if categories ?>
				<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>					
					
				<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) && $archive_page_config['show_tags'] == 1 ) : // Hide tag text when not supported ?>
						<?php
							/* translators: used between list items, there is a space after the comma */
							$tags_list = get_the_tag_list( '', __( ', ', 'wpdance' ) );
							if ( $tags_list ):
							if ( isset($show_sep) && $show_sep ) : ?>
						<span class="sep<?php if( $archive_page_config['show_tags_phone'] != 1 ) echo " hidden-phone";?>"> | </span>
							<?php endif; // End if $show_sep ?>
						<span class="tag-links<?php if( $archive_page_config['show_tags_phone'] != 1 ) echo " hidden-phone";?>">
							<i class="icon-tags icon-large custom-icon"></i>
							<?php printf( __( '<span class="%1$s"></span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
							$show_sep = true; ?>
						</span>
						<?php endif; // End if $tags_list ?>
				<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>
				
				</div>
			</div>
			
		</li>
	<?php						
	endwhile;
	else : echo "<div class=\"alpha omega\"><div class=\"alert alert-error alpha omega\">Sorry. There are no posts to display</div></div>";
	endif;	
	?>	
</ul>
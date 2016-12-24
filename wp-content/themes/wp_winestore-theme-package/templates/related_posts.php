<?php
	global $wd_single_post_config;
?>
<div class="related container<?php if( absint($wd_single_post_config['show_related_phone']) != 1 ) echo " hidden-phone";?>">
	<span class="title"><?php echo stripslashes(esc_attr($wd_single_post_config['related_label'])); ?></span>	
	<ul class="gama">
	<?php
		$_cat_list = get_the_category($post->ID);
		$_cat_list_arr = array();
		foreach($_cat_list as $_cat_item){
			array_push($_cat_list_arr,$_cat_item->term_id);
		}
		$_list_cat_id = implode($_cat_list_arr,",");
		if( !empty( $_cat_list  ))
			$arg=array(
				'post_type' => $post->post_type,
				'cat' => $_list_cat_id,
				'post__not_in' => array($post->ID),
				'posts_per_page' => $wd_single_post_config['num_post_related']
			);
		else
			$arg=array(
			'post_type' => $post->post_type,
			'post__not_in' => array($post->ID),
			'posts_per_page' => $wd_single_post_config['num_post_related']
		);
		wp_reset_query();
		$related = new wp_query($arg);$cout = 0;
		if($related->have_posts()) : while($related->have_posts()) : $related->the_post();global $post;$cout++;
			$thumb=get_post_thumbnail_id($post->ID);
			$thumburl=wp_get_attachment_image_src($thumb,'full');
			?>
				<li class="span6 related-item <?php if($cout==1) echo " first";if($cout==$related->post_count) echo " last";?>">
					<div class="alpha">
						<a class="thumbnail" href="<?php the_permalink(); ?>">
							<?php 
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'related_thumb',array('title' => get_the_title(),'alt' => get_the_title(),'class' => 'thumbnail-effect-1') );
									the_post_thumbnail( 'related_thumb',array('title' => get_the_title(),'alt' => get_the_title(),'class' => 'thumbnail-effect-2') );
								} 							
							?>
						</a>
						<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<span class="entry-date"><?php echo get_the_date() ?></span>
					</div>
				</li>
			<?php
		endwhile;
		else:
			echo "<li class=\"span12 related-404\"><div class=\"alert alert-warning\">Sorry,no post found!</div></li>";
		endif;
		wp_reset_query();
	?>
	</ul>
</div>
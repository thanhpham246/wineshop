<?php 
if(!class_exists('WP_Widget_Recent_Post_Thumbnail')){
	class WP_Widget_Recent_Post_Thumbnail extends WP_Widget {
    	function WP_Widget_Recent_Post_Thumbnail() {
				$widget_ops = array('description' => 'This widget show recent post in each category you select (include thumbnail).' );

				$this->WP_Widget('recent_post_thumbnail', 'WD - Recent Posts [included thumbnail]', $widget_ops);
		}
	  
		function widget($args, $instance){
			global $wpdb; // call global for use in function
			
			
			$cache = wp_cache_get('recent_post_thumbnail', 'widget');			
			
			if ( ! is_array( $cache ) )
				$cache = array();

			if ( isset( $cache[$args['widget_id']] ) ) {
				echo $cache[$args['widget_id']];
				return;
			}

			ob_start();			
			
			extract($args); // gives us the default settings of widgets
			
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent','wpdance') : $instance['title']);
			
			$link = empty( $instance['link'] ) ? '#' : esc_url($instance['link']);
			$link = ( isset($link) && strlen($link) > 0 ) ? $link : "#" ;
			
			$_limit = absint($instance['limit']) == 0 ? 5 : absint($instance['limit']);
			
			echo $before_widget; // echos the container for the widget || obtained from $args
			if($title){
				echo $before_title."<a href='{$link}' title='{$title}'>".$title.'</a>'.$after_title;
			}
			wp_reset_query();	
			$num_count = count(query_posts("showposts={$_limit}&ignore_sticky_posts=1"));	
			if(have_posts())	{
				$id_widget = 'recent-'.rand(0,1000);
				echo '<ul>';
				$i = 0;
				while(have_posts()) {the_post();global $post;
					?>
					<li class="item<?php if($i == 0) echo ' first';?><?php if(++$i == $num_count) echo ' last';?>">
						<a href="<?php the_permalink(); ?>">
							<?php if(has_post_thumbnail()){ ?>
								<?php the_post_thumbnail('prod_tini_thumb');?>	
							<?php } else { ?>	
								<img alt="<?php the_title(); ?>" height="70" width="70" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-thumb-100x100.gif"/>
							<?php } ?>
						</a>
						<div class="detail">						
							<div class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdance' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php echo esc_attr(get_the_title()); ?>
								</a>
							</div>
							<p class="wd_thumbnail_meta">
								<span class="entry-date"><?php echo get_the_date('l, F j, Y') ?></span>
							</p>
						</div><!-- .detail -->
						
					</li>
				
					
				<?php }
				echo '</ul>';
			}
			wp_reset_query();
			
			echo $after_widget; // close the container || obtained from $args
			$content = ob_get_clean();

			if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

			echo $content;

			wp_cache_set('recent_post_thumbnail', $cache, 'widget');			
			
		}

		
		function update($new_instance, $old_instance) {
			return $new_instance;
		}

		
		function form($instance) {        

			//Defaults
			$instance = wp_parse_args( (array) $instance, array( 'title' => 'w p l o c k e r .c o m','link'=>'#','limit'=>4) );
			$title = esc_attr( $instance['title'] );
			$limit = absint( $instance['limit'] );
			$link = esc_url( $instance['link'] );
			?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title','wpdance' ); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e( 'Title Link','wpdance' ); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" /></p>			
			
			<p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Limit','wpdance' ); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></p>
			
	<?php
		   
		}
	}
}
?>
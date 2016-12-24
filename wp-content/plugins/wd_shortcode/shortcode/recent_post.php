<?php 
if(!function_exists ('recent_blogs_functions')){
	function recent_blogs_functions($atts,$content = false){
		extract(shortcode_atts(array(
			'category'				=>	''
			,'columns'				=> 4
			,'number_posts'			=> 8
			,'title'				=> 'yes'
			,'thumbnail'			=> 'yes'
			,'meta'					=> 'yes'
			,'excerpt'				=> 'yes'
			,'excerpt_words'		=> 30
			,'show_icon_nav'		=> 'yes'
			,'show_nav'				=> 'yes'
			,'slider'				=> 'yes'
		),$atts));

		wp_reset_query();	

		$args = array(
				'post_type' 			=> 'post'
				,'ignore_sticky_posts' 	=> 1
				,'showposts' 			=> $number_posts
		);	
		if( strlen($category) > 0 ){
			$args = array(
				'post_type' 			=> 'post'
				,'ignore_sticky_posts' 	=> 1
				,'showposts' 			=> $number_posts
				,'category_name' 		=> $category
			);	
		}		
		$title = strcmp('yes',$title) == 0 ? 1 : 0;
		$thumbnail = strcmp('yes',$thumbnail) == 0 ? 1 : 0;
		$meta = strcmp('yes',$meta) == 0 ? 1 : 0;
		$excerpt = strcmp('yes',$excerpt) == 0 ? 1 : 0;
		
		$show_nav 				= wd_yn_2_bool($show_nav);
		$show_icon_nav 			= wd_yn_2_bool($show_icon_nav);		
		$slider 				= wd_yn_2_bool($slider);		
		
		$span_class = "span".(24/$columns);
		
		$num_count = count(query_posts($args));	
		if( have_posts() ) :
			$id_shortcode_slider = 'recent-blogs-shortcode-slider-'.rand(0,1000);
			ob_start();
		?>	
		
		<div class="recent_blog_slider_wrapper" id="<?php echo $id_shortcode_slider;?>">	
			<ul class="shortcode-recent-blogs columns-<?php echo $columns;?>">
			
		<?php	
			$i = 0;
			while(have_posts()) {
				the_post();
				global $post;
				?>
				<li class="item <?php echo $span_class ?><?php if( $i == 0 || $i % $columns == 0 ) echo ' first';?><?php if( $i == $num_count-1 || $i % $columns == $columns-1 ) echo ' last';?>">
					<div>
					
						<div class="image <?php if(!$thumbnail) echo "hidden-element"?>">
							<a class="thumbnail" href="<?php the_permalink(); ?>">
								<?php 
									the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-effect-1'));
								?>
							</a>
							<span class="blog-time <?php if(!$meta) echo "hidden-element"?>">
								<span class="day"><?php the_time('d'); ?></span>
								<span class="montyh"><?php the_time('M'); ?></span>
							</span>
						</div>
						<div class="detail">
							<h4 class="heading-title <?php if(!$title) echo 'hidden-element'; ?>"><a href="<?php echo get_permalink($post->ID); ?>" class="wpt_title"  ><?php echo get_the_title($post->ID); ?></a></h4>
							<p class="excerpt <?php if(!$excerpt) echo "hidden-element"?>"><?php wd_the_excerpt_max_words($excerpt_words); ?></p>
						</div>	
					</div>
				</li>
		<?php
			$i++;
			}
		?>
		
			</ul>
			
			<?php if($show_icon_nav && $slider):?>
				<div id="<?php echo $id_shortcode_slider;?>_pager" class="pager"></div>
			<?php endif;?>
			
			<?php if($show_nav && $slider):?>
				<div class="slider_control">
					<a id="<?php echo $id_shortcode_slider;?>_prev" class="prev" href="#">&lt;</a>
					<a id="<?php echo $id_shortcode_slider;?>_next" class="next" href="#">&gt;</a>
				</div>
			<?php endif;?>			
			
			<?php if($slider):?>
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						// Using custom configuration
						jQuery("#<?php echo $id_shortcode_slider?> > ul").carouFredSel({
							items 				: {
								width: <?php echo wp_is_mobile() ? 520 : 260 ;?>
								,height: 'auto'
								,visible: {
									min: 1
									,max: <?php echo $columns;?>
								}							
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }		
							,scroll				: <?php if( !wp_is_mobile() ) : ?>
													{ /*items : <?php echo $columns;?>,*/
														duration : 500
														, pauseOnHover:true
														//, easing : "elastic"
													}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $id_shortcode_slider;?>_prev'
							,next				: '#<?php echo $id_shortcode_slider;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $id_shortcode_slider;?>_pager'
							<?php endif;?>							
						});	
					});	
				</script>	
			<?php endif;?>			
			
		</div>	
		
		<?php
			$ret_html = ob_get_contents();
			ob_end_clean();
			//ob_end_flush();
		endif;
		wp_reset_query();
		return $ret_html;
	}
} 
add_shortcode('recent_blogs','recent_blogs_functions');


if(!function_exists ('recent_portfolios_function')){
	function recent_portfolios_function($atts,$content = false){
		extract(shortcode_atts(array(
			'gallery'		=>	''
			,'columns'		=> 1
			,'number_posts'	=> 4
			,'title'		=> 'yes'
			,'thumbnail'	=> 'yes'
			,'meta'			=> 'yes'
			,'excerpt'		=> 'yes'
			,'excerpt_words'=> 30
		),$atts));

		wp_reset_query();	

		$args = array(
				'post_type' 		=> 'portfolio'
				,'showposts' 		=> $number_posts
		);	
		if( strlen($gallery) > 0 ){
			$args = array(
				'post_type' 		=> 'portfolio'
				,'showposts' 		=> $number_posts
				,'tax_query' => array(
					array(
						'taxonomy' => 'gallery'
						,'field' => 'slug'
						,'terms' => $gallery
					)
				)
			);	
		}		
		$title = strcmp('yes',$title) == 0 ? 1 : 0;
		$thumbnail = strcmp('yes',$thumbnail) == 0 ? 1 : 0;
		$meta = strcmp('yes',$meta) == 0 ? 1 : 0;
		$excerpt = strcmp('yes',$excerpt) == 0 ? 1 : 0;
		
		$span_class = "span".(12/$columns);
		
		$num_count = count(query_posts($args));	
		if( have_posts() ) :
			$id_widget = 'recent-portfolios-shortcode'.rand(0,1000);
			ob_start();
			echo '<ul id="'. $id_widget .'"class="shortcode-recent-portfolios columns-'.$columns.'">';
			$i = 0;
			while(have_posts()) {
				the_post();
				global $post;
				$post_title = get_the_title($post->ID);
				$post_url =  get_permalink($post->ID);
				$url_video = get_post_meta($post->ID,THEME_SLUG.'video_portfolio',true);
				$term_list = implode( ' ', wp_get_post_terms($post->ID, 'gallery', array("fields" => "slugs")) );		

				if( strlen( trim($url_video) ) > 0 ){
					if(strstr($url_video,'youtube.com') || strstr($url_video,'youtu.be')){
						$thumburl = array(get_thumbnail_video_src($url_video , 500 ,320));
						$item_class = "thumb-video youtube-fancy";
					}
					if(strstr($url_video,'vimeo.com')){
						$thumburl = array(wp_parse_thumbnail_vimeo(wp_parse_vimeo_link($url_video), 500, 320));	
						$item_class = "thumb-video vimeo-fancy";
					}
					$light_box_url = $url_video;
				}else{
					$thumb=get_post_thumbnail_id($post->ID);
					$thumburl=wp_get_attachment_image_src($thumb,'full');
					$item_class = "thumb-image";
					$light_box_url = $thumburl[0];
				}
									
				$portfolio_slider = get_post_meta($post->ID,THEME_SLUG.'_portfolio_slider',true);
				$portfolio_slider = unserialize($portfolio_slider);
				$slider_thumb = false;
				if( is_array($portfolio_slider) && count($portfolio_slider) > 0 ){
					$slider_thumb = true;
					$item_class = "thumb-slider";
				}

									
				?>
				<li class="item <?php echo $span_class ?><?php if( $i == 0 || $i % $columns == 0 ) echo ' first';?><?php if( $i == $num_count-1 || $i % $columns == $columns-1 ) echo ' last';?>">
					<div>
						<div class="image <?php if(!$thumbnail) echo "hidden-element"?>">
							<?php if($slider_thumb){?>
								<div class="portfolio-slider">
									<ul class="slides">
										<?php foreach( $portfolio_slider as $slide ){ ?>	
											<li><a href="<?php echo $slide['url'];?>"><?php the_post_thumbnail('blog_shortcode', array('alt' => $slide['alt'],'title' => $slide['title'])); ?></a></li>
										<?php } ?>
									</ul>	
								</div>				
							<?php }else{ ?>
								<?php 
									the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-effect-1'));
								?>
							<?php }?>
						</div>
						<div class="detail<?php if(!has_post_thumbnail()) echo ' noimage';?>">
							<p class="title <?php if(!$title) echo "hidden-element"?>"><h4 class="heading-title"><a href="<?php echo get_permalink($post->ID); ?>" class="wpt_title"  ><?php echo get_the_title($post->ID); ?></a></h4></p>
							<p class="excerpt <?php if(!$excerpt) echo "hidden-element"?>"><?php wd_the_excerpt_max_words($excerpt_words); ?></p>
							<div class="meta <?php if(!$meta) echo "hidden-element"?>"><span class="author-time"><span class="author"><?php the_author(); ?></span><b>/</b><span class="time"><?php the_time('F d,Y'); ?></span><b>/</b><span class="comment-number"><?php comments_number( '0 Comments','1 Comment','% Comments'); ?></span></span></div>
						</div>	
					</div>
				</li>
		<?php
			$i++;
			}
			echo '</ul>';
			$ret_html = ob_get_contents();
			ob_end_clean();
		endif;
		wp_reset_query();
		return $ret_html;
	}
} 
//add_shortcode('recent_portfolios','recent_portfolios_function');



if(!function_exists ('recent_works_function')){
	function recent_works_function($atts,$content = false){
		extract(shortcode_atts(array(
			'count_items'	=>	'10'
			,'show_items' => 4
			,'gallery' => ''
		),$atts));

		wp_reset_query();	
		
			$args = array(
				'post_type' => 'portfolio'
				,'showposts' => $count_items

			);	
			
		if( strlen($gallery) > 0 ){
			$args = array(
				'post_type' => 'portfolio'
				,'showposts' => $count_items
				,'tax_query' => array(
					array(
						'taxonomy' => 'gallery'
						,'field' => 'slug'
						,'terms' => $gallery
					)
				)
			);
		}
		$num_count = count(query_posts($args));	
		if( have_posts() ) :
			$id_widget = 'recent-works-shortcode'.rand(0,1000);
			ob_start();
?>			
			<div id="<?php echo $id_widget;?>" class="shortcode-recent-works flexslider">
				<div class="slider-div">
					<ul class="slides">
					<?php			
						$i = 0;
						while(have_posts()) {
							the_post();
							global $post;
							?>
							<li class="item<?php if($i == 0) echo ' first';?><?php if(++$i == $num_count) echo ' last';?>">
								<?php
								$thumb_arr = get_thumbnail(300,170,'',get_the_title(),get_the_title());
								$thumb = $thumb_arr["fullpath"];
									$url_video = get_post_meta($post->ID,THEME_SLUG.'video_portfolio',true);
									if( strlen( trim($url_video) ) > 0 ){
										if(strstr($url_video,'youtube.com') || strstr($url_video,'youtu.be')){
											$thumburl = array(get_thumbnail_video_src($url_video , 500 ,500));
											$item_class = "thumb-video youtube-fancy";
										}
										if(strstr($url_video,'vimeo.com')){
											$thumburl = array(wp_parse_thumbnail_vimeo(wp_parse_vimeo_link($url_video), 500, 500));	
											$item_class = "thumb-video vimeo-fancy";
										}
										$light_box_url = $url_video;
									}else{
										$thumb=get_post_thumbnail_id($post->ID);
										$thumburl=wp_get_attachment_image_src($thumb,'full');
										$item_class = "thumb-image";
										$light_box_url = $thumburl[0];
									}								
								?>
								<div class="image <?php echo $id_widget?>">
									<a class="thumbnail" href="<?php the_permalink(); ?>"><?php echo print_thumbnail($thumburl[0],true,$post_title,500,330); ?></a>
									<div class="icons">
										<div>
											<a class="zoom-gallery fancybox" title="<?php echo get_the_title(); ?>" rel="fancybox" href="<?php echo $light_box_url;?>"></a>
											<a class="link-gallery " title="<?php echo get_the_title();?>" href="<?php echo get_permalink();?>"></a>
										</div>
									</div>	
								</div>
								<div class="detail<?php if(!$thumb) echo ' noimage';?>">
									<p class="title"><h4 class="heading-title"><a  class="wpt_title" href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h4></p>
									<span class="author-time"><span class="author"><?php the_author(); ?></span><b>/</b><span class="time"><?php the_time('F d,Y'); ?></span><b>/</b><span class="comment-number"><?php comments_number( '0 Comments','1 Comment','% Comments'); ?></span></span>
								</div>							
							</li>
					<?php } ?>
					</ul>
				</div>
			</div>
			<div id="<?php echo $id_widget;?>_clone" style="display:none;" class="shortcode-recent-works flexslider">
			</div>
			
			<script type="text/javascript">
				jQuery(document).ready(function() {
					flex_carousel_slide('#<?php echo $id_widget;?>',<?php echo $show_items?>);
				});
			</script>
			<?php			
			$ret_html = ob_get_contents();
			ob_end_clean();
			//ob_end_flush();
		endif;
		wp_reset_query();
		return $ret_html;
	}
} 
add_shortcode('recent_works','recent_works_function');

?>
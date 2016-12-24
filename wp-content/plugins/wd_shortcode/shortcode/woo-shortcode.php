<?php
/**
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */

	if(!function_exists('wd_custom_product_function')){
		function wd_custom_product_function($atts,$content){
			extract(shortcode_atts(array(
				'id' => 0
				,'sku' => ''
				,'title' => ''
			),$atts));
			
			
			if (empty($atts)) return;
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			wp_reset_query(); 
			
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 1,
				'no_found_rows' => 1,
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);

			if(isset($atts['sku'])){
				$args['meta_query'][] = array(
					'key' => '_sku',
					'value' => $atts['sku'],
					'compare' => '='
				);
			}

			if(isset($atts['id'])){
				$args['p'] = $atts['id'];
			}

			ob_start();

			$products = new WP_Query( $args );

			if ( $products->have_posts() ) : ?>
				<div class="custom-product-shortcode">
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						
						<?php		
						//start product-content.Copy from core code
							
						global $product, $woocommerce_loop;
						$old_loop = $woocommerce_loop;
						// Store loop count we're currently on
						if ( empty( $woocommerce_loop['loop'] ) )
							$woocommerce_loop['loop'] = 0;

						// Store column count for displaying the grid
						if ( empty( $woocommerce_loop['columns'] ) )
							$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

						// Ensure visibility
						if ( ! $product->is_visible() )
							return;

						// Increase loop count
						$woocommerce_loop['loop']++;

						// Extra post classes
						$classes = array();
						if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
							$classes[] = 'first';
						if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
							$classes[] = 'last';
						?>
						<li <?php post_class( $classes ); ?>>

							<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

							<div class="product_thumbnail_wrapper">
								
								<?php woocommerce_template_loop_add_to_cart();?>
							
								<a href="<?php the_permalink(); ?>">

									<?php
										/**
										 * woocommerce_before_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_show_product_loop_sale_flash - 10
										 * @hooked woocommerce_template_loop_product_thumbnail - 10
										 */
										do_action( 'woocommerce_before_shop_loop_item_title' );
									?>

									<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' );
									?>

								</a>
							
							</div>
							
							<?php //do_action( 'woocommerce_after_shop_loop_item' ); ?>
							
							<div class="product-meta-wrapper">
								<h3 class="heading-title promotion-title"><?php echo $title; ?></h3>
								<h3 class="heading-title product-title"><a href="<?php echo get_permalink(); ?>"><?php the_title();?></a></h3>
								<?php
									wd_add_sku_to_product_list();
									woocommerce_template_loop_rating();
									woocommerce_template_loop_price();
								?>
							</div>
						</li>
						
						<?php //end of copy ?>
						
					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				</div>
			<?php endif;
			$woocommerce_loop = $old_loop;
			wp_reset_postdata();
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';
		}
	}
	add_shortcode('custom_product','wd_custom_product_function');
	
	
	
	if(!function_exists('wd_custom_products_function')){
		function wd_custom_products_function($atts,$content){
			extract(shortcode_atts(array(
				'ids' => 0
				,'skus' => ''
			),$atts));
			global $woocommerce_loop;

			if (empty($atts)) return;
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			wp_reset_query(); 

			extract(shortcode_atts(array(
				'columns' 	=> '4',
				'orderby'   => 'title',
				'order'     => 'asc'
				), $atts));

			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' 		=> '_visibility',
						'value' 	=> array('catalog', 'visible'),
						'compare' 	=> 'IN'
					)
				)
			);

			if(isset($atts['skus'])){
				$skus = explode(',', $atts['skus']);
				$skus = array_map('trim', $skus);
				$args['meta_query'][] = array(
					'key' 		=> '_sku',
					'value' 	=> $skus,
					'compare' 	=> 'IN'
				);
			}

			if(isset($atts['ids'])){
				$ids = explode(',', $atts['ids']);
				$ids = array_map('trim', $ids);
				$args['post__in'] = $ids;
			}

			ob_start();

			$products = new WP_Query( $args );

			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<div class="custom-products-shortcode">
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php woocommerce_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				</div>
			<?php endif;
			
			wp_reset_postdata();

			return '<div class="woocommerce">' . ob_get_clean() . '</div>';			
			
		}
	}	
	
	
	add_shortcode('custom_products','wd_custom_products_function');

	
	/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_featured_product_slider_function')){
		function wd_featured_product_slider_function($atts,$content){
			wp_reset_query(); 
			global $woocommerce_loop;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'product_cut' 		=> 1
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1	
				,'page_slider'		=> 0
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
					add_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_big_thumbnail', 5 );
				}
			}

			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_add_sku_to_product_list', 9 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );				
			if(!(int)$show_label)
				remove_action( 'wd_before_product_image', 'woocommerce_show_product_sale_flash', 10 );				
			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					),
					array(
						'key' => '_featured',
						'value' => 'yes'
					)
				)
			);

			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();
			
			$products = new WP_Query( $args );

			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[	
					jQuery(document).ready(function() {
						var check = 1;
						var column = <?php echo $columns;?>;
						<?php if( wp_is_mobile() ) : ?>
							check = 0;
							if(jQuery('body').innerWidth() > 767 ){
								column = <?php echo $columns;?>;
							} else {
								column = 1;
							}							
						<?php endif;?>
						// Using custom configuration
		//				alert(check + '___' + column);
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel({
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo !wp_is_mobile() ? 300 : 140 ;?>
								,height: 'auto'
								,visible: {
									min: 1
									,max: column
								}							
							}
							,direction			: "left"
							,responsive 		: true	
							,swipe				: { /*onMouse: true, */onTouch: true }	
							<?php if($product_cut != 0):?>
							,onCreate			: function( data ) {
													if(check == 1){
														if( data.items.length > 0 ){
															var this_ul = jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > .caroufredsel_wrapper").find("ul.products").eq(0);
															//console.log(this_ul.html());
															console.log(this_ul.children('li').eq(0).css('width'));
															console.log(this_ul.children('li').eq(0).width()/2);
															this_ul.css( 'margin-left','-'+  this_ul.children('li').eq(0).width()/2 +'px' );
														}
													}
												}
							<?php endif; ?>					
							,scroll				: 
													<?php if( !wp_is_mobile() ) : ?>
														{duration : 1000
														, pauseOnHover:true}
													<?php else :?>
														1
													<?php endif;?>
													//<?php if($page_slider):?>
													//,onAfter : function( data ) {
													//	var this_ul = jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner").find("ul.products").eq(0);
													//	this_ul.css( 'margin-left','-'+  this_ul.children('li').eq(0).width()/2 +'px' );
													//}
													<?php endif;?>
													
							,width				: '100%'
							,height				: '100%'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>		
							
						});	
					});
				//]]>		
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed

			add_action ('woocommerce_after_shop_loop_item','wd_add_sku_to_product_list',9);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );			
			add_action( 'wd_before_product_image', 'woocommerce_show_product_sale_flash', 10 );	

			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_big_thumbnail', 5 );			
			}
			add_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );			
			//end
			
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('featured_product_slider','wd_featured_product_slider_function');


	if(!function_exists('wd_featured_by_category_function')){
		function wd_featured_by_category_function($cat_slug = '',$per_page = 1){
			wp_reset_query(); 
			$args = array(
				'post_type'	=> 'product'
				,'post_status' => 'publish'
				,'ignore_sticky_posts'	=> 1
				,'posts_per_page' => $per_page
				,'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
					,array(
						'key' => '_featured',
						'value' => 'yes'
					)
				)
				,'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=> array( esc_attr($cat_slug) ),
						'field' 		=> 'slug',
						'operator' 		=> 'IN'
					)
				)
			);
			wp_reset_query(); 
			$products = new WP_Query( $args );
			if( $products->have_posts() ){
				global $post;
				$products->the_post();
				$product = get_product( $post->ID );
				return $product;
			}
			return NULL;
		}
	}
			
	
	
	

	if(!function_exists('wd_custom_products_category_function')){
		function wd_custom_products_category_function($atts,$content){
			global $woocommerce, $woocommerce_loop;
			if ( empty( $woocommerce )  ) return;
			extract( shortcode_atts( array(
				'per_page' 		=> '4'
				,'title'		=> ''
				,'orderby'   	=> 'title'
				,'order'     	=> 'desc'
				,'category'		=> ''
				,'show_upsell' 	=> 1
				,'show_image' 	=> 1
				,'show_title' 	=> 1
				,'show_sku' 	=> 1
				,'show_price'	=> 1
				,'show_rating' 	=> 1
				,'show_label' 	=> 1					
				), $atts ) );
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			
			if(!(int)$show_image)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 2 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_add_sku_to_product_list', 9 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );		
				
		
			if ( ! $category ) return;
			wp_reset_query(); 
			global $wd_featured_datas;
			$_featured_prod = wd_featured_by_category_function($category,1);

			if(isset($_featured_prod)){
				//$_featured_prod->get_upsells( );
				$wd_featured_datas = array(
					'id' => $_featured_prod->id
					,'show_upsell' => $show_upsell
					,'show_image' => $show_image
					,'show_title' => $show_title
					,'show_sku' => $show_sku
					,'show_price' => $show_price
					,'show_rating' => $show_rating
					,'show_label' => $show_label
					
				);
				$per_page = 4;
			}else{
				$wd_featured_datas = array(
					'id' => ''
					,'show_upsell' => $show_upsell
					,'show_image' => $show_image
					,'show_title' => $show_title
					,'show_sku' => $show_sku
					,'show_price' => $show_price
					,'show_rating' => $show_rating
					,'show_label' => $show_label
					
				);			
				$per_page = 5;
			}

			
			// Default ordering args
			$ordering_args = $woocommerce->query->get_catalog_ordering_args( $orderby, $order );

			$args = array(
				'post_type'				=> 'product'
				,'post__not_in' 		=> array($wd_featured_datas['id'])
				,'post_status' 			=> 'publish'
				,'ignore_sticky_posts'	=> 1
				,'orderby' 				=> $ordering_args['orderby']
				,'order' 				=> $ordering_args['order']
				,'posts_per_page' 		=> $per_page
				,'meta_query' 			=> array(
					array(
						'key' 			=> '_visibility'
						,'value' 		=> array('catalog', 'visible')
						,'compare' 		=> 'IN'
					)
				)
				,'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'product_cat'
						,'terms' 		=> array( esc_attr($category) )
						,'field' 		=> 'slug'
						,'operator' 		=> 'IN'
					)
				)
				
			);

			if ( isset( $ordering_args['meta_key'] ) ) {
				$args['meta_key'] = $ordering_args['meta_key'];
			}

			ob_start();

			$products = new WP_Query( $args );
			$woocommerce_loop['columns'] = 2;
			$_count = 0;
			
			if( strlen($title) <= 0 ){
				$_prod_cat = get_term_by('slug', esc_attr($category), 'product_cat');
				if( isset($_prod_cat) ){
					$title = $_prod_cat->name;
				}
			}
			
			if ( $products->have_posts() ) : ?>
			
			<div class="custom_category_shortcode">
			
			<?php
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );			
				add_action( 'woocommerce_before_shop_loop_item_title', 'wd_custom_product_thumbnail', 10 );
			?>
			
				<h3 class="heading-title custom-category-title"><?php //echo $title;?></h3>
					<?php 
						if( function_exists('woocommerce_product_loop_start') ){
							woocommerce_product_loop_start();
						}	
					?>

					<?php while ( $products->have_posts() ) : ?>

					<?php
						global $product;
						$products->the_post();
						if(!isset($_featured_prod) && $_count == 0){
							$wd_featured_datas['id'] = $product->id;
							get_template_part( 'content', 'product-featured' );
						}else{
							if( $_count == 0 ){
								get_template_part( 'content', 'product-featured' );
							}
							if( $_count % 2 == $per_page % 4 ){
								echo "<li>
										<div class='line-wrapper'>
											<ul>";
							}	
								if( function_exists('woocommerce_get_template_part') ){
									woocommerce_get_template_part( 'content', 'product' );
								}	
							if( $_count % 2 == ( ($per_page % 4) + 1 ) ){
								echo "		</ul>
										</div>
									</li>";
							}	
						}
						$_count++;
					?>
						
					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

			</div>	
				
			<?php endif;

			wp_reset_postdata();

			//add all the hook removed
			
			// add_action ('woocommerce_after_shop_loop_item','open_div_style',1);
			// add_action ('woocommerce_after_shop_loop_item','add_product_title',2);
			// add_action ('woocommerce_after_shop_loop_item','add_sku_to_product_list',3);
			// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5 );			
			
			// add_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );			
			// add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			//end			
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
		
		}
	}	
	add_shortcode('custom_products_category','wd_custom_products_category_function');




	function wd_order_by_rating_post_clauses( $args ) {

		global $wpdb;

		$args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

		$args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}	
	

	/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	product_tag : tag of prods
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_popular_product_slider_function')){
		function wd_popular_product_slider_function($atts,$content){
			global $woocommerce_loop, $woocommerce;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1				
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 2 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_add_sku_to_product_list', 9 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				
			
			wp_reset_query(); 
			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'desc',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
		
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

	  	add_filter( 'posts_clauses', 'wd_order_by_rating_post_clauses' );

		$products = new WP_Query( $args );

		remove_filter( 'posts_clauses', 'wd_order_by_rating_post_clauses' );

			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						// Using custom configuration
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel({
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
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
													duration : 1000
													, pauseOnHover:true
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
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						});	
					});
				//]]>		
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed

			add_action ('woocommerce_after_shop_loop_item','wd_add_sku_to_product_list',9);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );			
			add_action( 'wd_before_product_image', 'woocommerce_show_product_sale_flash', 10 );	

			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			add_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
			//end
			
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('popular_product_slider','wd_popular_product_slider_function');




	/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	product_tag : tag of prods
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_recent_product_slider_function')){
		function wd_recent_product_slider_function($atts,$content){
			global $woocommerce_loop, $woocommerce;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1				
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 2 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_add_sku_to_product_list', 9 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				

			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'orderby' => 'date',
				'order' => 'desc',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
		
			wp_reset_query(); 
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

			$products = new WP_Query( $args );

			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						// Using custom configuration
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel({
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
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
													duration : 1000
													, pauseOnHover:true
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
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						});	
					});
				//]]>		
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed

			add_action ('woocommerce_after_shop_loop_item','wd_add_sku_to_product_list',9);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );			
			add_action( 'wd_before_product_image', 'woocommerce_show_product_sale_flash', 10 );	

			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );			
			}
			remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			add_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );		
			//end
			
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('recent_product_slider','wd_recent_product_slider_function');




		/*
	*	columns : 3 or 4
	*	layout : small or big
	*	per_page : 4 to 12
	*	title : ""
	*	desc : ""
	*	product_tag : tag of prods
	*	show nav thumb : 1
	* 	show thumb : 1
	*	show title : 1
	* 	show sku : 1
	*	show price
	*	show label
	* 	item slide : 1
	*/
	

	
	if(!function_exists('wd_best_selling_product_slider_function')){
		function wd_best_selling_product_slider_function($atts,$content){
			global $woocommerce_loop, $woocommerce;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'layout' 			=> 'small'
				,'per_page' 		=> 8
				,'title' 			=> ''
				,'desc' 			=> ''
				,'product_tag' 		=> ''
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 1
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1				
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			
			if(!(int)$show_image){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
			}else{
				if( strcmp($layout,'big') == 0 ){
					remove_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
					remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
					add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 10 );
				}
			}
			if(!(int)$show_title)
				remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 2 );
			if(!(int)$show_sku)
				remove_action( 'woocommerce_after_shop_loop_item', 'wd_add_sku_to_product_list', 9 );
			if(!(int)$show_price)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6 );
			if(!(int)$show_rating)
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 5 );				
			if(!(int)$show_label)
				remove_action( 'woocommerce_before_shop_loop_item_title', 'add_label_to_product_list', 5 );				

			
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'order' => 'desc',		
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
		
			wp_reset_query(); 
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			
			ob_start();

			$products = new WP_Query( $args );

			$woocommerce_loop['columns'] = $columns;

			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'featured_product_slider_wrapper_'.rand(); ?>
				<div class="featured_product_slider_wrapper" id="<?php echo $_random_id;?>">
					<div class="featured_product_slider_wrapper_meta"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>{$title}</h3>";
							if(strlen(trim($desc)) >0)	
								echo "<p class='slider-desc-wrapper'>{$desc}</p>";
						?>
					</div>
					<div class="featured_product_slider_wrapper_inner">
					
						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>
						
						<?php woocommerce_product_loop_start(); ?>

							<?php while ( $products->have_posts() ) : $products->the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php if($show_nav):?>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						// Using custom configuration
						jQuery("#<?php echo $_random_id?> > .featured_product_slider_wrapper_inner > ul").carouFredSel({
							items 				: {
								/*width: 140
								,height: <?php echo strcmp($layout,'small') == 0 ? 240 : 650 ;?>*/
								width: <?php echo wp_is_mobile() ? 300 : 140 ;?>
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
													duration : 1000
													, pauseOnHover:true
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
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						});	
					});
				//]]>		
				</script>
				
			<?php endif;

			wp_reset_postdata();

			
			
			//add all the hook removed

			add_action ('woocommerce_after_shop_loop_item','wd_add_sku_to_product_list',9);
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );			
			add_action( 'wd_before_product_image', 'woocommerce_show_product_sale_flash', 10 );	

			if( (int)$show_image && strcmp($layout,'big') == 0 ){
				remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_big_thumbnail', 5 );			
				
			}
			remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );			
			add_action( 'woocommerce_after_shop_loop_item', 'wd_template_loop_product_thumbnail', 5 );
			//end
			
			
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';		
			
		}
	}		
	add_shortcode('best_selling_product_slider','wd_best_selling_product_slider_function');
	
	
	
	function remove_category_product_count( $input ){
		return '';
	}
	
	if(!function_exists('wd_product_categories_slider_function')){
		function wd_product_categories_slider_function($atts,$content){
			global $woocommerce_loop, $woocommerce;
			extract(shortcode_atts(array(
				'per_page' 				=> 12
				,'orderby' 				=> 'name'
				,'order'      			=> 'ASC'
				,'columns' 				=> 4
				,'title'				=> ''
				,'title_url'			=> ''
				,'show_product_count'	=> 'yes'
				,'hide_empty' 			=> 'yes'
				,'parent'     			=> ''	
				,'show_nav'				=> 'yes'
				,'show_icon_nav'		=> 'yes'
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			
			$show_product_count 	= wd_yn_2_bool($show_product_count);
			$hide_empty 			= wd_yn_2_bool($hide_empty);
			$show_nav 				= wd_yn_2_bool($show_nav);
			$show_icon_nav 			= wd_yn_2_bool($show_icon_nav);
			
			if( !$show_product_count ){
				add_filter('woocommerce_subcategory_count_html', 'remove_category_product_count',10,1);
			}
			
			if ( isset( $atts[ 'ids' ] ) ) {
				$ids = explode( ',', $atts[ 'ids' ] );
				$ids = array_map( 'trim', $ids );
			} else {
				$ids = array();
			}

			$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

			// get terms and workaround WP bug with parents/pad counts
			$args = array(
				'orderby'    => $orderby,
				'order'      => $order,
				'hide_empty' => $hide_empty,
				'include'    => $ids,
				'pad_counts' => true,
				'child_of'   => $parent
			);

			$product_categories = get_terms( 'product_cat', $args );

			if ( $parent !== "" )
				$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );

			if ( $per_page )
				$product_categories = array_slice( $product_categories, 0, $per_page );

			$woocommerce_loop['columns'] = $columns;

			ob_start();
			
			
	?>		
			<?php $_random_id = 'featured_categories_slider_wrapper_'.rand(); ?>
			
			<div class="featured_categories_slider_wrapper" id="<?php echo $_random_id;?>">
				<div class="featured_categories_slider_wrapper_inner">
				
					<?php 
					
						$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';

						if ( $product_categories ) {

							woocommerce_product_loop_start();

							foreach ( $product_categories as $category ) {

								woocommerce_get_template( 'content-product_cat.php', array(
									'category' => $category
								) );

							}

							woocommerce_product_loop_end();

						}

						woocommerce_reset_loop();
		
					?>
					
						<?php if($show_nav):?>
						<div class="slider_control">
							<a id="<?php echo $_random_id;?>_prev" class="prev" href="#">&lt;</a>
							<a id="<?php echo $_random_id;?>_next" class="next" href="#">&gt;</a>
						</div>
						<?php endif;?>		

						<?php if($show_icon_nav):?>
							<div id="<?php echo $_random_id;?>_pager" class="pager"></div>
						<?php endif;?>						
					
				</div>
			
				<?php if( strlen( trim($title) ) > 0 ):?>
					<?php if( strlen( trim($title_url) ) > 0 ) :?>
						<a href="<?php echo esc_url($title_url);?>" title="<?php echo esc_attr($title = sprintf( __( '%s','wpdance' ), $title )); ?>">
					<?php endif;?>
							<h3 class="heading_title category_slider_title"><?php echo esc_attr($title = sprintf( __( '%s','wpdance' ), $title )); ?></h3>
					<?php if( strlen( trim($title_url) ) > 0 ) :?>
						</a>
					<?php endif;?>					
				<?php endif;?>
			
			</div>
						
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						// Using custom configuration
						setTimeout(function(){
						var slide_data = 
						{
							items 				: {
								width: <?php echo wp_is_mobile() ? 400 : 240 ;?>
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
													duration : 1000
													, pauseOnHover:true
													}
													<?php else :?>
														1
													<?php endif;?>
							,width				: '100%'
							,height				: 'auto'
							,circular			: true
							,infinite			: true
							,auto				: false
							<?php if($show_nav):?>
							,prev				: '#<?php echo $_random_id;?>_prev'
							,next				: '#<?php echo $_random_id;?>_next'								
							<?php endif;?>
							<?php if($show_icon_nav):?>
							,pagination 		: '#<?php echo $_random_id;?>_pager'
							<?php endif;?>							
						};	
						
							jQuery("#<?php echo $_random_id?> > .featured_categories_slider_wrapper_inner > ul.products ").carouFredSel(slide_data);
						},1000);
						
					});
				//]]>
				</script>						
	<?php	
			if( !$show_product_count ){
				remove_filter('woocommerce_subcategory_count_html', 'remove_category_product_count',10,1);
			}
	
			return  ob_get_clean();
		}
	}	
	
	add_shortcode('product_categories_slider','wd_product_categories_slider_function');
	
	
	// Show jquery ui tabs
	if(!function_exists ('products_tabs_function')){
		function products_tabs_function($atts,$content){
			extract(shortcode_atts(array(
				'style'	=>	'default',
			),$atts));
			$id = 'multitabs_'.rand();
			$inside_id = $id.'_inside';
			$result = "<div class='tabbable tabs-{$style} container'  id='{$id}'>\n\t";
			
			$tabs_match = preg_match_all('/\[tab_item\s*?title="(.*?)"\](.*?)\[\/tab_item\]/ism',$content,$match);
			if( $tabs_match && is_array($match) && count($match) > 0 ){
				$_title_contents = '';
				$_tabs_contents = '';
				$_init_class_title = 'active';
				$_init_class_content = 'active in';
				for( $_count = 0 ; $_count < count($match[0]) ; $_count++ ){
					$_content_id = $inside_id.$_count;
					$_inside_content = do_shortcode($match[2][$_count]);
					$match[1][$_count] = strlen( $match[1][$_count] ) <= 0 ? 'Tab title' : $match[1][$_count];
					$_title_contents .= "\n\t\t\t<li class=\"{$_init_class_title}\"><a href=\"#{$_content_id}\" data-toggle=\"tab\">{$match[1][$_count]}</a></li>";
					$_tabs_contents .= "\n\t\t\t<div class=\"tab-pane fade {$_init_class_content}\" id=\"{$_content_id}\">{$_inside_content}</div>";
					$_init_class_title = $_init_class_content = '';
				}
				$_title_contents = "\n\t\t<ul class=\"nav nav-tabs span6\" id=\"{$inside_id}\">".$_title_contents."\n\t\t</ul>";
				$_tabs_contents = "\n\t\t<div class=\"tab-content span18\" id=\"{$inside_id}Content\">".$_tabs_contents."\n\t\t</div>";
			}
			$result .= $_title_contents.$_tabs_contents."\n\t</div>";
			
			return $result;
		}
	}
	add_shortcode('product_tabs','products_tabs_function');	
	

?>
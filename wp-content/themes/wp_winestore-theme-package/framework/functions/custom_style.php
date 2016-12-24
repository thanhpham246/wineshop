<?php
	function wd_toRGB($Hex){
		if (substr($Hex,0,1) == "#")
			$Hex = substr($Hex,1);
			
			

		$R = substr($Hex,0,2);
		$G = substr($Hex,2,2);
		$B = substr($Hex,4,2);

		$R = hexdec($R);
		$G = hexdec($G);
		$B = hexdec($B);

		$RGB['R'] = $R;
		$RGB['G'] = $G;
		$RGB['B'] = $B;

		return $RGB;
	}


	add_action('wp_head', 'wd_custom_style_inline_script');
	function wd_save_custom_style( $save_datas = array() ){
		
		//wrong input type
		if( !is_array($save_datas) ){
			return -1;
		}
		$cache_file = THEME_CACHE.'custom.less';
		$enable_custom_font = $save_datas['enable_custom_font'];
		$enable_custom_color = $save_datas['enable_custom_color'];
		
		if( strlen($save_datas['body_font_name']) <= 0 || (int)$save_datas['body_font_name'] == -1 )
			$save_datas['body_font_name'] = "Open Sans";
		if( strlen($save_datas['heading_font_name']) <= 0 || (int)$save_datas['heading_font_name'] == -1 )
			$save_datas['heading_font_name'] = "Open Sans";
		if( strlen($save_datas['menu_font_name']) <= 0 || (int)$save_datas['menu_font_name'] == -1 )
			$save_datas['menu_font_name'] = "Open Sans";			
		if( strlen($save_datas['sub_menu_font_name']) <= 0 || (int)$save_datas['sub_menu_font_name'] == -1 )
			$save_datas['sub_menu_font_name'] = "Open Sans";	
		try{		
			print_r($save_datas);
			ob_start();
			?>
			
			<?php 
				// $custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
				// $custom_style_config_arr = unserialize($custom_style_config);			
				// var_dump($custom_style_config_arr);
				//print_r($save_datas);
			?>
			
			// Font
			@body_font:<?php echo $save_datas['body_font_name'];?>;
			@body_font_weight:<?php echo $save_datas['body_font_weight'];?>;
			@body_font_style:<?php echo $save_datas['body_font_style'];?>;

			@font_menu:<?php echo $save_datas['menu_font_name'];?>;
			@menu_font_weight:<?php echo $save_datas['menu_font_weight'];?>;
			@menu_font_style:<?php echo $save_datas['menu_font_style'];?>;
			
			@font_submenu:<?php echo $save_datas['sub_menu_font_name'];?>;
			@sub_menu_font_weight:<?php echo $save_datas['sub_menu_font_weight'];?>;
			@sub_menu_font_style:<?php echo $save_datas['sub_menu_font_style'];?>;		

			@heading_font:<?php echo $save_datas['heading_font_name'];?>;
			@heading_font_weight:<?php echo $save_datas['heading_font_weight'];?>;
			@heading_font_style:<?php echo $save_datas['heading_font_style'];?>;

			// Primary
			@primary_color:<?php echo $save_datas['primary_color'];?>;
			@primary_second_color:<?php echo $save_datas['primary_second_color'];?>;
			@primary_background_color:<?php echo $save_datas['primary_background_color'];?>;
			@primary_heading_color:<?php echo $save_datas['heading_color'];?>;
			@primary_text_color:<?php echo $save_datas['primary_text_color'];?>;
			@primary_link_color:<?php echo $save_datas['primary_link_color'];?>;
			@primary_border_color:<?php echo $save_datas['border_color_primary'];?>;
			@button_primary_background:<?php echo $save_datas['button_background'];?>;
			@button_primary_text_color:<?php echo $save_datas['button_text_color'];?>;
			@button_primary_border_color:<?php echo $save_datas['button_border_color'];?>;
			
			@button_second_background:<?php echo $save_datas['button_second_background'];?>;
			@button_second_text_color:<?php echo $save_datas['button_second_text_color'];?>;	
			@button_second_border:<?php echo $save_datas['border_second_button'];?>;

			@tab_backgound_color:<?php echo $save_datas['background_tab'];?>;	
			@tab_text_color:<?php echo $save_datas['tab_text_color'];?>;	
			@tab_border_color:<?php echo $save_datas['tab_border_color'] = strlen($save_datas['tab_border_color']) > 0 ? $save_datas['tab_border_color'] : "null";?>;
			@tab_text_color_active:<?php echo $save_datas['tab_text_color_active'];?>;
			@tab_background_color_active:<?php echo $save_datas['tab_background_color_active'];?>;
			@tab_border_color_active:<?php echo $save_datas['tab_border_color_active'];?>;
			@accordion_text_color:<?php echo $save_datas['accordion_text_color'];?>;
			@accordion_background_color:<?php echo $save_datas['accordion_background_color'];?>;
			// Header
			
			@header_menu_background_color:<?php echo $save_datas['header_menu_background'];?>;
			@header_submenu_link_text_color:<?php echo $save_datas['header_submenu_link_text_color'] = strlen($save_datas['header_submenu_link_text_color']) > 0 ? $save_datas['header_submenu_link_text_color'] : "null";?>;
			@header_top_text_color:<?php echo $save_datas['header_top_text_color'];?>;
			@header_bottom_background:<?php echo $save_datas['header_bottom_background'];?>;
			@header_bottom_text_color:<?php echo $save_datas['header_bottom_text_color'];?>;
			@header_border_bottom_color:<?php echo $save_datas['header_border_bottom_color'];?>;
			@header_menu_text_color:<?php echo $save_datas['header_menu_text_color'];?>;
			@header_submenu_text_color:<?php echo $save_datas['header_submenu_text_color'];?>;
			@header_submenu_border_color:<?php echo $save_datas['header_submenu_border_color'];?>;
			@header_submenu_background_hover:<?php echo $save_datas['header_submenu_background_hover'];?>;
			@header_submenu_background_color:<?php echo $save_datas['header_submenu_background_color'];?>;
			
			
			
			
			// Footer
			@footer_first_area_backgound:<?php echo $save_datas['footer_first_area_background_color'];?>;
			@footer_border_color:<?php echo $save_datas['footer_border_color'];?>;
			@footer_second_area_backgound:<?php echo $save_datas['footer_second_area_background_color'];?>;
			@footer_first_area_text_color:<?php echo $save_datas['footer_first_area_text_color'];?>;
			@footer_first_area_heading_color:<?php echo $save_datas['footer_first_area_heading_color'];?>;
			@footer_second_area_text_color:<?php echo $save_datas['footer_second_area_text_color'];?>;
			@footer_second_area_heading_color:<?php echo $save_datas['footer_second_area_heading_color'];?>;
			@footer_third_area_text_color:<?php echo $save_datas['footer_thrid_area_text_color'];?>;
			@footer_third_area_backgound:<?php echo $save_datas['footer_thrid_area_background'];?>;

			
			// Sidebar
			@sidebar_text_color: <?php echo $save_datas['sidebar_text_color'];?>;
			@sidebar_border_color: <?php echo $save_datas['sidebar_border_color'];?>;
			@sidebar_link_color: <?php echo $save_datas['sidebar_link_color'];?>;
			@icon_color:<?php echo $save_datas['icon_color'];?>;
			@filter:<?php echo $save_datas['filter'];?>;
			@sidebar_heading_color:<?php echo $save_datas['sidebar_heading_color'];?>;

			// Especial
			@feedback_background:<?php echo $save_datas['feedback_background'];?>;
			@totop_background:<?php echo $save_datas['totop_background'];?>;
			@feedback_color_hover:<?php echo $save_datas['feedback_color_hover'];?>;
			//@sale_background_color:<?php echo $save_datas['sale_background_color'];?>;

			@rating_color:<?php echo $save_datas['rating_color'];?>; 
			 
			@label_text_color:<?php echo $save_datas['label_text_color'];?>; 

			// Functions
			.gradient(@start, @end) {
				background: mix(@start, @end, 50%);
				filter: ~"progid:DXImageTransform.Microsoft.gradient(startColorStr="@start~", EndColorStr="@end~")";
				background: -webkit-gradient(linear, left top, left bottom, from(@start), to(@end));
				background: -webkit-linear-gradient(@start, @end);
				background: -moz-linear-gradient(top, @start, @end);
				background: -ms-linear-gradient(@start, @end);
				background: -o-linear-gradient(@start, @end);
				background: linear-gradient(@start, @end);
				zoom: 1;
			}
				.home #container-main .main-content .heading-title-block h1,.blog-template .content-inner h2,#container-main .main-content .woocommerce h2.my-address-title,h2.recent-order-title
					{
					color:(@primary_color + #2a2a2a)
					}
				

				.widget_pages ul.children li:hover > a,.widget_archive ul.children li:hover> a, .widget_categories ul.children li:hover > a,.widget_meta ul.children li:hover > a, .widget_nav_menu ul.children li:hover > a,.widget_nav_menu ul li:hover > a,.widget_pages ul.children li:hover > a,.widget_pages ul.children li:hover > a,.widget_product_categories ul.children li > a:hover,.widget_product_categories ul.children li > a
					{
					color:(@primary_color + #505050)
					}
				.home #container-main.span24 .main-content h1{color:@primary_color}
				/*==============================================================*/
				/*                     ^^ CUSTOM TEXT HOVER ^^                   */
				/*==============================================================*/
				.header-top-left .account_links a:hover, .header-top-right .quick_access_menu .top-menu ul#menu-header-menu li a:hover, .header-top-right .quick_access_menu .top-menu ul#menu-header-menu li:hover a, .cart_dropdown ul.cart_list li .cart_item_wrapper a:hover, .alphabet-products ul li a:hover, .widget_recent_comments_custom .comment-meta a:hover, .widget_customrecent ul li .detail a:hover,#right-sidebar .widget_customrecent ul li .detail a:hover, .ew-video ul li a:hover, #left-sidebar .widget_popular ul li .detail a:hover, #right-sidebar .widget_popular ul li .detail a:hover, #content .woocommerce ul.cart_list li a:hover, #content .woocommerce-page ul.cart_list li a:hover, #content .woocommerce ul.product_list_widget li a:hover, #content .woocommerce-page ul.product_list_widget li a:hover, .widget_product_tag_cloud div.tagcloud a:hover, .widget_recent_entries ul li a:hover, .widget_recent_comments ul li a.url:hover, body .woocommerce ul.products li.product .heading-title:hover, .summary.entry-summary .product_meta .posted_in a:hover, #related_products ul.products li.product > a:hover > h3, body .woocommerce div.product div.products-tabs-wrapper .tab-content #upsell_products .upsell_wrapper ul li > a:hover > h3, body.woocommerce div.product div.products-tabs-wrapper .tab-content #upsell_products .upsell_wrapper ul li > a:hover > h3, body.woocommerce div.product div.products-tabs-wrapper .tab-content #related_products ul.products li.product > a:hover > h3, #container .products.grid a:hover h3, #container .products.list a:hover h3, body .woocommerce table.shop_table.my_account_orders tbody td.order-actions a:hover, .addresses a.edit:hover, .myaccount_user a:hover, body .woocommerce table.cart td.product-name a:hover, body .woocommerce-page table.cart td.product-name a:hover, body .woocommerce #content table.cart td.product-name a:hover, .woocommerce #content table.cart td.product-name a:hover, ul.list-posts > li .post-infors-wrapper a.read-more:hover, ul.list-posts > li .post-infors-wrapper span.author a:hover, #author-description span.view-all-author-posts a:hover, .single-blog .related ul li div > a.title:hover, #container-main .featured_categories_slider_wrapper a:hover .category_slider_title, .products .product-category a:hover h3,.widget_recent_post_thumbnail ul li .entry-title a:hover,.widget_multitab .tab-content ul li div.content a:hover,html .woocommerce ul.products li.product .price ins, html .woocommerce-page ul.products li.product .price ins, ins .amount,body .woocommerce ul.products li.product .heading-title a:hover,body.woocommerce ul.products li.product h3.heading-title a:hover, body.woocommerce-page ul.products li.product h3.heading-title a:hover,html .woocommerce form .form-row .required, html .woocommerce-page form .form-row .required,body .woocommerce ul.cart_list li ins span.amount, body .woocommerce ul.product_list_widget li ins span.amount, body .woocommerce-page ul.cart_list li ins span.amount, body .woocommerce-page ul.product_list_widget li ins span.amount,ul.archive-product-subcategories > li.product a:hover h3,ul.archive-product-subcategories > li.product a:hover h3 mark,#container-main .featured_categories_slider_wrapper .div-product-category h3 a:hover,body.woocommerce ul.products li.product h3.heading-title span:hover, body.woocommerce-page ul.products li.product h3.heading-title span:hover,.tab-content ul li h3 .wd_product_title:hover
					{
					color:@primary_second_color;
					}
				#header .nav ul.menu > li > a> span.menu-desc-lv0
					{
						color:(@header_menu_text_color + #808080);
					}
				/*#header .nav ul.menu > li > a:hover,#header .nav ul.menu > li:hover > a,#header .nav ul.menu > li.current-menu-item > a*/#header .nav ul.menu > li.menu-item-level0 > a:hover,#header .nav ul.menu > li.menu-item-level0:hover > a,#header .nav ul.menu > li.current-menu-item > a
					{
					background:@primary_color;
					}
				#header .nav ul.menu > li.menu-item-level0:hover,#header .nav ul.menu > li.current-menu-item {border-color:@primary_color}
				#header .nav ul.menu > li a:hover > span.menu-label-level-0, #header .nav ul.menu > li:hover a > span.menu-label-level-0,#header .nav ul.menu li.wd-fly-menu.current-menu-item > a,#header .nav ul.menu > li:hover > a > span,#header .nav ul.menu > li.current-menu-item > a > span
					{
					color:@button_primary_text_color;
					}
				#header .nav ul.menu > li > a:hover > span.menu-label-level-0,#header .nav ul.menu > li.current-menu-item > a > span,#header .nav ul.menu > li:hover > a > span
					{
					color:@button_primary_text_color;
					}
				@media 
					only screen and (max-width-device-width: 480px),
					only screen and (max-width: 480px){
						#header .nav > .main-menu > ul.menu > li:hover > a > span.menu-label-level-0
						{
							color:@header_menu_text_color!important;
						}
						#header .nav > .main-menu > ul.menu > li:hover > a
						{
							border-color:@header_submenu_border_color!important;
							background-color:@header_submenu_background_hover!important;
						}
					}
				@media 
					only screen and (max-width-device-width: 480px),
					only screen and (max-width: 480px){
					 #header .nav > .main-menu > ul.menu > li.current-menu-item > a > span.menu-label-level-0
						{
						color:@button_primary_text_color!important;
						}
					#header .nav > .main-menu > ul.menu > li.current-menu-item > a{background:@primary_color!important;}
					}
				/*==============================================================*/
				/*                     ^^ CUSTOM FONT ^^                        */
				/*==============================================================*/
			
				body, input, button, select, textarea, label, code, strong
					{
						font-family:@body_font;
						font-style:@body_font_style;
						font-weight:@body_font_weight;
					}
				.home #container-main.span24 .main-content h1,body .woocommerce ul.products li.product span.amount,.woocommerce-page ul.products li.product .amount ,.feature .feature_content,.cart_dropdown .dropdown_foooter .total span.amount,.amount,#footer #footer-first-area  .second-footer-widget-area-4 ul.xoxo > .textwidget > .one_sixth > h3,.cart_dropdown ul.cart_list li .cart_item_wrapper .quantity .amount,.shortcode_wd_banner h3.banner-title.has_label,.shortcode_wd_banner h3.banner-title ,.shortcode_wd_banner h4.banner-title,#container-main .featured_categories_slider_wrapper .category_slider_title, .products .product-category h3,.widget_recent_post_thumbnail ul li .entry-title a,.tabs-comments-list blockquote,.widget_recent_comments_custom blockquote,.background-code pre,body .woocommerce .shop_table.order_details thead th ,body .woocommerce .col2-set.addresses p,.cart-collaterals .cart_totals tr.order-total span.amount ,
				.woocommerce .featured_product_slider_wrapper ul.products li.product .amount,.woocommerce .featured_product_slider_wrapper ul.products li.product .amount span
					{
						font-family:@body_font;
						font-style:@body_font_style;
						font-weight:@body_font_weight;
					}	
				#header .nav ul.menu > li > a,#header .nav ul.menu > li > a > span.menu-desc-lv0,.header-top-right a,.header-top-left .wellcome_message, .header-top-left .account_links,.header-top-right .quick_access_menu .top-menu ul#menu-header-menu li > a,#header .nav .one_sixth > h3,#header .nav ul.menu > li > a > span.menu-label-level-1,#header .nav ul.menu > li .one_sixth > h3,.one_third > h3,#header .nav ul.menu > li.columns-2 > ul.sub-menu > li > a > span:first-child
					{
						font-family:@font_menu;
						font-style:@menu_font_style;
						font-weight:@menu_font_weight;
					}
				#header .nav ul.menu > li.wd-fly-menu li a,#header .nav ul.menu > li.wd-mega-menu li a,#header .nav ul.menu li p,#header .nav ul.sub-menu li a > span
					{
						font-family:@font_submenu;
						font-style:@sub_menu_font_style;
						font-weight:@sub_menu_font_weight;
						
					}

				h1.heading-title.page-title,h1,h2,h3,h4,h5,h6,.heading-title, .shortcode_wd_banner h3.banner-title, .shortcode_wd_banner h4,
				.heading-title-block h1, .heading-title-block h2, .heading-title-block h3, .heading-title-block h4, .heading-title-block h5, .heading-title-block h6, .heading-title-block h3 > a,.woocommerce ul.products li.product > a .heading-title,.shortcode_wd_banner h4,.products .product-category h3,.widget_multitab ul.nav-tabs li a,.sitemap-content > div h4, .archive-content > div h4,.sitemap-content > div h4.heading-title, .archive-content > div h4.heading-title,body .woocommerce .col2-set.addresses .title h3,
				.coupon_wrapper label
					{
						font-family:@heading_font;
						font-style:@heading_font_style;
						font-weight:@heading_font_weight;

					}
					
				
				.left-sidebar-content h3.widget-title, .right-sidebar-content h3.widget-title,.left-sidebar-content h3.widget-title, .right-sidebar-content h3.widget-title, .widget_multitab ul.nav-tabs,.widget_customrecent h3.widget-title,.widget_multitab ul.nav-tabs li a,.left-sidebar-content h3.widget-title, .right-sidebar-content h3.widget-title,.left-sidebar-content h3.widget-title a, .right-sidebar-content h3.widget-title a{color:@sidebar_heading_color}
				/*==============================================================*/
				/*                    ^^ TAB  ^^                                */
				/*==============================================================*/
				/*#accordion-checkout-details .accordion-heading > a h3,#accordion-checkout-details .accordion-heading > a.collapsed:hover h3,body .woocommerce .cart-collaterals .shipping_calculator h2,body .woocommerce-page .cart-collaterals .shipping_calculator h2,body .woocommerce .cart-collaterals .shipping_calculator h2 a,body .woocommerce-page .cart-collaterals .shipping_calculator h2 a,.coupon_wrapper label,body .woocommerce .cart-collaterals .cart_totals h2,body .woocommerce-page .cart-collaterals .cart_totals h2 ,body .woocommerce .cart-collaterals .cross-sells > h2,body .woocommerce-page .cart-collaterals .cross-sells > h2,body.woocommerce div.product div.products-tabs-wrapper  .nav > li > a:hover h2,body.woocommerce div.product div.products-tabs-wrapper  .nav > li.active > a h2,html .woocommerce .cart-actions input.wd_update_cart
					{
					background-color:@primary_color!important;
					color:(@primary_color + #ffffff)!important; 
					border-color:@primary_color!important;
					}*/
				body.woocommerce div.product .woocommerce-tabs ul.tabs li.active, body.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a ,
				body.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, body.woocommerce-page div.product .woocommerce-tabs ul.tabs li a:hover, body.woocommerce #content div.product .woocommerce-tabs ul.tabs li a:hover, body.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a:hover
				{
					background-color:@primary_color!important;
					color:(@primary_color + #ffffff)!important; 
					border-color:@primary_color!important;
					}
					
				body .woocommerce .cart-collaterals .shipping_calculator h2,body .woocommerce-page .cart-collaterals .shipping_calculator h2 ,body .woocommerce .cart-collaterals .shipping_calculator  a,body .woocommerce-page .cart-collaterals .shipping_calculator  a,.coupon_wrapper label,body .woocommerce .cart-collaterals .cart_totals h2,body .woocommerce-page .cart-collaterals .cart_totals ,body .woocommerce .cart-collaterals .cross-sells h2 ,body .woocommerce-page .cart-collaterals .cross-sells ,body.woocommerce div.product div.products-tabs-wrapper  .nav > li > a:hover ,body.woocommerce div.product div.products-tabs-wrapper  .nav > li.active > a ,html .woocommerce .cart-actions input.wd_update_cart
					{
					background-color:@primary_color!important;
					color:(@primary_color + #ffffff)!important; 
					border-color:@primary_color!important;
					}	
					
				
				
				[id^=multitabs] .nav-tabs 
					{
					border-color:@tab_border_color;
					}
			
				.tabs-default[id^="multitabs"] .nav-tabs li a{	color:@tab_text_color;}
				[id^=multitabs].tabs-right .nav-tabs li.active a,[id^=multitabs].tabs-right .nav-tabs li a:hover ,.tabs-default[id^="multitabs"] .nav-tabs li.active a, .tabs-default[id^="multitabs"] .nav-tabs li a:hover,.tabs-left[id^="multitabs"] .nav-tabs li.active a, .tabs-left[id^="multitabs"] .nav-tabs li a:hover
					{
					background:@tab_background_color_active;
					color:@tab_text_color_active!important;
					border-color:@tab_border_color_active;
					}
				
				.tabbable.tabs-left.product .nav-tabs li,.tabbable.tabs-left[id^="multitabs"] .nav-tabs li,.tabbable.tabs-right[id^="multitabs"] .nav-tabs li,.tabs-left[id^="multitabs"] > .nav-tabs > li > a,.tabs-right[id^="multitabs"] > .nav-tabs > li > a,.tabs-default[id^="multitabs"] .nav-tabs li a
					{
					background:@tab_backgound_color;
					border-bottom-color:(@tab_border_color + #343434); 
					color:@tab_text_color;
					}
				 .tabbable.tabs-left .nav-tabs li.active
					{
					background:@tab_background_color_active;
					color:@tab_text_color_active;
					}
				[id^=multitabs].tabbable.tabs-right .nav-tabs li,.tabbable.tabs-left[id^="multitabs"] .nav-tabs li {border-color:@tab_border_color}
				
				/*==============================================================*/
				/*                     HEADER CUSTOM                            */
				/*==============================================================*/

				/* HEADER TOP */
				.header-top-right .quick_access_menu .top-menu ul#menu-header-menu li > a,
				.header-top-left .wellcome_message,
				.header-top-left .wellcome_message, .header-top-left .account_links,.header-top-left .account_links a,#header-search .products-search div .search-input,.header-top-right .quick_access_menu .top-menu ul#menu-header-menu li ul.sub-menu li a,#header-search #searchform  div.bg_search_1 .search-input
				{
					color:@header_top_text_color
				}

				/* HEADER BOTTOM */
				.header-bottom .container,.top-page #crumbs,#header-search .products-search div .search-input,#header-search .products-search div,#header-search #searchform  div.bg_search_1,.box #header,.box .top-page
				{
				 background:@header_bottom_background;
				}
				#header .nav ul.menu > li.wd-mega-menu li a,#header .nav ul.menu > li a > span{color:@header_submenu_link_text_color;}
				/* SUB MENU LEVEL 01*/
				@media 
				only screen and (max-device-width: 767px),
				only screen and (max-width: 767px){
					body #header .nav ul.menu > li.wd-fly-menu  > a{border-color:@header_submenu_border_color; background-color:@header_submenu_background_hover;}	
				}
				@media 
				only screen and (max-width-device-width: 767px),
				only screen and (max-width: 767px){
				
					#header .nav ul.menu > li.menu-item-level0 > a,
					#header .nav ul.menu > li.menu-item-level0 > a,
					#header .nav ul.menu > li.current-menu-item > a,
					#header .nav ul.menu > li.menu-item-level0 > a:hover,
					#header .nav ul.menu > li.menu-item-level0:hover > a{background-color:@header_submenu_background_hover;border-color:@header_submenu_border_color;}
					body #header .nav ul#menu-main-menu > li.wd-fly-menu > ul.sub-menu{border-color:@header_submenu_border_color!important;}
				}
				#header .nav ul.menu > li > a, #header .nav > div > ul > li > a,#header .nav ul.menu > li > a > span/*, #header .nav ul.menu > li.wd-fly-menu li a*/
					{
					color:@header_menu_text_color;
					}

				body #header .nav ul.menu > li.wd-fly-menu > ul.sub-menu,#header .nav ul.menu > li.wd-mega-menu-sidebar.columns-2 > ul.sub-menu,#header .nav ul.menu > li.wd-fly-menu > ul.sub-menu, #header .nav ul.menu > li.wd-fly-menu > ul.sub-menu > li:first-child > ul.sub-menu, #header .nav ul.menu > li > ul.sub-menu > li.border-top > a,#header .nav ul.menu > li > ul.sub-menu,#header .nav ul.menu > li.wd-mega-menu.columns-2 > ul.sub-menu,.header-top-right .quick_access_menu .top-menu ul#menu-header-menu li > ul.sub-menu
					{
					border-color:@header_submenu_border_color!important;
					}
				
				.one_sixth > p, .one_sixth a, .one_sixth > h3, .textwidget > ul > li > p, .sub-menu .textwidget a.shop-all-menu,#header .nav ul.menu > li .one_third > .one-center p,#header .nav ul.menu > li .one_third,#header .nav .one_sixth > h3, .one_third > h3,#header .nav ul.menu > li.columns-2 > ul.sub-menu > li > a > span:first-child
					{
					color:@header_submenu_text_color;
					}
				#header .nav ul.menu > li > ul.sub-menu:before,.header-top-right .quick_access_menu .top-menu ul#menu-header-menu li ul.sub-menu,.shopping-cart .cart_dropdown,#header .nav ul.menu > li ul.sub-menu:before
					{
					background:@header_submenu_background_color;
					}
				#header .nav ul.menu > li.wd-fly-menu li:hover > a, #header .nav ul.menu li.wd-fly-menu li.current-menu-item > a,body .header-top-right .quick_access_menu .top-menu ul#menu-header-menu li ul.sub-menu li:hover
					{
						background:@header_submenu_background_hover;
					}
					
				.logo.heading-title a:hover
					{
						color:@header_submenu_background_hover;
					}

				/* CART */
				.shopping-cart span#cart_size_value_head
					{
					color:(@header_submenu_text_color + #dfdfdf);		//#fff
					}
				.shopping-cart a:hover span#cart_size_value_head
					{
					background-color:(@primary_color - #d70000)
					}
				.shopping-cart span#cart_size_value_head
					{
					background-color:@primary_color;
					}
				
				.cart_dropdown .dropdown_foooter .buttons .button_shopping_cart,.shopping-cart span,.cart_dropdown .dropdown_foooter .total,.cart_dropdown .dropdown_foooter .total strong,.shopping-cart a.cart_size:before,.shopping-cart a.cart_size:after,.feature .feature_content p,body .woocommerce form.login label,body .woocommerce form.register label,ul.xoxo > li.widget-container > div > div > p,.shortcode-recent-blogs > li .detail p.excerpt,.widget_twitterupdate ul li.status-item .tweet-content,.widget_multitab .tab-content ul li div.content span,.widget_customrecent ul li .detail p, .widget_customrecent ul li .detail span,html .woocommerce .woocommerce-result-count, html .woocommerce-page .woocommerce-result-count,#container .products.list .product-meta-wrapper .gridlist-buttonwrap .description,.cart_dropdown .dropdown_foooter,body.woocommerce div.product p.stock.in-stock, body.woocommerce-page div.product p.stock.in-stock, body.woocommerce #content div.product p.stock.in-stock, body.woocommerce-page #content div.product p.stock.in-stock,.summary.entry-summary .product_sku_label,.summary.entry-summary .product_meta .posted_in,body.woocommerce div.product .woocommerce-tabs .panel, body.woocommerce-page div.product .woocommerce-tabs .panel, body.woocommerce #content div.product .woocommerce-tabs .panel, body.woocommerce-page #content div.product .woocommerce-tabs .panel,.woocommerce .social_sharing h6.title-social, .woocommerce-page .social_sharing h6.title-social, .woocommerce .social_sharing p.content-social-des, .woocommerce-page .social_sharing p.content-social-des,body form.checkout #payment label,body form.checkout #order_review table.shop_table tfoot td label,.summary.entry-summary .description,body.woocommerce.single-product #main_content div.product form.cart tr td label,body.woocommerce.single-product #main_content div.product form.cart tr td select,.summary.entry-summary .product_meta .tagged_as
					{
					color:@primary_color; // #000
					}
				/*body #accordion-checkout-details .accordion-heading > a.accordion-toggle.collapsed h3
					{
					color:@primary_color!important;
					}*/
				.cart_dropdown .dropdown_foooter .total span.amount{color:(@primary_color + #010101)}
				.cart_dropdown .dropdown_foooter .buttons .button_checkout
					{
					color:(@primary_color - #ffffff); // #fff
					}
				.cart_dropdown .dropdown_foooter .buttons .button_checkout
					{
					background:@primary_color;
					}
				.cart_dropdown .dropdown_foooter .buttons .button_checkout:hover,.cart_dropdown .dropdown_foooter .buttons .button_shopping_cart:hover
					{
					background:@primary_second_color;
					}
				/*==============================================================*/
				/*                     HEADER FOOTER                            */
				/*==============================================================*/
				#footer  .wd_block_first {background:@footer_first_area_backgound}
				#footer  .wd_block_second{background:@footer_second_area_backgound}
				#footer  .wd_block_third {background:@footer_third_area_backgound}
				#footer-first-area > div{border-color:@footer_first_area_text_color;}
				#footer-second-area > div > div{border-color:@footer_second_area_text_color;}
				#footer > .container > .container,#copy-right,#footer  .wd_block_first #footer-first-area{border-color:@footer_border_color}
				#footer #footer-second-area .xoxo a{color:@footer_second_area_text_color;}
				#footer #footer-second-area .xoxo a{color:@footer_second_area_text_color;}
				#footer #footer-second-area  h3.widget-title,#footer #footer-second-area div.textwidget h3{color:@footer_second_area_heading_color;}
				/*#footer #footer-first-area .xoxo a{color:@footer_first_area_text_color;}*/
				#footer #footer-first-area .xoxo a:hover,#footer #footer-first-area .xoxo a:focus,#footer #footer-second-area .xoxo a:hover,#footer #footer-second-area .xoxo a:focus{color:@primary_second_color}
				#footer #footer-first-area  h3.widget-title,#footer #footer-first-area  h3.widget-title a{color:@footer_first_area_heading_color;}
				#footer  .wd_block_first  #footer-first-area:before,#footer  .wd_block_second  #footer-second-area:before,#footer #footer-first-area .xoxo a img:hover{border-color:@footer_border_color}
				#footer .widget_customrecent ul li .detail .entry-meta span.entry-date{color:(@footer_second_area_text_color + #ffffff)} 
				#copy-right:before{background:@footer_border_color}
				#copy-right, #copy-right a{color:@footer_third_area_text_color}
				/*==============================================================*/
				/*                     BUTTON CUSTOM                            */
				/*==============================================================*/

				html .woocommerce a.button, html .woocommerce button.button, html .woocommerce input.button, html .woocommerce #respond input#submit, html .woocommerce #content input.button, html .woocommerce-page a.button, html .woocommerce-page button.button, html .woocommerce-page input.button, html .woocommerce-page #respond input#submit, html .woocommerce-page #content input.button,body .btn.btn-default,
				.widget_product_search #searchform #searchsubmit, body .btn.btn-default, form.wpcf7-form input[type^=submit],body form.checkout #payment #place_order, input[type^=submit],
				body .woocommerce a.button:hover,body .woocommerce button.button:hover,body .woocommerce input.button:hover,body .woocommerce #respond input#submit:hover,body .woocommerce #content input.button:hover,body .woocommerce-page a.button:hover,body .woocommerce-page button.button:hover,body .woocommerce-page input.button:hover,body .woocommerce-page #respond input#submit:hover,body .woocommerce-page #content input.button:hover, .woocommerce ul.products li.product div.product-media-wrapper > a.button, .woocommerce ul.products li.product div.product-media-wrapper > a.button:hover,.summary.entry-summary .cart button.single_add_to_cart_button,html .woocommerce a.button.alt,html .woocommerce-page a.button.alt,html .woocommerce button.button.alt,html .woocommerce-page button.button.alt,html .woocommerce input.button.alt,html .woocommerce-page input.button.alt,html .woocommerce #respond input#submit.alt,html .woocommerce-page #respond input#submit.alt,html .woocommerce #content input.button.alt,html .woocommerce-page #content input.button.alt,.woocommerce a.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page #content input.button.alt:hover,.woocommerce a.button:hover, .woocommerce-page a.button:hover, .woocommerce button.button:hover, .woocommerce-page button.button:hover, .woocommerce input.button:hover, .woocommerce-page input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce-page #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page #content input.button:hover,body.woocommerce.single-product #main_content div.product form.cart tr td a.reset_variations,.cart-actions form input.checkout-button,.cart-actions form input.checkout-button:hover
					{
						background-color:@button_primary_background;
						color:@button_primary_text_color;
						border-color:@button_primary_border_color;
						font-family:@heading_font!important;
						font-style:@heading_font_style!important;
						font-weight:@heading_font_weight!important;
					}
				.cart-actions form input.checkout-button:hover{border-color:@button_primary_border_color!important;}
				
				html .woocommerce-account #template-wrapper .woocommerce form .form-row input.button,#accordion-checkout-details #collapse-login-regis .accordion-inner input.button_create_account_continue,#accordion-checkout-details .accordion-inner form.login input.button,
				#accordion-checkout-details form.checkout .accordion-inner .button_shipping_address_continue,#accordion-checkout-details form.checkout .accordion-inner .button_review_order_continue,
				form.checkout_coupon input.button,body .woocommerce .track_order p.form-row input.button,body .woocommerce form.lost_reset_password p.form-row input.button,body .woocommerce form.change-password-form p input.button,html body .woocommerce div.coupon input.button,html body .woocommerce table.shop_table td.actions input.button, html body .woocommerce-page table.shop_table td.actions input.button ,.cart-collaterals .shipping_calculator button,body .woocommerce form.edit-address-from p > input.button,form.wpcf7-form input[type^=submit],.single-blog #comments a.comment-reply-link,.single-blog #comments #commentform  #submit,body.woocommerce #reviews .add_review .show_review_form.button,body.woocommerce #reviews .form-submit #submit,.woocommerce .widget-container.widget_price_filter .price_slider_amount .button,body .woocommerce form.login p.form-row input.button, body.woocommerce div.product div.summary span.add_new_review a, body.woocommerce-page div.product div.summary span.add_new_review a, body.woocommerce #content div.product div.summary span.add_new_review a, body.woocommerce-page #content div.product div.summary span.add_new_review a
					{
					background-color:@button_second_background!important;
					color:@button_second_text_color!important;
					border-color:@button_second_border!important;
					}
				.cart_dropdown .dropdown_foooter .buttons .button_checkout,body.woocommerce nav.woocommerce-pagination ul li:hover .page-numbers , body.woocommerce-page nav.woocommerce-pagination  ul li:hover .page-numbers , body.woocommerce #content nav.woocommerce-pagination  ul li:hover .page-numbers , body.woocommerce-page #content nav.woocommerce-pagination  ul li:hover .page-numbers,.cart_dropdown .dropdown_foooter .buttons .button_shopping_cart:hover
					{
					color:@button_primary_text_color;
					}
				.woocommerce ul.products li.product a.button:hover, .woocommerce ul.products li.product div.product-media-wrapper > a.button:hover {color:rgba(red(@button_primary_text_color),green(@button_primary_text_color),blue(@button_primary_text_color),0.5);}	

				/*==============================================================*/
				/*                     ^^ SIDEBAR CUSTOM ^^                     */
				/*==============================================================*/
				body #left-sidebar ul.cart_list li a,body #left-sidebar ul.product_list_widget li a,body #left-sidebar ul.cart_list li a,body #left-sidebar ul.product_list_widget li a,
				body #right-sidebar ul.cart_list li a,body #right-sidebar ul.product_list_widget li a,body #right-sidebar ul.cart_list li a,body #right-sidebar ul.product_list_widget li a,
				#left-sidebar .widget_multitab ul.nav-tabs li a, #right-sidebar .widget_multitab ul.nav-tabs li a,
				#left-sidebar .widget_popular ul li .detail a,#right-sidebar .widget_popular ul li .detail a,#left-sidebar .widget_twitterupdate ul li.status-item .tweet-content a, #right-sidebar .widget_twitterupdate ul li.status-item .tweet-content a, .woocommerce-page ul.products li.product .price .from,.widget_archive ul li a, .widget_categories ul li a, .widget_meta ul li a, .widget_nav_menu ul li a, .widget_pages ul li a,.widget_layered_nav ul li a,.alphabet-products ul li a,.tabs-comments-list .comment-body, .widget_recent_comments_custom .comment-body,.widget_multitab .tab-content ul li div.content a,.widget_product_categories ul li a,.widget_customrecent ul li .detail a,.widget_recent_post_thumbnail ul li .entry-title a,.tabs-comments-list .comment-author a
					{
						color:@sidebar_text_color;
					}
					
				.left-sidebar-content h3.widget-title, .right-sidebar-content h3.widget-title, .widget_multitab ul.nav-tabs
					{
						border-color:@sidebar_border_color;
					}
				/**************** 7. COLOR OF ICON *********/
				.ew-video ul li a:before,.widget_twitterupdate ul li.status-item .date-time a,ul.list-posts > li .post-infors-wrapper a.read-more:before,.icon-tags:before,body .woocommerce a.added_to_cart:before,body  .woocommerce-page a.added_to_cart:before,.widget_multitab .tab-content ul li div.content span i,.widget_popular ul.popular-post-list li div.detail span i,.widget_twitterupdate .follow-us-heading a,body.woocommerce ul.products li.product a.added_to_cart:before, body.woocommerce-page ul.products li.product a.added_to_cart:before
					{
					color:@icon_color;
					}
				/**************** 8. COLOR OF CURRENT ITEM CATAGORIES WIDGET *********/

				#header .nav ul.menu > li .menu > li.current-menu-item > a, ul li.current-cat > a, .widget_product_categories ul li a:hover, .widget_categories ul li a:hover, .widget_nav_menu ul li a:hover, .widget_pages ul li a:hover, .widget_pages ul li.current_page_item a, .widget_nav_menu ul li.current-menu-item a
					{
						color:@primary_color;
					}	
				/****************** 9. FILTER ***************************************/

				.woocommerce .widget-container.widget_price_filter .price_slider_wrapper .ui-widget-content, .woocommerce-page .widget-container.widget_price_filter .price_slider_wrapper .ui-widget-content
					{
						background-color:@filter;
					}
				/*==============================================================*/
				/*                    ^^ RATING  ^^                            */
				/*==============================================================*/

				body .woocommerce .star-rating:before, body .woocommerce-page .star-rating:before, body .woocommerce .star-rating span:before, body .woocommerce-page .star-rating span:before,
				.woocommerce .star-rating span, .woocommerce-page .star-rating span,
				body.woocommerce #reviews #comments ol.commentlist li .comment-text .star-rating span, body.woocommerce-page #reviews #comments ol.commentlist li .comment-text span .star-rating
					{
						color:@rating_color;
					}
				/*==============================================================*/
				/*                    ^^ LABLE  ^^                            */
				/*==============================================================*/

				/* Sale */
				.woocommerce ul.products li.product span.onsale.show_off, .woocommerce-page ul.products li.product span.onsale.show_off, html .woocommerce span.onsale, html .woocommerce-page span.onsale,
				.woocommerce ul.products li.product span.featured,.woocommerce-page ul.products li.product span.featured
				,body.woocommerce nav.woocommerce-pagination ul li span.current, body.woocommerce-page nav.woocommerce-pagination ul li span.current, body.woocommerce #content nav.woocommerce-pagination ul li span.current, body.woocommerce-page #content nav.woocommerce-pagination ul li span.current, body.woocommerce nav.woocommerce-pagination ul li a:hover, body.woocommerce-page nav.woocommerce-pagination ul li a:hover, body.woocommerce #content nav.woocommerce-pagination ul li a:hover, body.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, body.woocommerce nav.woocommerce-pagination ul li a:focus, body.woocommerce-page nav.woocommerce-pagination ul li a:focus, body.woocommerce #content nav.woocommerce-pagination ul li a:focus, body.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,.home .tabbable.tabs-left[id^="multitabs"] .nav-tabs li:hover a,.home .tabbable.tabs-left[id^="multitabs"] .nav-tabs li.active a,.shortcode-recent-blogs li div .image .blog-time span,.page_navi .nav-content  .wp-pagenavi a:hover,.page_navi .nav-content .wp-pagenavi span:hover,.page_navi .nav-content .wp-pagenavi span.current,.woocommerce ul.products li.product .product-media-wrapper > .product_label span.featured:before,.featured_product_slider_wrapper:hover .slider_control .prev:hover:before,body.woocommerce-page #content nav.woocommerce-pagination ul li .prev.page-numbers:hover:before,.featured_product_slider_wrapper:hover:hover .slider_control .next:hover:before, body.woocommerce-page #content nav.woocommerce-pagination ul li .next.page-numbers:hover:before,.woocommerce ul.products li.product .product-media-wrapper > .product_label .onsale .off_number,
				.page_navi .nav-content span.current,
				.page_navi .nav-content span.current,
				.page_navi .nav-content span.current span,
				.page_navi .nav-content span.current span span,
				.page_navi .nav-content a.wd_pager:hover span span,
				.pp_content_container .images .onsale,
				#footer .widget_subscriptions button.button span
					{
						color:@label_text_color;
					}
				
				.feature .feature_title a{color:(@primary_text_color + #505050)}

				/*==============================================================*/
				/*                    ^^ TAB  accordion ^^                       */
				/*==============================================================*/
				body .accordion-heading
					{
					background:@accordion_background_color;
					}
				body .accordion-heading a,body .accordion-heading a.accordion-toggle,body .accordion-inner,
				#accordion-checkout-details .accordion-heading > a h3{color:@accordion_text_color}
				
				#accordion-checkout-details .accordion-heading > a.collapsed:hover h3{color:(@primary_color + #ffffff)!important; }
				
				body #accordion-checkout-details .accordion-heading > a.accordion-toggle.collapsed {
					background-color:@primary_color!important;
					color:(@primary_color + #ffffff)!important; 
					border-color:@primary_color!important;}
				
				/*==============================================================*/
				/*                    ^^ SPECIAL  ^^                            */
				/*==============================================================*/

				/*========== 1. FEEDBACK BUTTON =======*/
				#feedback > a 
					{
						background: @feedback_background;
					}	
				/*========== 2. TO TOP BACKGROUND COLOR ========*/
				#to-top a
					{
						background:@totop_background;
					}
				#feedback > a:hover,#to-top a:hover
					{
						background: @feedback_color_hover;
					}		

				/*==============================================================*/
				/*                     ^^ CUSTOM BODER ^^                        */
				/*==============================================================*/
				/* BORDER COLOR */

				.woocommerce ul.products .featured_product_wrapper, body .woocommerce ul.products li.product, body .woocommerce-page ul.products li.product, .woocommerce ul.products .product_upsells, body .woocommerce ul.cart_list li, body .woocommerce ul.product_list_widget li, body .woocommerce-page ul.cart_list li, body .woocommerce-page ul.product_list_widget li, input[type^="text"], textarea, body.woocommerce ul.products li.product, body.woocommerce-page ul.products li.product, div.term-description, body.woocommerce .woocommerce-ordering select, body.woocommerce-page .woocommerce-ordering select, html .woocommerce .woocommerce-breadcrumb, html .woocommerce-page .woocommerce-breadcrumb, #crumbs, body.woocommerce div.product div.images a.woocommerce-main-image, body.woocommerce-page div.product div.images a.woocommerce-main-image, body.woocommerce #content div.product div.images a.woocommerce-main-image, body.woocommerce-page #content div.product div.images a.woocommerce-main-image, body.woocommerce div.product div.summary h6.short-description-title, body.woocommerce-page div.product div.summary h6.short-description-title, body.woocommerce #content div.product div.summary h6.short-description-title, body.woocommerce-page #content div.product div.summary h6.short-description-title, div.list_carousel .slider_control > a, html .woocommerce div.product .woocommerce-tabs ul.tabs:before, html .woocommerce #content div.product .woocommerce-tabs ul.tabs:before, html .woocommerce-page div.product .woocommerce-tabs ul.tabs:before, html .woocommerce-page #content div.product .woocommerce-tabs ul.tabs:before, html .woocommerce #reviews #comments ol.commentlist li .comment-text, html .woocommerce-page #reviews #comments ol.commentlist li .comment-text, body.woocommerce .upsell_wrapper .upsell_control > a, body.woocommerce-page .upsell_wrapper .upsell_control > a,.shopping-cart .wd_tini_cart_wrapper .wd_tini_cart_control span.amount, .cart_dropdown .total span, form.checkout h3, body.woocommerce .related ul.products li.product .product_thumbnail_wrapper, body.woocommerce-page .related ul.products li.product .product_thumbnail_wrapper, body.woocommerce nav.woocommerce-pagination, body.woocommerce-page nav.woocommerce-pagination, body.woocommerce #content nav.woocommerce-pagination, body.woocommerce-page #content nav.woocommerce-pagination, .widget_subscriptions .subscribe_widget .newsletter span, .widget_recent_comments_custom ul li, .widget_multitab .tab-content ul li, .widget_product_search #searchform #s, .widget_twitterupdate ul li.status-item, .widget_popular ul li .image img, .widget_customrecent ul li .image img, .widget_popular ul li, .widget_customrecent ul li, form.wpcf7-form input[type^="text"], form.wpcf7-form input[type^="email"], .woocommerce .custom-product-shortcode ul.products li.product .product-meta-wrapper, body .woocommerce form .form-row #password_1, body .woocommerce-page form .form-row #password_1, body .woocommerce form .form-row #password_2, body .woocommerce-page form .form-row #password_2, .wd_tini_account_wrapper .form_wrapper_header > span, .wd_tini_account_wrapper .form_wrapper_body input#user_login, .wd_tini_account_wrapper .form_wrapper_body #user_pass, .wd_tini_account_wrapper .login-password:after, #author-description, body .accordion-group, body .accordion-inner, body code, .create-account input[type^="password"], body .woocommerce form.login input#username, body .woocommerce form.register input#reg_username, body .woocommerce form.register input#reg_password, body .woocommerce form.register input#reg_email, body .woocommerce form.register input#reg_password2, body .woocommerce form.login #user_login, body .woocommerce form.login #password, body .woocommerce form.login #user_login, body .woocommerce form.login #password, .after_checkout_form, .woocommerce .featured_product_slider_wrapper ul.products li.product, input[type^="password"], ul.sample-block li, ul.list-posts li .post-info-1 div.time span.entry-date, .woocommerce #commentform p.comment-form-comment textarea, .woocommerce-page #commentform p.comment-form-comment textarea, #accordion-checkout-details .accordion-inner, .single-post .single-content table, .widget_text table, .single-post .single-content table th, .widget_text table th, .single-post .single-content table td, .widget_text table td, html pre, .post-info-1 table td, .post-info-1 table th, .post-info-1 table, .gallery img, body.woocommerce .related > h2, .woocommerce-page .related > h2, .woocommerce .upsells.products > h2, .woocommerce-page .upsells.products > h2, html .woocommerce form .form-row.validate-required.woocommerce-invalid .chzn-single, html .woocommerce form .form-row.validate-required.woocommerce-invalid .chzn-drop, html .woocommerce form .form-row.validate-required.woocommerce-invalid input.input-text, html .woocommerce form .form-row.validate-required.woocommerce-invalid select, html .woocommerce-page form .form-row.validate-required.woocommerce-invalid .chzn-single, html .woocommerce-page form .form-row.validate-required.woocommerce-invalid .chzn-drop, html .woocommerce-page form .form-row.validate-required.woocommerce-invalid input.input-text, html .woocommerce-page form .form-row.validate-required.woocommerce-invalid select, .validate-required input, body.woocommerce.single-product #main_content div.product form.cart tr td select, #accordion-checkout-details .accordion-heading > a.accordion-toggle.collapsed h3, body .woocommerce ul.products li.product .product-media-wrapper a img:hover, #header-search .products-search div,.header-bottom .container,#header-search .products-search div .search-input,.cart_dropdown ul.cart_list li a.remove,.cart_dropdown .dropdown_foooter .total,.shopping-cart .cart_dropdown,.cart_dropdown .dropdown_foooter .total,body .woocommerce ul.product_list_widget li a img:hover,body .woocommerce-page ul.product_list_widget li a img:hover,.cart_dropdown ul.cart_list li a:hover img,#header-search #searchform div.bg_search_1,input[type^=email] 
					{
						border-color:@primary_border_color!important;
					}

				.shortcode-recent-blogs li div .image .blog-time,.woocommerce .widget-container.widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget-container.widget_price_filter .ui-slider .ui-slider-handle,body.woocommerce nav.woocommerce-pagination ul li:hover .page-numbers , body.woocommerce-page nav.woocommerce-pagination  ul li:hover .page-numbers , body.woocommerce #content nav.woocommerce-pagination  ul li:hover .page-numbers , body.woocommerce-page #content nav.woocommerce-pagination  ul li:hover .page-numbers,
				body.woocommerce nav.woocommerce-pagination ul li span.current, body.woocommerce-page nav.woocommerce-pagination ul li span.current, body.woocommerce #content nav.woocommerce-pagination ul li span.current, body.woocommerce-page #content nav.woocommerce-pagination ul li span.current, body.woocommerce nav.woocommerce-pagination ul li a:hover, body.woocommerce-page nav.woocommerce-pagination ul li a:hover, body.woocommerce #content nav.woocommerce-pagination ul li a:hover, body.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, body.woocommerce nav.woocommerce-pagination ul li a:focus, body.woocommerce-page nav.woocommerce-pagination ul li a:focus, body.woocommerce #content nav.woocommerce-pagination ul li a:focus, body.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,.page_navi .nav-content  .wp-pagenavi a:hover,.page_navi .nav-content .wp-pagenavi span:hover,.page_navi .nav-content .wp-pagenavi span.current,.woocommerce .featured_product_slider_wrapper .pager a.selected,.woocommerce .featured_product_slider_wrapper .pager a:hover,body .woocommerce a.added_to_cart,body  .woocommerce-page a.added_to_cart,body.woocommerce ul.products li.product a.added_to_cart, body.woocommerce-page ul.products li.product a.added_to_cart,
				#footer .widget_subscriptions button.button
					{
					background-color:@primary_color;
					}
				.shortcode-recent-blogs li div .image:hover .blog-time,
				#footer .widget_subscriptions button.button:hover
					{
					background-color:@primary_second_color;
					}

				/*================ 1. border input hover =================*/
				body .woocommerce .cart-collaterals .shipping_calculator select:hover,body .woocommerce-page .cart-collaterals .shipping_calculator select:hover ,body .woocommerce .cart-collaterals .shipping_calculator input:hover,body .woocommerce-page .cart-collaterals .shipping_calculator input:hover,.coupon_wrapper input#coupon_code:hover,.page-template-page-templatescontact-template-php span.wpcf7-form-control-wrap input:hover,form.wpcf7-form span .wpcf7-textarea:hover,.woocommerce-page table.cart td.product-thumbnail a img:hover, .woocommerce #content table.cart td.product-thumbnail a img:hover, .woocommerce-page #content table.cart td.product-thumbnail a img:hover
					{
					border-color:(@primary_border_color - #323232)!important;/*#999999*/
					}
				.header-bottom .container, .container .container, .cart_dropdown, #accordion-checkout-details .accordion-heading, .cart_dropdown ul.cart_list li a.remove, .shopping-cart .cart_dropdown, #header .nav ul.menu > li .ads img:hover, .heading-title-block > h2, .entry-content-post .heading-title-block h6, .entry-content-post .list-style, #container-main .heading-title-block h2, .woocommerce .featured_product_slider_wrapper .featured_product_slider_wrapper_meta h3, .main-content .entry-content-post .one_third .feature, .main-content .entry-content-post .one_third .feature2, #header .nav ul.menu > li > ul ul.sub-menu:before, .woocommerce .widget_price_filter .price_slider_amount .button, .woocommerce-page .widget_price_filter .price_slider_amount .button, body.woocommerce nav.woocommerce-pagination ul li .page-numbers, body.woocommerce-page nav.woocommerce-pagination ul li .page-numbers, body.woocommerce #content nav.woocommerce-pagination ul li .page-numbers, body.woocommerce-page #content nav.woocommerce-pagination ul li .page-numbers, .page_navi .nav-content .wp-pagenavi a, .page_navi .nav-content .wp-pagenavi span, #container-main .featured_categories_slider_wrapper > div.featured_categories_slider_wrapper_inner,
				body .pp_content_container .summary .quantity .minus ,
				body .pp_content_container .summary .quantity .qty ,
				body .pp_content_container .summary .quantity .plus
					{
					border-color:@primary_border_color;
					}
				#container-main .featured_categories_slider_wrapper > div.featured_categories_slider_wrapper_inner:before {background:@primary_border_color}
				/*---- border product ----*/
				#container-main .featured_categories_slider_wrapper ul.products li.product a:hover img,body .woocommerce ul.products li.product a:hover img,.woocommerce ul.products li.product .product-media-wrapper:hover,#header .nav ul.menu > li .woocommerce .products div.product_thumbnail_wrapper .product-image-front img:hover,#header .nav ul.menu > li .woocommerce .products div.product_thumbnail_wrapper:hover .product-image-front img,.shortcode-recent-blogs > li a.thumbnail img
					{
					border-color:(@primary_border_color + #1b1b1d)
					}
				body.woocommerce nav.woocommerce-pagination ul li:hover .page-numbers , body.woocommerce-page nav.woocommerce-pagination  ul li:hover .page-numbers , body.woocommerce #content nav.woocommerce-pagination  ul li:hover .page-numbers , body.woocommerce-page #content nav.woocommerce-pagination  ul li:hover .page-numbers,
				body.woocommerce nav.woocommerce-pagination ul li span.current, body.woocommerce-page nav.woocommerce-pagination ul li span.current, body.woocommerce #content nav.woocommerce-pagination ul li span.current, body.woocommerce-page #content nav.woocommerce-pagination ul li span.current, body.woocommerce nav.woocommerce-pagination ul li a:hover, body.woocommerce-page nav.woocommerce-pagination ul li a:hover, body.woocommerce #content nav.woocommerce-pagination ul li a:hover, body.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, body.woocommerce nav.woocommerce-pagination ul li a:focus, body.woocommerce-page nav.woocommerce-pagination ul li a:focus, body.woocommerce #content nav.woocommerce-pagination ul li a:focus, body.woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .page_navi .nav-content  .wp-pagenavi a:hover,.page_navi .nav-content .wp-pagenavi span:hover,.page_navi .nav-content .wp-pagenavi span.current
					{
					border-color:(@primary_border_color - #cbcbcb);
					}
				#container-main .featured_categories_slider_wrapper .slider_control .next,#container-main .featured_categories_slider_wrapper .slider_control .prev,#container-main .recent_blog_slider_wrapper .slider_control .prev,#container-main .recent_blog_slider_wrapper .slider_control .next,#container-main.span18 .featured_categories_slider_wrapper .slider_control .prev,#container-main.span18 .recent_blog_slider_wrapper .slider_control .prev,#container-main.span18 .featured_categories_slider_wrapper .slider_control .next,#container-main.span18 .recent_blog_slider_wrapper .slider_control .next,#container-main.span12 .featured_categories_slider_wrapper .slider_control .next,#container-main.span12 .recent_blog_slider_wrapper .slider_control .next,#container-main.span12 .featured_categories_slider_wrapper .slider_control .prev,#container-main.span12 .recent_blog_slider_wrapper .slider_control .prev
					{
					border-color:rgba(red(@primary_border_color + #0d0d0d),green(@primary_border_color + #0d0d0d),blue(@primary_border_color + #0d0d0d),0.4);
					}
				ul.list-posts li
					{
					border-color:(@primary_border_color + #202020);
					}
				.cat_custom_content,.heading-title-block h1,.heading-title-block h2,.heading-title-block h3,.heading-title-block h4,.heading-title-block h5,.heading-title-block h6,h1.catagory-title, h1.author-title, h1.sitemap-title.heading-title.page-title,h1.archive-title.heading-title.page-title,.blog-template .content-inner
					{
					border-color:(@primary_border_color + #1b1b1d);/*#e6e6e8*/
					}

				/*================ border table =================*/
				 body .woocommerce table.shop_table , body .woocommerce-page table.shop_table, body .woocommerce table.shop_table thead tr th  , body .woocommerce-page table.shop_table thead tr th,body .woocommerce table.shop_table tr td, body .woocommerce-page table.shop_table tr td,body form.checkout #order_review table.shop_table tbody td.product-total,body form.checkout #order_review table.shop_table tfoot tr.cart-subtotal td,body form.checkout #order_review table.shop_table tfoot tr.cart-subtotal th,body form.checkout #order_review table.shop_table tfoot th,body .woocommerce table.shop_table.my_account_orders tbody tr.order:first-child td,body .woocommerce table.shop_table.my_account_orders tbody tr.order.last td,body .woocommerce table.shop_table.my_account_orders tbody tr.order td:first-child,body .woocommerce table.shop_table.my_account_orders thead th:first-child,body #container-main.span12 .woocommerce table.cart .product-thumbnail.first
					{
					border-color:(@primary_border_color + #0b0b0b);
					}
				body .woocommerce table.cart .product-thumbnail.first,body .woocommerce .shop_table.order_details thead th:first-child,body .woocommerce .shop_table.order_details thead th,body .woocommerce .shop_table.order_details tbody td, body .woocommerce .shop_table.order_details th,body .span12 .woocommerce table.shop_table.cart tr th.product-thumbnail,body .span18 .woocommerce table.shop_table.cart tr th.product-thumbnail,
					{
						border-color:(@primary_border_color + #0b0b0b)!important;
					}
				body .woocommerce form.lost_reset_password > p:first-child,body form.checkout #payment .payment_box p,body .woocommerce .track_order > p:first-child
					{
					border-color:(@primary_border_color + #131313);
					}
				.featured_product_slider_wrapper .slider_control .prev, .nivo-directionNav a.nivo-prevNav, .flex-direction-nav a.flex-prev,.featured_product_slider_wrapper .slider_control .next, .nivo-directionNav a.nivo-nextNav, .flex-direction-nav a.flex-next
					{
				border-color:rgba(red(@primary_border_color + #0d0d0d),green(@primary_border_color + #0d0d0d),blue(@primary_border_color + #0d0d0d),0.4);
					}
				/*==============================================================*/
				/*                     ^^ PRIMARY COLOR ^^                        */
				/*==============================================================*/
					/* PAGER */
				#container-main .recent_blog_slider_wrapper .pager a,#container-main .featured_categories_slider_wrapper .pager a,#container-main  .woocommerce .featured_product_slider_wrapper .pager a,.woocommerce .featured_product_slider_wrapper .pager a
					{
						border-color:@primary_text_color;
						background-color:(@primary_text_color + #ffffff); //#fff
					}
				#container-main .featured_categories_slider_wrapper .pager a:hover,#container-main .featured_categories_slider_wrapper .pager a.selected,#container-main  .recent_blog_slider_wrapper .pager a:hover,#container-main  .recent_blog_slider_wrapper .pager a.selected,#container-main  .woocommerce .featured_product_slider_wrapper .pager a:hover,#container-main  .woocommerce .featured_product_slider_wrapper .pager a.selected
					{
						background:@primary_text_color;
					}
					/* END - PAGER */
					
				#main-module-container .container ,.woocommerce ul.products .product_upsells{background:@primary_background_color!important}

				ul.list-posts > li .post-infors-wrapper p.short-content
					{ 
						color:(@primary_text_color + #131313);
					}
				ul.list-posts > li .post-infors-wrapper span.cat-links,ul.list-posts > li .post-infors-wrapper span.cat-links a,ul.list-posts li .post-infors-wrapper span.author,ul.list-posts > li .post-infors-wrapper span.comments-count,ul.list-posts > li .post-infors-wrapper span.tag-links a
					{ 
						color:(@primary_text_color + #505050);
					}
				/* Style for crumb - color follow Main text color */

				a,ul li,ol li, html .woocommerce .woocommerce-breadcrumb a, html .woocommerce-page .woocommerce-breadcrumb a, #crumbs .brn_arrow a, html .woocommerce .woocommerce-breadcrumb, html .woocommerce-page .woocommerce-breadcrumb, #crumbs, .woocommerce ul.products .product_upsells h4.heading-title, body .woocommerce ul.products li.product .product_sku, .woocommerce .featured_product_slider_wrapper ul.products li.product .product_sku,.featured_product_slider_wrapper:hover .slider_control .prev:before, .featured_product_slider_wrapper:hover .slider_control .next:before, input, select, textarea, .woocommerce ul.products .featured_product_wrapper .product_big_layout > li.product .product_sku,  html .woocommerce .woocommerce-breadcrumb span, html .woocommerce-page .woocommerce-breadcrumb span, #crumbs span, ul.list-posts li .post-info-2 a, ul.list-posts li .post-info-2, #crumbs a, .page_navi .wp-pagenavi a, .page_navi .wp-pagenavi span, body.woocommerce div.product div.summary span.product_sku, body.woocommerce-page div.product div.summary span.product_sku, body.woocommerce #content div.product div.summary span.product_sku, body.woocommerce-page #content div.product div.summary span.product_sku, .review_count, .show_review_form, .woocommerce ul.products li.product .price .from, #container .products.grid h3, body.woocommerce-page #content nav.woocommerce-pagination ul li .next.page-numbers:before, body.woocommerce-page #content nav.woocommerce-pagination ul li .prev.page-numbers:before, body.woocommerce nav.woocommerce-pagination ul li .page-numbers, body.woocommerce-page nav.woocommerce-pagination ul li .page-numbers, body.woocommerce #content nav.woocommerce-pagination ul li .page-numbers, body.woocommerce-page #content nav.woocommerce-pagination ul li .page-numbers, #footer .widget_customrecent ul li .detail .comment-count, body .woocommerce ul.cart_list li .amount, body .woocommerce ul.product_list_widget li .amount, body .woocommerce-page ul.cart_list li .amount, body .woocommerce-page ul.product_list_widget li .amount, .shortcode-recent-blogs > li .detail h4.heading-title a, ul.list-posts > li a.post-title h2,html .woocommerce ul.products li.product .price ins, html .woocommerce-page ul.products li.product .price ins, ins .amount,body .cat_custom_content .heading-title-block h3,body h1.heading-title.page-title,.page-template-page-templatesfullwidth-template-php .heading-title-block h3,.cart-collaterals .cart_totals tr.total span.amount,.home #container-main.span24 .main-content .heading-title-block h1, .blog-template .content-inner h2,.blog-template .content-inner p,#container #main .main-content h1,.background-code pre,.woocommerce .custom_category_shortcode h3,#container #main .main-content h1.view-order,body .woocommerce h2.order-detail-title,body .woocommerce h2.custom-detail-title,body.woocommerce ul.products li.product span.product_sku, body.woocommerce-page ul.products li.product span.product_sku,body #footer .widget_best_sellers ul.product_list_widget li, body #footer .widget_top_rated_products ul.product_list_widget li, body #footer .widget_recent_reviews ul.product_list_widget li,body .woocommerce form p label,p,strong,body .alert,.quote-style,
				.one_half, .one_third, .two_third, .one_fourth, .three_fourth, .one_fifth, .two_fifth, .three_fifth, .four_fifth, .one_sixth, .five_sixth,h3,h4,ul.list-posts > li .post-infors-wrapper .time,.sitemap-content > div ul li, .archive-content > div ul li,.tab-content > .tab-pane, .pill-content > .pill-pane,.addresses address,span,time,body .woocommerce table.shop_table.my_account_orders tbody .amount,body .woocommerce table.shop_table.my_account_orders tbody tr td.order-total,body .woocommerce table.shop_table.cart tr th,body .woocommerce table.cart .amount, body .woocommerce-page table.cart .amount, body .woocommerce #content table.cart .amount, .woocommerce #content table.cart .amount,.cart_totals tr.shipping ul#shipping_method li,.cart-collaterals .cart_totals table th,body .woocommerce-error li,body.woocommerce .woocommerce-ordering select, body.woocommerce-page .woocommerce-ordering select,.summary.entry-summary .product_title,body.woocommerce div.product .woocommerce-tabs .panel > h2, body.woocommerce-page div.product .woocommerce-tabs .panel > h2, body.woocommerce #content div.product .woocommerce-tabs .panel > h2, body.woocommerce-page #content div.product .woocommerce-tabs .panel > h2,.woocommerce #reviews #comments h2, .woocommerce-page #reviews #comments h2,body.woocommerce-checkout #container-main.span24 .main-content .woocommerce h2,body .woocommerce table.cart td.product-name a, body .woocommerce-page table.cart td.product-name a, body .woocommerce #content table.cart td.product-name a, .woocommerce #content table.cart td.product-name a,html .woocommerce .order_details li, html .woocommerce-page .order_details li,body .woocommerce .shop_table.order_details thead th,body .woocommerce .shop_table.order_details tfoot th,body .woocommerce .shop_table.order_details tfoot td .amount,body .woocommerce .shop_table.order_details tfoot td,.woocommerce td.product-name dl.variation, .woocommerce-page td.product-name dl.variation,body.single-product #container #products-tabs-wrapper #related_products .caroufredsel_wrapper > ul li .product-meta-wrapper .price .from,body .woocommerce dl.customer_details,#customer_login h2,.summary.entry-summary .description p,body .woocommerce-message,body .woocommerce-error,.single-blog #comments ol.commentlist li.comment .divcomment-inner .detail .comment-author > span a,.single-blog .related ul li div > span.entry-date,.single-blog .single-post .tags span.tag-title,.single-blog .single-post .tags a,#author-description span.view-all-author-posts a,.single-blog #comments #commentform span.label,.woocommerce .return-shipping h6.title-quickshop, .woocommerce-page .return-shipping h6.title-quickshop,.woocommerce .return-shipping .content-quick , .woocommerce-page .return-shipping .content-quick
				.one_half, .one_third, .two_third, .one_fourth, .three_fourth, .one_fifth, .two_fifth, .three_fifth, .four_fifth, .one_sixth, .five_sixth,h3,h4,ul.list-posts > li .post-infors-wrapper .time,.sitemap-content > div ul li, .archive-content > div ul li,.tab-content > .tab-pane, .pill-content > .pill-pane,.addresses address,span,time,body .woocommerce table.shop_table.my_account_orders tbody .amount,body .woocommerce table.shop_table.my_account_orders tbody tr td.order-total,body .woocommerce table.shop_table.cart tr th,body .woocommerce table.cart .amount, body .woocommerce-page table.cart .amount, body .woocommerce #content table.cart .amount, .woocommerce #content table.cart .amount,.cart_totals tr.shipping ul#shipping_method li,.cart-collaterals .cart_totals table th,body .woocommerce-error li,body.woocommerce .woocommerce-ordering select, body.woocommerce-page .woocommerce-ordering select,.summary.entry-summary .product_title,body.woocommerce div.product .woocommerce-tabs .panel > h2, body.woocommerce-page div.product .woocommerce-tabs .panel > h2, body.woocommerce #content div.product .woocommerce-tabs .panel > h2, body.woocommerce-page #content div.product .woocommerce-tabs .panel > h2,.woocommerce #reviews #comments h2, .woocommerce-page #reviews #comments h2,body.woocommerce-checkout #container-main.span24 .main-content .woocommerce h2,body .woocommerce table.cart td.product-name a, body .woocommerce-page table.cart td.product-name a, body .woocommerce #content table.cart td.product-name a, .woocommerce #content table.cart td.product-name a,html .woocommerce .order_details li, html .woocommerce-page .order_details li,body .woocommerce .shop_table.order_details thead th,body .woocommerce .shop_table.order_details tfoot th,body .woocommerce .shop_table.order_details tfoot td .amount,body .woocommerce .shop_table.order_details tfoot td,.woocommerce td.product-name dl.variation, .woocommerce-page td.product-name dl.variation,body.single-product #container #products-tabs-wrapper #related_products .caroufredsel_wrapper > ul li .product-meta-wrapper .price .from,body .woocommerce dl.customer_details,#customer_login h2,.summary.entry-summary .description p,body .woocommerce-message,body .woocommerce-error,.single-blog #comments ol.commentlist li.comment .divcomment-inner .detail .comment-author > span a,.single-blog .related ul li div > span.entry-date,.single-blog .single-post .tags span.tag-title,.single-blog .single-post .tags a,#author-description span.view-all-author-posts a,.single-blog #comments #commentform span.label,.woocommerce .return-shipping h6.title-quickshop, .woocommerce-page .return-shipping h6.title-quickshop,.woocommerce .return-shipping .content-quick , .woocommerce-page .return-shipping .content-quick,body .woocommerce table.shop_table.my_account_orders tbody td.order-actions a,.heading-title-block > h2,.heading-title-block > h5,.heading-title-block > h6,.cart-collaterals .cart_totals tr.order-total span.amount ,body .woocommerce table.shop_table.cart tr td.product-thumbnail:before,body .woocommerce table.shop_table.cart tr th.product-name:before,
				.page_navi .nav-content .wp-pagenavi > span.wd_curent-total span:hover,
				.page_navi .nav-content .wp-pagenavi > span.wd_curent-total span
					{
						color:@primary_text_color;
					}
				.woocommerce .return-shipping h6.title-quickshop, .woocommerce-page .return-shipping h6.title-quickshop{border-color:@primary_text_color;}
				input:focus:invalid, textarea:focus:invalid, select:focus:invalid {color:(@primary_text_color + #323232)}
					
				.wd_tini_account_control
					{
						border-color:(@primary_text_color + #787878);
					}
				/*========== BLOG ==============*/
				ul.list-posts > li a.post-title:hover h2,.shortcode-recent-blogs > li .detail h4.heading-title a:hover, body .woocommerce .custom_category_shortcode del span.amount, .woocommerce .featured_product_slider_wrapper ul.products li.product del .amount, del span.amount, .woocommerce .custom-product-shortcode ul.products li.product .price del .amount,#footer  .widget_best_sellers  ul.product_list_widget  li del span,body .woocommerce div.product div.summary .price del span.amount, body.woocommerce-page div.product div.summary .price del span.amount, body.woocommerce #content div.product div.summary .price del span.amount, body.woocommerce-page #content div.product div.summary .price del span.amount{color:(@primary_link_color + #808080)}

				/* CUSTOM FOLLOW PRIMARY COLOR */
				.widget_tag_cloud .tagcloud a,.widget_product_tag_cloud div.tagcloud a, body.woocommerce #tab-tags .tagcloud a, #accordion-product-details .tagcloud a
					{
						color:@sidebar_text_color;
					}
				/*********************************************** PRIMARY LINK COLOR ***************************************/
				 body .woocommerce ul.products li.product .heading-title, body .woocommerce ul.products li.product .heading-title, .woocommerce ul.products .featured_product_wrapper .product_big_layout > li.product h3,
				.single-blog .related a.title, .widget_product_categories ul li a,
				body.woocommerce div.product .woocommerce-tabs ul.tabs li, body.woocommerce-page div.product .woocommerce-tabs ul.tabs li a, body.woocommerce #content div.product .woocommerce-tabs ul.tabs li a, body.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a,
				body.woocommerce-page div.product .woocommerce-tabs ul.tabs li a:hover, body.woocommerce #content div.product .woocommerce-tabs ul.tabs li a:hover, body.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a:hover, .widget_flickr a.see-more:hover,
				.woocommerce .featured_product_slider_wrapper ul.products li.product .amount, .woocommerce ul.products .featured_product_wrapper .product_big_layout > li.product .amount,
				span.amount,.cart_dropdown ul.cart_list li .cart_item_wrapper .quantity .amount,#footer #footer-first-area .xoxo a,#container-main .featured_categories_slider_wrapper .category_slider_title, .products .product-category h3,.products .product-category h3,.tabbable.tabs-left.product  .nav-tabs li a,.cart_dropdown ul.cart_list li .cart_item_wrapper a,body.woocommerce ul.products li.product .product-meta-wrapper .gridlist-buttonwrap .price .from, body.woocommerce-page ul.products li.product .product-meta-wrapper .gridlist-buttonwrap .price .from,body form.checkout tr.total td span.amount,body .woocommerce div.product div.summary .price ins .amount, body.woocommerce-page div.product div.summary .price ins .amount, body.woocommerce #content div.product div.summary .price ins .amount, body.woocommerce-page #content div.product div.summary .price ins .amount, body .woocommerce div.product div.summary .price span.amount, body.woocommerce-page div.product div.summary .price span.amount, body.woocommerce #content div.product div.summary .price span.amount, body.woocommerce-page #content div.product div.summary .price span.amount,body .woocommerce .featured_product_slider_wrapper ul.products li.product ins, html body .woocommerce ul.products li.product .price del, html body .woocommerce-page ul.products li.product .price del,body .woocommerce div.product span.price ins,body .woocommerce-page div.product span.price ins,body .woocommerce #content div.product span.price ins,body .woocommerce-page #content div.product span.price ins,body .woocommerce div.product p.price ins,body html .woocommerce-page div.product p.price ins,body html .woocommerce #content div.product p.price ins,body html .woocommerce-page #content div.product p.price ins,body .product-meta-wrapper ins .amount
					{
						color:/*@header_menu_text_color;*/@primary_text_color;
					}

				/*==========  OTHERS ===========*/
				.single-blog #entry-author-info span.author-name a:hover {color:fade(@header_top_text_color,80);}

				/*================background slider=================*/
				.woocommerce .featured_product_slider_wrapper ul.products li.product .product-meta-wrapper,.featured_product_slider_wrapper > div.featured_product_slider_wrapper_inner .caroufredsel_wrapper{background-color:@header_menu_background_color;}
				.slideshow-sub-wrapper.wide-wrapper .woocommerce .featured_product_slider_wrapper{background-color:(@header_menu_background_color + #312b42)}

				/*========== Calculator border color follow Border Color ===========*/
				input:focus:invalid:focus, textarea:focus:invalid:focus, select:focus:invalid:focus {border-color:@primary_border_color;}
				body .woocommerce ul.cart_list li img, body .woocommerce ul.product_list_widget li img, body .woocommerce-page ul.cart_list li img, body .woocommerce-page ul.product_list_widget li img,
				.woocommerce ul.products .product_upsells ul li a,.widget_flickr div.flickr_badge_image a img,
				.tabs-comments-list .avarta img, .widget_recent_comments_custom .avarta img, .widget_multitab .tab-content ul li div.image img
					{
						border-color:(@primary_border_color + #181818);
					}
				ul.list-posts li .post-info-2:before
					{
						background: (@primary_border_color + #0b0b0b);
					}
				.widget_product_categories ul ul:before,.widget_categories ul ul:before, .widget_nav_menu ul ul:before, .widget_pages ul ul:before,body .woocommerce h2.order-detail-title:after,body .woocommerce h2.custom-detail-title:after
					{
						background-color:@primary_border_color;
					}
				div.list_carousel .slider_control > a,body.woocommerce .upsell_wrapper .upsell_control > a,body.woocommerce-page .upsell_wrapper .upsell_control > a
					{
						color:@primary_border_color;
					}
				form.wpcf7-form p i 
					{
						color: @primary_border_color;
					}	
			
			<?php 
			$file = @fopen($cache_file, 'w');
			if( $file != false ){
				@fwrite($file, ob_get_contents()); 
				@fclose($file); 
			}else{
				define('USING_CSS_CACHE', false);
			}
			update_option(THEME_SLUG.'custom_style', ob_get_contents());
			//ob_end_flush();		
			ob_end_clean();
			
			return USING_CSS_CACHE == true ? 1 : 0;
		}catch(Excetion $e){
			// $result = new StdClass();
			// $result->status = array();
			// return $result;
			return -1;
		}
	}
		
	function wd_custom_style_inline_script(){
		global $wd_default_custom_style_config;
		$custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
		$custom_style_config_arr = unserialize($custom_style_config);
		$custom_style_config_arr = wd_array_atts($wd_default_custom_style_config,$custom_style_config_arr);	
	

	
		$enable_custom_font = (int) $custom_style_config_arr['enable_custom_font'];
		$enable_custom_color = (int) $custom_style_config_arr['enable_custom_color'];
		$body_font = $custom_style_config_arr['body_font_name'];
		$body_font  = str_replace( " ", "+", $body_font );
		$body_font_weight = $custom_style_config_arr['body_font_weight'];
	   
		$heading_font = $custom_style_config_arr['heading_font_name'];
		$heading_font  = str_replace( " ", "+", $heading_font );
		$heading_font_weight = $custom_style_config_arr['heading_font_weight'];	
		
		$menu_font = $custom_style_config_arr['menu_font_name'];
		$menu_font  = str_replace( " ", "+", $menu_font );
		$menu_font_weight = $custom_style_config_arr['menu_font_weight'];			
		
		$sub_menu_font = $custom_style_config_arr['sub_menu_font_name'];
		$sub_menu_font  = str_replace( " ", "+", $sub_menu_font );
		$sub_menu_font_weight = $custom_style_config_arr['sub_menu_font_weight'];		
			
		if( $enable_custom_font ){
			if( strlen($body_font) > 0 && (int)$body_font != -1 ){?>
			<link id='<?php echo $body_font;?>' href='http://fonts.googleapis.com/css?family=<?php echo $body_font;?><?php if(strlen($body_font_weight)>0) echo ":",$body_font_weight;?>' rel='stylesheet' type='text/css' />
			<?php }
			if( strlen($heading_font) > 0 && (int)$heading_font != -1 ){?>
			<link id='<?php echo $heading_font;?>' href='http://fonts.googleapis.com/css?family=<?php echo $heading_font;?><?php if(strlen($heading_font_weight)>0) echo ":",$heading_font_weight;?>' rel='stylesheet' type='text/css' />	
			<?php }			
			if( strlen($menu_font) > 0 && (int)$menu_font != -1 ){?>
			<link id='<?php echo $menu_font;?>' href='http://fonts.googleapis.com/css?family=<?php echo $menu_font;?><?php if(strlen($menu_font_weight)>0) echo ":",$menu_font_weight;?>' rel='stylesheet' type='text/css' />	
			<?php }
			if( strlen($sub_menu_font) > 0 && (int)$sub_menu_font != -1 ){?>
			<link id='<?php echo $sub_menu_font;?>' href='http://fonts.googleapis.com/css?family=<?php echo $sub_menu_font;?><?php if(strlen($sub_menu_font_weight)>0) echo ":",$sub_menu_font_weight;?>' rel='stylesheet' type='text/css' />	
			<?php }
		}
		if( USING_CSS_CACHE == false ){
			global $wd_custom_style;
			echo '<style type="text/css">';
			echo get_option(THEME_SLUG.'custom_style', '');
			echo '</style>';
		}		
		
	}
		
	function wd_include_cache_css(){
		$custom_cache_file = THEME_CACHE.'custom.less';
		$custom_cache_file_uri = THEME_URI.'/cache_theme/custom.less';
		if (file_exists($custom_cache_file)) {
			wp_register_style( 'custom-style',$custom_cache_file_uri );
			wp_enqueue_style('custom-style');
			wp_dequeue_style('custom');
		}
		
		if(file_exists(THEME_CACHE.'custom.css')){
		
			wp_dequeue_style('wd_css_custom');
			wp_register_style( 'wd_css_custom', THEME_URI.'/cache_theme/custom.css');
			wp_enqueue_style('wd_css_custom');
		}
	}
	
	global $wd_default_custom_style_config,$wd_custom_style_config;
	// $custom_style_config = get_option(THEME_SLUG.'custom_style_config','');
	// $custom_style_config_arr = unserialize($custom_style_config);
	// $custom_style_config_arr = wd_array_atts($wd_default_custom_style_config,$custom_style_config_arr);	
	
	$custom_style_config_arr = $wd_custom_style_config;
	
	$enable_custom_font = (int) $custom_style_config_arr['enable_custom_font'];
	$enable_custom_color = (int) $custom_style_config_arr['enable_custom_color'];
		
	
	if( USING_CSS_CACHE == true && ( $enable_custom_font || $enable_custom_color ) ){
		add_action('wp_enqueue_scripts','wd_include_cache_css',10000000000000);
	}	
?>
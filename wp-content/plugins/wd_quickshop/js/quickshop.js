/**
 * WD QuickShop
 *
 * @license commercial software
 * @copyright (c) 2013 Codespot Software JSC - WPDance.com. (http://www.wpdance.com)
 */



(function($) {

	// disable QuickShop:
	if(jQuery('body').innerWidth() < 768)
		EM_QUICKSHOP_DISABLED = true;

	jQuery.noConflict();
	qs = null;
	jQuery(function ($) {
			//insert quickshop popup
			 $('#em_quickshop_handler').prettyPhoto({
				deeplinking: false
				,opacity: 0.9
				,social_tools: false
				,default_width: jQuery('body').innerWidth()/8*5
				,default_height: "innerHeight" in window ? ( window.innerHeight - 150 ) : (document.documentElement.offsetHeight - 150)
				//,default_height: window.innerHeight - 150
				,theme: 'pp_woocommerce'
				,changepicturecallback : function(){
					$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added');//.append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');
					$('.pp_inline').find('form.variations_form').wc_variation_form();
					$('.pp_inline').find('form.variations_form .variations select').change();	
					
					var _li_count = jQuery('.qs-thumbnails > li').length;
					if( _li_count > 0 ){
						_li_count = Math.min(_li_count,4);
					}else{
						_li_count = 4;
					}

					jQuery('.qs-thumbnails').carouFredSel({		
						responsive: true
						,width	: _li_count*25 + '%'
						,height	: 88
						,scroll	: 1
						,swipe	: { onMouse: false, onTouch: true }	
						,items	: {
							width		: 85
							,height		: 85
							,visible	: {
								min		: 1
								,max	: 4
							}
						}
						,auto	: false
						,prev	: '#qs_thumbnails_prev'
						,next	: '#qs_thumbnails_next'								
					});
					
					
				}
			});
		
		function hide_element( jquery_obj ){
			TweenMax.to( jquery_obj , 0, {	css:{
													//visibility: 'invisible'
													opacity : 0
													,display : 'none'
												}			
											,ease:Power2.easeInOut
										}
						);
		}
		
		
		// quickshop init
		function _qsJnit() {
			var selectorObj = arguments[0];
			var listprod = $(selectorObj.itemClass);	// selector chon tat ca cac li chua san pham tren luoi
			var baseUrl = '';
			
			var qsHandlerImg = $('#em_quickshop_handler img');
			var qsHandler = $('#em_quickshop_handler');
			//$('.product-image-back').hide();
			$.each(listprod, function (index, value) {
				var _ul_prods = $(value).parents("ul.products");
				if( !_ul_prods.hasClass('no_quickshop') ){

					// show quickshop handle when hover product image
					$(value).live('mouseenter'/*mouseover*/, function () {
						var o = $(this).offset();
						var qs_btn = $('#em_quickshop_handler');
						var _ajax_uri = _qs_ajax_uri + "?ajax=true&action=load_product_content&product_id="+jQuery(value).siblings(selectorObj.inputClass).val();
						qsHandler.attr('href', _ajax_uri );
                        var temp = 0 ;
                        //if(jQuery("div#wpadminbar").length > 0) {
                        //    temp = jQuery("div#wpadminbar").height();
                        //}
						TweenMax.to( qsHandler ,0,  {	css:{
															top: Math.round(o.top + ( $(this).height() - qs_btn.height() )/2 - temp ) +'px'
															,left:  Math.round(o.left /*- qs_btn.width()/2*/ )+'px'
															,opacity : 1
															//,scale:0
															,zIndex:-1
															,display : 'block'
														}																		
														//,ease:Linear.linear
													}
									);				
						TweenMax.to( qsHandler , 0.5 ,  {	css:{	
																top: Math.round(o.top + ( $(this).height() - qs_btn.height() )/2 - temp ) +'px'
																,left:  Math.round(o.left+( $(this).width() - qs_btn.width() )/2 - 25)+'px'
																//scale:1
																,zIndex:999
																,opacity : 1
																,display : 'block'
															}
															,repeat: 0
															//,ease:Linear.linear
													}
									);
					});
					$(value).live('mouseleave'/*mouseout*/, function (event) {
						var _to_element = event.relatedTarget || event.toElement;

						if( typeof _to_element !== "null" && typeof _to_element !== "undefined" ){
							if( $(_to_element).length > 0 ){
								var _cur_id = $(_to_element).attr('id');
								if( typeof _cur_id !== "undefined" ){
									if( _cur_id != "em_quickshop_handler" && _cur_id != "qs_inner1" && _cur_id != "qs_inner2" ){
										hide_element(qsHandler);
									}else{
										$(value).find('.product-main-link').trigger('mouseover');
									}
								}else{
									hide_element(qsHandler);
								}
								
							}else{
								hide_element(qsHandler);
							}
						}else{
							hide_element(qsHandler);


						}
					});
					
				}
			});

			//fix bug image disapper when hover
			qsHandler.live('mouseover', function () {
				$(this).show().css('opacity','1');
			}).live('click', function (event) {		
				hide_element(qsHandler);
				
				event.preventDefault();
			});
			$('#real_quickshop_handler').click(function(event){
				event.preventDefault();
			});

			$('.wd_quickshop.product').live('mouseover',function(){
				if( !$(this).hasClass('active') ){
					$(this).addClass('active');
					$('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({});							
				}
			});
			
			//fix bug group 0 qty, and out of stock
			$('.wd_quickshop.product form button.single_add_to_cart_button').live('click',function(){
				
				if($('.wd_quickshop.product form table.group_table').length > 0){
					$('.wd_quickshop.product').prev('ul.woocommerce-error').remove();
					temp = 0;
					
					$('.wd_quickshop.product form table.group_table').find('input.qty').each(function(i,value){
						var td_cur = $(value).closest( "td" );
						
						if($(value).val() > temp && !td_cur.next().hasClass('wd_product_out-of-stock'))
							temp = $(value).val();
					});
					if(temp == 0) {
						$('.wd_quickshop.product').before( $( "<ul class=\'woocommerce-error\'><li>Please choose the quantity of items you wish to add to your cart…</li></ul>" ) );
						return false;
					}	
				}
			});
			
		}

		if (typeof EM_QUICKSHOP_DISABLED == 'undefined' || !EM_QUICKSHOP_DISABLED)
		
			/*************** Disable QS in Main Menu *****************/
			jQuery('ul.menu').find('ul.products').addClass('no_quickshop');
			jQuery('div.main-slideshow').find('ul.products').addClass('no_quickshop');
			//jQuery('div.custom-product-shortcode').find('ul.products').addClass('no_quickshop');
			/*************** Disable QS in Main Menu *****************/		
		
			_qsJnit({
				itemClass		: '.products li.product.type-product.status-publish > .product-media-wrapper, .custom_category_shortcode .images' //selector for each items in catalog product list,use to insert quickshop image
				,inputClass		: 'input.hidden_product_id' //selector for each a tag in product items,give us href for one product
			});
			qs = _qsJnit;
	});
})(jQuery);


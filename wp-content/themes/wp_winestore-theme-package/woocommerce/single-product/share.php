<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php
	global $post,$wd_single_prod_datas;
?>
<?php do_action('woocommerce_share'); // Sharing plugins can hook into here ?>
<div class="social_sharing">
	<div class="social-des">
		<h6 class="title-social"><?php echo $_sharing_title = sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_single_prod_datas['sharing_title'])) ) ;?></h6>
		<p class="content-social-des"><?php echo stripslashes(htmlspecialchars_decode($wd_single_prod_datas["sharing_intro"]));?></p>
	</div>

	<div class="social_icon">	
		<div class="facebook">
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-like" data-href="<?php the_permalink();?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="true"></div>
		</div>			
			
		<!-- Place this render call where appropriate -->
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		
		<div class="twitter">
			<a href="<?php _e('https://twitter.com/share','wpdance') ?>" class="twitter-share-button" >Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
			
		<div class="gplus">				                
			<script  type="text/javascript"  src="https://apis.google.com/js/plusone.js"></script>
			<g:plusone size="medium"></g:plusone>
		</div>
		
		<?php echo stripslashes(htmlspecialchars_decode($wd_single_prod_datas["sharing_custom_code"]));?>
		
	</div>              
</div>
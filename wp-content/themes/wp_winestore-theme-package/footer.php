<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Roedok
 * @since WD_Responsive
 */
?>
		<?php do_action( 'wd_before_body_end' ); ?>
		
	</div><!-- #main -->
	
	<div id="footer" role="contentinfo">
	
		
			<?php do_action( 'wd_footer_init' ); ?>
			
		
	</div><!-- #footer -->
	
	<?php do_action( 'wd_before_footer_end' ); ?>
	
</div><!-- #wrapper -->
<?php echo stripslashes(htmlspecialchars_decode(get_option(THEME_SLUG.'code_before_end_body')));?>
<?php echo stripslashes(htmlspecialchars_decode(get_option(THEME_SLUG.'google_analytics')));?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
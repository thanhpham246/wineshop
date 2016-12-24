<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to wpdance_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage RoeDok
 * @since WD_Responsive
 */
?>
<?php
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
			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'wpdance' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
	<?php if( absint($wd_single_post_config['show_comment_list']) == 1 ) : ?>	
		<?php if( absint($wd_single_post_config['show_comment_list_phone']) != 1 ) echo "<div class='hidden-phone'>";?>
			<h3 class="heading-title" id="comments-title"><?php
			global $post;
			?>
			<?php
				echo stripslashes(esc_attr($wd_single_post_config['comment_list_label']));
				echo "<span>(",comments_number('0','1','%'),")</span>";
			?>
			</h3>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
						<div class="navigation">
							<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'wpdance' ) ); ?></div>
							<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'wpdance' ) ); ?></div>
						</div> <!-- .navigation -->
			<?php endif; // check for comment navigation ?>
			
			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use wpdance_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define wpdance_comment() and that will be used instead.
					 * See wpdance_comment() in wpdance/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'wd_theme_comment' ) );
				?>
			</ol>
			
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
						<div class="navigation">
							<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'wpdance' ) ); ?></div>
							<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'wpdance' ) ); ?></div>
						</div><!-- .navigation -->
			<?php endif; // check for comment navigation ?>
			<?php if( $wd_single_post_config['show_comment_list_phone'] != 1 ) echo "</div>";?>
	<?php endif; ?>
<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'wpdance' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php wd_comment_form(); ?>

</div><!-- #comments -->

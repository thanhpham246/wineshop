<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $woocommerce, $product;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! comments_open() )
	return;
	
?>
<div id="reviews"><?php

	echo '<div id="comments">';

	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_rating_count() ) ){
		echo '<h2>';
		printf( _n('%s review for %s', '%s reviews for %s', $count, 'woocommerce'), $count, get_the_title() );
		echo '</h2>';
	} else {
		echo '<h2>'.__( 'Reviews', 'wpdance' ).'</h2>';
	}

	$title_reply = '';

	if ( have_comments() ) :

		echo '<ol class="commentlist">';

		wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) );

		echo '</ol>';

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			echo '<nav class="woocommerce-pagination">';
			paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
			) ) );
			echo '</nav>';
		endif;

	else :

		echo '<p class="noreviews">'.__( 'There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'wpdance' ).'</p>';

	endif;
	echo '</div>';
	
	if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) :
		$commenter = wp_get_current_commenter();

		echo '<div id="review_form_wrapper"><div id="review_form">';

		$comment_form = array(
			'title_reply' => $title_reply,
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'fields' => array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'wpdance' ) . '</label> ' . '<span class="required">*</span>' .
							'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'wpdance' ) . '</label> ' . '<span class="required">*</span>' .
							'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
			),
			'label_submit' => __( 'Submit Review', 'wpdance' ),
			'logged_in_as' => '',
			'comment_field' => ''
		);

		if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {

			$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Rating', 'wpdance' ) .'</label><select name="rating" id="rating">
				<option value="">'.__( 'Rate&hellip;', 'wpdance' ).'</option>
				<option value="5">'.__( 'Perfect', 'wpdance' ).'</option>
				<option value="4">'.__( 'Good', 'wpdance' ).'</option>
				<option value="3">'.__( 'Average', 'wpdance' ).'</option>
				<option value="2">'.__( 'Not that bad', 'wpdance' ).'</option>
				<option value="1">'.__( 'Very Poor', 'wpdance' ).'</option>
			</select></p>';

		}

		$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'wpdance' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

		comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

		echo '</div></div>';
	else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'wpdance' ); ?></p>

	<?php endif; 
?><div class="clear"></div></div>

<?php $_rand_id = "-".rand(); ?>
<form role="search" method="get" id="searchform<?php echo $_rand_id;?>" class="products-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
    <div>
        <label class="screen-reader-text" for="s<?php echo $_rand_id;?>"><?php __( 'Search for:', 'wpdance' ) ;?></label>
        <input type="text" class="search-input" value="<?php get_search_query() ?>" name="s" id="s<?php echo $_rand_id;?>" placeholder="<?php __( 'Search', 'wpdance' ) ?>" />
        <input type="submit" class="search-input-btn" id="searchsubmit<?php echo $_rand_id;?>" value="<?php esc_attr__( 'Search', 'wpdance' ) ?>" />
        <input type="hidden" name="post_type" value="product" />
    </div>
</form>
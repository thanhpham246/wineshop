<?php 
// Catching the Data
function wd_ppbv_page_viewed(){
    if(is_single() && !is_page()){ // only run on posts and not pages
        global $wpdb, $post;
		$ppbv_tablename = $wpdb->prefix.'popular_by_views';
        $wpdb->flush(); // clense the DB interface
        $data = $wpdb->get_row("SELECT * FROM {$ppbv_tablename} WHERE post_id='{$post->ID}'", ARRAY_A); // get the data row that has the matching post ID
        if(!is_null($data)){ // if we have a matching data row
            $new_views = $data['views'] + 1; // increase the views by 1
            $wpdb->query("UPDATE {$ppbv_tablename} SET views='{$new_views}' WHERE post_id='{$post->ID}';"); // update the data row with the new views
            $wpdb->flush(); // clense the DB interface
        }
        else { // if we don't have a matching data row (nobody's viewed the post yet)
            $wpdb->query("INSERT INTO {$ppbv_tablename} (post_id, views) VALUES ('{$post->ID}','1');"); // add a new data row into the DB with the post ID and 1 view
            $wpdb->flush(); // clense the DB interface
        }
    }
}
add_action('wp_head','wd_ppbv_page_viewed'); // attach wd_ppbv_page_viewed to the wp_head hook



// Creating the Admin Widget
function wd_ppbv_admin_widget(){
    echo "<ol id='popular_by_views_admin_list'>"; // create an unordered list
        global $wpdb;// call global for use in function
		$ppbv_tablename = $wpdb->prefix.'popular_by_views';
        $popular = $wpdb->get_results("SELECT * FROM {$ppbv_tablename} ORDER BY views DESC LIMIT 0,10",ARRAY_N); // Order our table by largest to smallest views then get the first 10 (i.e. the top 10 most viewed)
        foreach($popular as $post){ // loop through the returned array of popular posts
            $ID = $post[1]; // store the data in a variable to save a few characters and keep the code cleaner
            $views = number_format($post[2]); // number_format adds the commas in the right spots for numbers (ex: 12543 to 12,543)
            $post_url = get_permalink($ID); // get the URL of the current post in the loop
            $title = get_the_title($ID); // get the title of the current post in the loop
            echo "<li><a href='{$post_url}'>{$title}</a> - {$views} views</li>"; // echo out the information in a list-item
        } // end the loop
    echo "</ol>"; // close out the unordered list
}

function ppbv_add_admin_widget(){
    wp_add_dashboard_widget('popular_by_views', 'Most Popular Posts by Views', 'wd_ppbv_admin_widget'); // creates an admin area widget || wp_add_dashboard_widget([id of div],[title in div],[function to run inside of div])
}
add_action('wp_dashboard_setup','ppbv_add_admin_widget'); // attach ppbv_add_admin_widget to wp_dashboard_setup



// Get List Most Viewed without Widget
function wd_ppbv_display() {
    global $wpdb; // call global for use in function
	$ppbv_tablename = $wpdb->prefix.'popular_by_views';
    echo "<div class='popular_by_views'>"; // create a container
        echo "<h2>Most Popular by Views</h2>"; // write the title
        echo "<ol id='popular_by_views_list'>"; // create an ordered list
            $popular = $wpdb->get_results("SELECT * FROM {$ppbv_tablename} ORDER BY views DESC LIMIT 0,10",ARRAY_N);
            foreach($popular as $post){ // loop through the returned array of popular posts
                $ID = $post[1]; // store the data in a variable to save a few characters and keep the code cleaner
                $views = number_format($post[2]); // number_format adds the commas in the right spots for numbers (ex: 12543 to 12,543)
                $post_url = get_permalink($ID); // get the URL of the current post in the loop
                $title = get_the_title($ID); // get the title of the current post in the loop
                echo "<li><a href='{$post_url}'>{$title}</a> - {$views} views</li>"; // echo out the information in a list-item
            } // end the loop
        echo "</ol>"; // close the ordered list
    echo "</div>"; // close the container
}
?>
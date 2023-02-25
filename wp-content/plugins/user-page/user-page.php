<?php
/**
 * Plugin Name: User Data Plugin
 * Description: Retrieves user data based on the user ID passed in the URL parameters of the current page.
 * Version: 1.0
 * Author: Berny Itoutou
 * Author URI: https://okafrancois.com
 */

// Add shortcode to display user data
function user_data_shortcode( $atts ) {
    // Retrieve user ID from URL parameters
    $user_id = isset( $_GET['user_id'] ) ? intval( $_GET['user_id'] ) : 0;

    // Retrieve user data
    $user_data = get_userdata( $user_id );

    // Display user data
    ob_start();
    ?>
    <div class="user-data">
        <h2><?php echo $user_data->display_name; ?></h2>
        <p>Email: <?php echo $user_data->user_email; ?></p>
        <p>Role: <?php echo $user_data->roles[0]; ?></p>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'user_data', 'user_data_shortcode' );

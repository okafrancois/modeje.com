<?php 
add_action( 'wp_enqueue_scripts', 'listeo_enqueue_styles' );
function listeo_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css',array('bootstrap','font-awesome-5','font-awesome-5-shims','simple-line-icons','listeo-woocommerce') );

}


 
function remove_parent_theme_features() {
   	
}
add_action( 'after_setup_theme', 'remove_parent_theme_features', 10 );
function user_count_shortcode() {
    $start_value = 200;
    $user_count = count_users();
    return '<p class="members-count"><span class="members-count__value">' . ($start_value + $user_count['total_users']) . '</span> Membres</p>';
}
add_shortcode('user_count', 'user_count_shortcode');

?>
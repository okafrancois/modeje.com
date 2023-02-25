/**
* Plugin Name: User Page
* Plugin URI: https://okafrancois.com
* Description: This plugin adds new functionality to your WordPress site.
* Version: 1.0.0
* Author: Berny Itoutou
* Author URI: https://okafrancois.com
**/


function my_plugin_shortcode( $atts, $content = null ) {
// shortcode code goes here
}

add_shortcode( 'my_shortcode', 'my_plugin_shortcode' );

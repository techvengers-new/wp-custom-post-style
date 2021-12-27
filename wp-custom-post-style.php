<?php
/**
 * Plugin Name:       WP Custom Post Style
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       wp-custom-post-style
 */
require_once 'register-post-type.php';

function add_my_custom_page() {
    // Create post object
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'My Custom Page' ),
      'post_content'  => '<h4>New Page</h4>',
      'post_status'   => 'publish',
      'post_type'     => 'page',
    );
    wp_insert_post( $my_post );
}

register_activation_hook(__FILE__, 'add_my_custom_page');
function on_deactivating_your_plugin() {
    $page = get_page_by_path( 'My Custom Page' );
    wp_delete_post($page->ID);
}
register_deactivation_hook( __FILE__, 'on_deactivating_your_plugin' );
//Uninstalling
register_uninstall_hook( __FILE__, 'my_fn_uninstall' );

function my_fn_uninstall() {
    delete_option( 'wp-custom-post-style' );
}
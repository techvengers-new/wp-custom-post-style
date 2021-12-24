<?php
function pluginprefix_setup_post_type() {
    register_post_type( 'book', ['public' => true ] ); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );
// Plugin Activation
function wp_custom_post_style_activate() {
    pluginprefix_setup_post_type();
    flush_rewrite_rules(); 
}
register_activation_hook( 'wp-custom-post-style', 'wp_custom_post_style_activate' );
// Plugin Deactivation
function wp_custom_post_style_deactivate() {
    unregister_post_type( 'book' );
    flush_rewrite_rules();
}
register_deactivation_hook( 'wp-custom-post-style', 'wp_custom_post_style_deactivate' );
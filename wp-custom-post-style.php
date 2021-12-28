<?php
/**
 * Plugin Name:       WP Custom Post Style
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       wp-custom-post-style
 */



function plugin_activate_tech() {
	global $wpdb;
	$table_name = $wpdb->prefix.'techvengers';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	     //table not in database. Create new table
	     $charset_collate = $wpdb->get_charset_collate();
	  
	     $sql = "CREATE TABLE $table_name (
	          id mediumint(9) NOT NULL AUTO_INCREMENT,
	          field_x text NOT NULL,
	          field_y text NOT NULL,
	          UNIQUE KEY id (id)
	     ) $charset_collate;";
	     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	     dbDelta( $sql );
	}
	else{
	 
	}
}


register_activation_hook( __FILE__, 'plugin_activate_tech' );

function wp_custom_settings(){

}

function register_my_menu(){
	add_submenu_page('tools.php','WP Custom','WP Custom Settings','manage_options','wp-custom-settings','wp_custom_settings',50);
}
add_action('admin_menu','register_my_menu');
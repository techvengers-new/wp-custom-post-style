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
	register_setting('wp-custom-settings','wp_upload_custon_page');
	add_settings_section('wp_upload_custon_page_section','WP Custom Upload','my_upload_cb','wp-custom-settings');
	add_settings_field('hello_my_id','Hello Field','my_upload_cb_field','wp-custom-settings','wp_upload_custon_page_section');
}

function my_upload_cb(){
	echo '<p>Hello</p>';
}
function my_upload_cb_field(){
	$setting = get_option('wp_upload_custon_page');?>
	<input type="file" name="wp_upload_custon_page" value="<?php echo isset($setting) ? esc_attr($setting) : '';?>">
	<?php
}

function register_my_menu(){
	add_submenu_page('tools.php','WP Custom','WP Custom Settings','manage_options','wp-custom-settings','wp_custom_settings',50);
}
add_action('admin_menu','register_my_menu');


function form_page_settings(){
	if(!is_admin()){
		return;
	}
	?>
	<form action="options.php" method="post">
	<?php
		settings_fields('wp-custom-settings');
		do_settings_sections('wp-custom-settings');
		submit_button('Upload');
	?>
	</form>
	<?php
}
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

//Setting page HTML
function wptech_setting_page_html(){
	if(!is_admin()){
		return;
	}
	?>
	 <div class="wrap">
	 	<form action="options.php" method="post">
	 		<?php
	 			settings_fields('wp-custom-settings');
	 			do_settings_sections('wp-custom-settings');
	 			submit_button('Save Changes');
	 		?>
	 	<!-- 	<input type="text" name="">
	 		<button type="submit">Submit</button> -->
	 	</form>
	 </div>
	

	
	<?php
		 
}
function register_my_menu(){
	add_menu_page('WP Custom','WP Custom Settings','manage_options','wp-custom-settings','wptech_setting_page_html', 'dashicons-database',50);
}

add_action('admin_menu','register_my_menu');
//
function wptech_plugin_settings(){

	// register a new setting for "wp-custom-settings" page
    register_setting('wp-custom-settings', 'wptech_file_upload');
 
    // register a new section in the "wp-custom-settings" page
    add_settings_section(
        'wptech_file_upload_setting',
        'WP Tech Upload', 'wptech_file_upload_setting_cb',
        'wp-custom-settings'
    );
 
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'wptech_settings_upload_field',
        'Upload file', 'wptech_settings_upload_field_cb',
        'wp-custom-settings',
        'wptech_file_upload_setting'
    );
}



function wptech_file_upload_setting_cb(){
	echo "<p class'text-danger'>Upload file in .xlxs</p>";
}

function wptech_settings_upload_field_cb(){
// get the value of the setting we've registered with register_setting()
    $setting = get_option('wptech_file_upload');
    // output the field
    ?>
    <input type="text" name="wptech_file_upload" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}

add_action('admin_init','wptech_plugin_settings');
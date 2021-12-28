<?php
/**
 * Plugin Name:       WP Custom Post Style
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       wp-custom-post-style
 */


class WpTechvengers
{
	// contructor function 

	function __construct(){
		add_action('admin_menu',array($this,'register_my_menu'));

		
	}

	// plugin activation code

	function activation()
	{	
		flush_rewrite_rules();
		$this->table_create();
	}

	// Creating table in database 

	function table_create() {

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
}

	// Form HTML code

	function form_html_code(){

		$html = '<h1>Wp Techvengers</h1>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="doc"/>
			<input type="submit" name="submit"/>
		</form>';
		echo $html;
	}

	//Setting page HTML code

	function wptech_setting_page_html(){
		if(!is_admin()){
			return;
		}
		$dir1 = plugin_dir_path( __FILE__ ).'PHPExcel/PHPExcel.php';
		$dir2 = plugin_dir_path( __FILE__ ).'PHPExcel/PHPExcel/IOFactory.php';
		
		if(isset($_POST['submit'])){
		$file=$_FILES['doc']['tmp_name'];


		$ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
		if($ext=='xlsx'){
			
			
			require($dir1);
			require($dir2);
			
			
			$obj=PHPExcel_IOFactory::load($file);
			foreach($obj->getWorksheetIterator() as $sheet){
				$getHighestRow=$sheet->getHighestRow();
				for($i=0;$i<=$getHighestRow;$i++){
					$name=$sheet->getCellByColumnAndRow(0,$i)->getValue();
					$email=$sheet->getCellByColumnAndRow(1,$i)->getValue();
					if($name!=''){
						global $wpdb;    
						$result = $wpdb->get_results( "insert into wp_techvengers(name,email) values('$name','$email')");
						
					}
				}
			}
		}else{
			echo "Invalid file format";
		}
		}
	

	$this->form_html_code();
		
		
	
	}

	// Custom post type (menu on left sidebar)

	function register_my_menu(){
	add_menu_page('WP Custom','WP Techvengers','manage_options','wp-custom-settings',array($this,'wptech_setting_page_html'), 'dashicons-database',50);
	}


	

	
	// plugin deactivation code

	function deactivation()
	{
		
	}
	// plugin uninstallation code
	function uninstall()
	{
		
	}
}

if( class_exists('WpTechvengers')){
	$wpTechvengers = new WpTechvengers();
}

register_activation_hook( __FILE__, array($wpTechvengers, 'activation') );






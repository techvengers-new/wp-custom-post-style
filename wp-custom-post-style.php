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

// 	global $user_ID;
// $new_post = array(
// 'post_title' => 'My New Post',
// 'post_content' => 'Lorem ipsum dolor sit amet...',
// 'post_status' => 'publish',
// 'post_date' => date('Y-m-d H:i:s'),
// 'post_author' => $user_ID,
// 'post_type' => 'post',
// 'post_category' => array(0)
// );
// $post_id = wp_insert_post($new_post);
}

	// Form HTML code

	function form_html_code(){

		$html = '<h1>Wp Techvengers</h1>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="doc"/>
			<input class="button-primary" type="submit" name="submit"/>
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
				for($i=2;$i<=$getHighestRow;$i++){
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






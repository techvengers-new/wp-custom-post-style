<?php
/**
 * Plugin Name:      Tech Fetch
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       tech-fetch
 */


class WpTechvengers
{
	// contructor function 

	function __construct(){
		add_action('admin_menu',array($this,'register_my_menu'));
		$plugin = plugin_basename( __FILE__ );
		add_filter( "plugin_action_links_$plugin", array($this, 'plugin_add_settings_link') );
		
	}

	// plugin activation code

	function activation()
	{	
		flush_rewrite_rules();
		add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
		
	}

	// setting link in plugin

	function plugin_add_settings_link( $links ) 
	{
	    $settings_link = '<a href="admin.php?page=general-settings">' . __( 'Settings' ) . '</a>';
	    array_push( $links, $settings_link );
	  	return $links;
	}

	

	// Form HTML code

	function form_html_code()
	{
		require_once(plugin_dir_path( __FILE__ ).'/inc/templates/basic-form.php');

	
	}

	function make_cat()
	{
		  wp_insert_term(
		  'Example Category','category',
			array(
		    'description' => 'This is an example category created with wp_insert_term.',
		     'slug'    => 'example-category'
		    )

		  );
	}

	// image uploading in wordpress media

	function upload_img_media()
	{
		$image_url = 'https://techvengers.com/wp-content/uploads/2021/10/TechVengers_2-204-x57_2a58b24036cd0e64724a89791828023a.png';

		$upload_dir = wp_upload_dir();

		$image_data = file_get_contents( $image_url );

		$filename = basename( $image_url );

		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
		  $file = $upload_dir['path'] . '/' . $filename;
		}
		else {
		  $file = $upload_dir['basedir'] . '/' . $filename;
		}

		file_put_contents( $file, $image_data );

		$wp_filetype = wp_check_filetype( $filename, null );

		$attachment = array(
		  'post_mime_type' => $wp_filetype['type'],
		  'post_title' => sanitize_file_name( $filename ),
		  'post_content' => '',
		  'post_status' => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $file );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
	}

	//Setting page HTML code

	function wptech_setting_page_html()
	{
		global $user_ID;
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

					$post_title=$sheet->getCellByColumnAndRow(0,$i)->getValue();
					$post_content=$sheet->getCellByColumnAndRow(1,$i)->getValue();
					$post_status='publish';
					$post_date=date('Y-m-d H:i:s');
					$post_author=$user_ID;
					$post_type='post';
					$post_category=$sheet->getCellByColumnAndRow(2,$i)->getValue();



					if($post_title!=''){
						global $wpdb;    
						$new_post = array(
						'post_title' => $post_title,
						'post_content' => $post_content,
						'post_status' => $post_status,
						'post_date' => $post_date,
						'post_author' => $user_ID,
						'post_type' => $post_type,
						'post_category' => $post_category
						);
						$post_id = wp_insert_post($new_post);
						
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
	add_menu_page('Tech Fetch','Tech Fetch','manage_options','general-settings',array($this,'wptech_setting_page_html'), 'dashicons-database',50);
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








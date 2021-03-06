<?php
/**
 * Plugin Name:      Tech Fetch
 * Plugin URI:        #
 * Description:       Import data from Excel (xlsx) file
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       tech-fetch
 */


class WpTechvengers
{
	// contructor function 

	function __construct(){
		// including css files
		$this->plugin_scripts();
		add_action('admin_menu',array($this,'register_my_menu'));
		$plugin = plugin_basename( __FILE__ );
		add_filter( "plugin_action_links_$plugin", array($this, 'plugin_add_settings_link') );
		
	}
	// enqueue css & js files

	public function plugin_scripts(){

		wp_enqueue_style( 'style',plugins_url('/inc/assets/css/style.css', __FILE__ ));
	}

	// plugin activation function

	function activation()
	{	
		flush_rewrite_rules();
	}
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

	public function my_acf_add_local_field_groups() {

		acf_add_local_field_group(array(
			'key' => 'group_1',
			'title' => 'My Group',
			'fields' => array (
				array (
					'key' => 'field_1',
					'label' => '$hello',
					'name' => 'sub_title',
					'type' => 'text',
				)
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'post',
					),
				),
			),
		));
		
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
					$post_image=$sheet->getCellByColumnAndRow(2,$i)->getValue();
					$post_category=$sheet->getCellByColumnAndRow(3,$i)->getValue();;
					// $image_id_new = $this->image_get_id($post_image);
					// $new_cat=$this->category_get_id($post_category);
						
					}
				}
			}else{
				echo "Invalid file format";
			}
		}

	$this->form_html_code();
	//echo $this->my_acf_add_local_field_groups('hellosir');

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

//$wpTechvengers->my_acf_add_local_field_groups('hellosir');

register_activation_hook( __FILE__, array($wpTechvengers, 'activation') );

add_filter('acf/init', array($wpTechvengers, 'my_acf_add_local_field_groups',));
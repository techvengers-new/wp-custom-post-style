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



// if(isset($_POST['submit'])){
// 	$file=$_FILES['doc']['tmp_name'];
	
// 	$ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
// 	if($ext=='xlsx'){
// 		require('PHPExcel/PHPExcel.php');
// 		require('PHPExcel/PHPExcel/IOFactory.php');
		
		
// 		$obj=PHPExcel_IOFactory::load($file);
// 		foreach($obj->getWorksheetIterator() as $sheet){
// 			$getHighestRow=$sheet->getHighestRow();
// 			for($i=0;$i<=$getHighestRow;$i++){
// 				$name=$sheet->getCellByColumnAndRow(0,$i)->getValue();
// 				$email=$sheet->getCellByColumnAndRow(1,$i)->getValue();
// 				if($name!=''){
// 					mysqli_query($con,"insert into user(name,email) values('$name','$email')");
// 				}
// 			}
// 		}
// 	}else{
// 		echo "Invalid file format";
// 	}
// }
?>
<!-- // <form method="post" enctype="multipart/form-data">
// 	<input type="file" name="doc"/>
// 	<input type="submit" name="submit"/>
// </form> -->
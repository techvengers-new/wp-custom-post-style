<?php
/**
 * Plugin Name:       WP Custom Post Style
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       wp-custom-post-style
 */
register_activation_hook( __FILE__, 'plugin_activate_tech' );

global $jal_db_version;
$jal_db_version = '1.0';

function plugin_activate_tech() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'liveshoutbox';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		text text NOT NULL,
		url varchar(55) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}



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
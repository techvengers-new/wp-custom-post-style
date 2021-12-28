<?php
$con=mysqli_connect('localhost','root','','youtube');
if(isset($_POST['submit'])){
	$file=$_FILES['doc']['tmp_name'];
	
	$ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
	if($ext=='xlsx'){
		require('PHPExcel/PHPExcel.php');
		require('PHPExcel/PHPExcel/IOFactory.php');
		
		
		$obj=PHPExcel_IOFactory::load($file);
		foreach($obj->getWorksheetIterator() as $sheet){
			$getHighestRow=$sheet->getHighestRow();
			for($i=0;$i<=$getHighestRow;$i++){
				$name=$sheet->getCellByColumnAndRow(0,$i)->getValue();
				$email=$sheet->getCellByColumnAndRow(1,$i)->getValue();
				if($name!=''){
					mysqli_query($con,"insert into user(name,email) values('$name','$email')");
				}
			}
		}
	}else{
		echo "Invalid file format";
	}
}
?>
<form method="post" enctype="multipart/form-data">
	<input type="file" name="doc"/>
	<input type="submit" name="submit"/>
</form>
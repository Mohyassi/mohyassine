<?php
include ('../db.php');

extract($_POST);
if(empty($id)){
	$insert = mysqli_query($con,"INSERT INTO brands set brand_title = '$name' ");
	if($insert){
		echo 1;
	}
}else{
	$save = mysqli_query($con,"UPDATE brands set brand_title = '$name' where brand_id = '$id' ");
	if($save){
		echo 1;
	}
}
mysqli_close($con);

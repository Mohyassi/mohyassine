<?php
include ('../db.php');

extract($_POST);
if(empty($id)){
	$insert = mysqli_query($con,"INSERT INTO categories set cat_title = '$name' ");
	if($insert){
		echo 1;
	}
}else{
	$save = mysqli_query($con,"UPDATE categories set cat_title = '$name' where cat_id = '$id' ");
	if($save){
		echo 1;
	}
}
mysqli_close($con);

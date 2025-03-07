<?php
include '../db.php';

$data = mysqli_query($con,"DELETE FROM categories where cat_id=".$_GET['id']);
if($data)
	echo 1;
mysqli_close($con);
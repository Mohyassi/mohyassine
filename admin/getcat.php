<?php
include '../db.php';

$data = mysqli_query($con,"SELECT * FROM categories where cat_id=".$_GET['id']);
echo json_encode(mysqli_fetch_array($data));
mysqli_close($con);
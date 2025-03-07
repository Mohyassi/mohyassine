<?php
session_start();
include '../db.php';
extract($_POST);
 $qry =mysqli_query($con,"SELECT * FROM admin_info where username = '$username' and password = '".md5($password)."' ");
 if(mysqli_num_rows($qry) > 0 ){
 	foreach(mysqli_fetch_array($qry) as $k => $v){
 		if($k != 'password' && !is_numeric($k)){
 			$_SESSION['login_'.$k] = $v;
 		}
 	}
 	echo 1;
 }
<?php
session_start();
if(!isset($_SESSION['login_admin_id'])){
	header('Location:login.php');
}
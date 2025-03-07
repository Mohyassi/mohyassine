<?php

include("../db.php");
extract($_POST);

$picture_name=$_FILES['picture']['name'];
$picture_type=$_FILES['picture']['type'];
$picture_tmp_name=$_FILES['picture']['tmp_name'];
$picture_size=$_FILES['picture']['size'];
if(empty($product_id)){

if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
{
	if($picture_size<=50000000)
	
		$pic_name=time()."_".$picture_name;
		move_uploaded_file($picture_tmp_name,"../product_images/".$pic_name);
		
mysqli_query($con,"insert into products (product_cat, product_brand,product_title,product_price, product_desc, product_image,product_keywords) values ('$category_id','$brand_id','$product_name','$price','$details','$pic_name','$tags')");

echo 1;
}
}else{

	if($picture_tmp_name !=''){
		if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
{
	if($picture_size<=50000000)
	
		$pic_name=time()."_".$picture_name;
		move_uploaded_file($picture_tmp_name,"../product_images/".$pic_name);
		
mysqli_query($con,"UPDATE products set product_cat= '$category_id',
 product_brand= '$brand_id',
 product_title= '$product_name',
 product_price= '$price',
 product_desc= '$details',
 product_image= '$pic_name',
 product_keywords='$tags'  where product_id = $product_id ");

echo 1;
	}
}else{
	mysqli_query($con,"UPDATE products set product_cat= '$category_id',
 product_brand= '$brand_id',
 product_title= '$product_name',
 product_price= '$price',
 product_desc= '$details',
 product_keywords='$tags'  where product_id = $product_id ");
echo 1;
}
}
mysqli_close($con);

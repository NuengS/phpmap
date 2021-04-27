<?php

include("mysql.php");
$mysql = new J_MYSQL;
$mysql->J_Connect();
$mysql->set_char_utf8();

$path = $_FILES["image_file"]["tmp_name"];
$file_name = $_FILES["image_file"]["name"];
$ext = pathinfo($file_name,PATHINFO_EXTENSION);
$new_file_name = time().".".$ext;
$newPath = "images/";

if(move_uploaded_file($path,$newPath.$new_file_name)){

    $arr = array(
        "location_name" => $_POST["location_name"],
        "lat" => $_POST["lat"],
        "lng" => $_POST["lng"],
        "location_detail" => $_POST["location_detail"],
        "image_name" => $new_file_name
    );
    $rs = $mysql->J_Insert($arr,"tbl_location");
}



$mysql->J_Close();
?>
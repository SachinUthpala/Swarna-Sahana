<?php


$ServerName = "localhost";
$UserName = "root";
$Password = "" ;
$DbName = "sw";


// $ServerName = "localhost";
// $UserName = "u115172255_swarna_sahana";
// $Password = "*8ko&JzNqD" ;
// $DbName = "u115172255_swarna_sahana";

$conn = new mysqli($ServerName , $UserName , $Password , $DbName);

if($conn->connect_error){
    echo "connection Fail";
}



?>
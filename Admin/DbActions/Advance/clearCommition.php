<?php

require_once '../Db.conn.php';
session_start();

$sql = "TRUNCATE TABLE  commition_total";
$result = mysqli_query($conn , $sql);

$sql2 = "TRUNCATE TABLE   taskcreatorcommition";
$result2 = mysqli_query($conn , $sql2);

header("Location: ../../AdminPanel/AllCommitions.php");


?>
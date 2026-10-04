<?php

require_once '../Db.conn.php';
session_start();

$sql = "TRUNCATE TABLE total_expencess";
$result = mysqli_query($conn , $sql);

$sqk2 = "TRUNCATE TABLE expencess";
$result2 = mysqli_query($conn , $sqk2);

header("Location: ../../AdminPanel/ExpencessSummery.php");


?>
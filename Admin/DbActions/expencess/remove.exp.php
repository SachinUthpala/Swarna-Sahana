<?php

require_once '../Db.conn.php'; 
session_start();

$expId = (int)$_POST['expID'];
$sql = "DELETE FROM `expencess` WHERE expenxess_id = $expId";
$result = mysqli_query($conn , $sql);

header("Location: ../../AdminPanel/myAllExpencess.php");




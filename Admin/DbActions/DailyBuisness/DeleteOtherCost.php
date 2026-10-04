<?php




require_once '../Db.conn.php';
session_start();


$id = $_POST['delete_id'];

$sql = "DELETE FROM `dailyothercost` WHERE costId = $id";
$result = mysqli_query($conn , $sql);

$_SESSION['TaskCreated'] = 1;
header("Location: ../../AdminPanel/AllDailyOtherCost.php");
<?php

require_once '../Db.conn.php';
session_start();

if(isset($_POST['dailyBuisness'])){
    $date = $_POST['Date'];
    $time = $_POST['Time'];
    $weight = (float)$_POST['Weight'];
    $buyingPrice = (float)$_POST['BuyingPrice'];
    $selligPrice = (float)$_POST['SellingPrice'];

    $sql = "INSERT INTO `dailybuisness`( `weight`, `buyingPrice`, `sellingPrice`, `date`, `time`) 
    VALUES ($weight , $buyingPrice , $selligPrice , '$date' , '$time')";

    $result = mysqli_query($conn ,  $sql);

    $_SESSION['TaskCreated'] = 1;
    header("Location: ../../AdminPanel/CreateDailyBuisness.php");

}
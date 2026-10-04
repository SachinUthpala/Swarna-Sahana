<?php


require_once '../Db.conn.php';
session_start();

if(isset($_POST['dailyBuisness'])){
    $costType = $_POST['Weight'];
    $costAmount = $_POST['BuyingPrice'];
    $date = $_POST['Date'];
    $time = $_POST['Time'];
    $sql = "INSERT INTO `dailyothercost`( `costType`, `date`, `time`, `amount`) VALUES ( '$costType' , '$date' , '$time' , $costAmount )";
    $result = mysqli_query($conn , $sql);

    $_SESSION['TaskCreated'] = 1;
    header("Location: ../../AdminPanel/createDailyOtherCost.php");
}



?>
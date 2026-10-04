<?php

require_once '../Db.conn.php';
session_start();




    $id = $_POST['expencessID'];
    $date = $_POST['Date'];
    $distance = $_POST['distance'];

    $cost = $distance * 6;

    $sql = "UPDATE `expencess` SET `amount`='$cost' , `distance`='$distance' , `date`='$date' , `approved_exp`= 0 WHERE expenxess_id = $id";
    $result = mysqli_query($conn , $sql);
    $_SESSION['expencessReject'] = 1;
    header("Location: ../../AdminPanel/MyRejected.php");
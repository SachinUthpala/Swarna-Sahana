<?php

require_once '../Db.conn.php';
session_start();


if(isset($_POST['createTask'])){

$createdUser =  $_SESSION['UserId'];
    
    $userId = $_POST['userId'];
    $Inquery_Number = $_POST['Inquery_Number'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $bank = $_POST['bank'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $weight = $_POST['weight'];
    $note = $_POST['note'];
    $createdBy = $_POST['createBy'];

    $sql = "INSERT INTO `task`( `select_user`, `inqueryNumber`, `date`, `time`, `customerName`, `Phone`, `bank_shop`, `city`, `enterPrice`, `location` , `weight` , `note` , `createdBy`) 
    VALUES ( '$userId' , '$Inquery_Number' ,'$date' ,'$time' ,'$customer_name' ,'$phone' ,'$bank' ,'$city' ,'$price' ,'$location' ,'$weight' , '$note' , '$createdUser')";

    $result = mysqli_query($conn , $sql);

    if($result){
        
        $_SESSION['TaskCreated'] = 1;
        header("Location: ../../AdminPanel/createTask.php");
        echo "Task Created Successfully";
      
    }else{
        echo "Task Not Created";
    }

}



?>
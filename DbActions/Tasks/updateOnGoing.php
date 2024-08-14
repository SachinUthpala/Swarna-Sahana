<?php

require_once '../Db.conn.php';
session_start();



if(isset($_POST['createTask'])){
    
    $id = (int)$_POST['id'];
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


    
    $sql = "UPDATE `task` SET `select_user`='$userId',`inqueryNumber`='$Inquery_Number',`date`='$date',
    `time`='$time',`customerName`='$customer_name',`Phone`='$phone',`bank_shop`='$bank',
    `city`='$city',`enterPrice`='$price',`location`='$location' WHERE  `task_id = $id";



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
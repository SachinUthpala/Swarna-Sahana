<?php

require_once '../Db.conn.php';
session_start();


    $userId = (int)$_POST['delete_id'];
    
  

    $sql = "DELETE FROM `users` WHERE UserId = $userId";
    $result = mysqli_query($conn , $sql);

    if($result){
        $_SESSION['userDeleted']  = 1 ;
        header("Location: ../../AdminPanel/DeleteUser.php");
        echo "Task Completed Successfully";
    }
    



?>
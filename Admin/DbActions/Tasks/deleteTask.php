<?php

require_once '../Db.conn.php';
session_start();



    $taskId = (int)$_POST['delete_id'];

    $sql = "DELETE FROM `task` WHERE task_id = $taskId";
    $result = mysqli_query($conn , $sql);

    if($result){
        $_SESSION['taskDeleted']  = 1 ;
        header("Location:../../AdminPanel/deleteTask.php");
    }

    else{
        $_SESSION['taskNotDeleted']  = 1 ;
        header("Location:../../AdminPanel/deleteTask.php");
    }

    mysqli_close($conn);

    exit();




?>
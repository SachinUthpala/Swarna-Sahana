<?php

require_once '../Db.conn.php';


if(isset($_POST['logIn'])){

    $userMail = $_POST['email'];
    $userPassword = $_POST['pass'];


    $sql = "SELECT * FROM users WHERE userMail = '$userMail'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($userPassword, $row['UserPassword'])){
            session_start();

            $_SESSION['UserId'] = $row['UserId'];
            
            $_SESSION['UserName'] = $row['UserName'];
            $_SESSION['UserMail'] = $row['UserMail'];
            $_SESSION['AdminAccess'] = $row['AdminAccess'];
            $_SESSION['userImage'] = $row['userImage'];
            $_SESSION['idVerification'] = $row['idVerification'];

            header('Location: ../../AdminPanel/admin.php');

            echo "Successfull";
        }else{
            echo "Password is incorrect";
        }
    }else{
        echo "Email is incorrect";
    }

    
    
}



?>
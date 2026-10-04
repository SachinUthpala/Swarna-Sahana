<?php

require_once '../Db.conn.php';
session_start();


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
            
            if($row['AdminAccess'] == 2 && $row['promotionLevel'] == 6 ) {
                 $_SESSION['AdminAccess'] = 12;
            }
            
            
            
           
            $_SESSION['userImage'] = $row['userImage'];
            $_SESSION['idVerification'] = $row['idVerification'];

            header('Location: ../../AdminPanel/admin.php');

            echo "Successfull";
        }else{
            echo "Password is incorrect";
            $_SESSION['login_error'] = 1;
            header('Location: ../../index.php');
        }
    }else{
        echo "Email is incorrect";
        $_SESSION['login_error'] = 1;
        header('Location: ../../index.php');
    }

    
    
}



?>
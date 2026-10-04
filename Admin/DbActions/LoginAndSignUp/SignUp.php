<?php

require_once '../Db.conn.php';
session_start();

if (isset($_POST['createUser'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $adminAccess = (int)$_POST['adminAcc'];

    $bycriptPass = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `users`( `UserName`, `UserMail`, `UserPassword` , `AdminAccess`) VALUES ('$name', '$email', '$bycriptPass', $adminAccess)";

    $result = mysqli_query($conn, $sql);

    if($adminAccess == 2){
        $sql2 = "INSERT INTO `taskcreatorcommition`(`taskCreatorName`, `Commition`) 
        VALUES ('$name' , 0) ";
        $result2 = mysqli_query($conn , $sql2);
    }

    if ($result) {
        echo "User Created Successfully";
        $_SESSION['userCreated'] = 1;
        header("Location: ../../AdminPanel/createUser.php");
    } else {
        echo "User Not Created";
        $_SESSION['userNotCreated'] = 1;
        header("Location: ../../AdminPanel/createUser.php");
    }
}

?>

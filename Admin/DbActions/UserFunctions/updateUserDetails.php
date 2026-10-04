<?php

require_once '../Db.conn.php';
session_start();

if (isset($_POST['update_userid'])) {
    $userId = (int)$_POST['update_userid'];
    $userName = mysqli_real_escape_string($conn, $_POST['update_username']);
    $userMail = mysqli_real_escape_string($conn, $_POST['update_usermail']);
    $idVer = (int)$_POST['update_idver'];
    $adminAccess = (int)$_POST['update_admin'];
    $promoLevel = (int)$_POST['update_promo'];

    $sql = "UPDATE `users` SET 
            `UserName` = '$userName',
            `UserMail` = '$userMail',
            `idVerification` = $idVer,
            `AdminAccess` = $adminAccess,
            `promotionLevel` = $promoLevel
            WHERE `UserId` = $userId";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['userUpdated'] = 1;
    } else {
        $_SESSION['userUpdated'] = 0;
    }
}

header("Location: ../../AdminPanel/UpdateUser.php");
exit();

?>

<?php

require_once '../Db.conn.php';
session_start();


if (isset($_POST['completeTask'])) {
    // Retrieve POST data
    $idTask = $_POST['taskId'];
    $id = $_POST['ID_Number'];
    $weight = $_POST['weight'];
    $date = $_POST['date'];
    $time = $_POST['time'];


    $sql = "UPDATE `complete_task` SET `IdNumber`='[value-2]',`weight`='[value-3]',`jewelryImg`='[value-4]',`Id_image`='[value-5]',`receipt_img`='' WHERE 1"

    // Jewelry image upload
    if (isset($_FILES['jewelry'])) {
        $jewelry_img = $_FILES['jewelry'];
        $j_img_name = $jewelry_img['name'];
        $j_img_tmp = $jewelry_img['tmp_name'];
        $j_img_separate = explode('.', $j_img_name);
        $file_extension = strtolower(end($j_img_separate)); // Use end() to get the last element
        $extensions = array('jpeg', 'jpg', 'png');

        if (in_array($file_extension, $extensions)) {
            $j_upload_path = '../../WebImages/JewelaryImg/' . $j_img_name;
            move_uploaded_file($j_img_tmp, $j_upload_path);
            $j_img_path = 'WebImages/JewelaryImg/' . $j_img_name;
        } else {
            echo "Jewelry file not supported";
        }
    }

    // ID image upload
    if (isset($_FILES['id_image']) ) {
        $id_img = $_FILES['id_image'];
        $id_name = $id_img['name'];
        $id_tmp = $id_img['tmp_name'];
        $id_separate = explode('.', $id_name);
        $file_extension = strtolower(end($id_separate));
        $extensions = array('jpeg', 'jpg', 'png');

        if (in_array($file_extension, $extensions)) {
            $id_upload_path = '../../WebImages/UserId/' . $id_name;
            move_uploaded_file($id_tmp, $id_upload_path);
            $id_img_path = 'WebImages/UserId/' . $id_name;
        } else {
            echo "ID file not supported";
        }
    }

    // Receipt image upload
    if (isset($_FILES['recipt_image']) ) {
        $recit_img = $_FILES['recipt_image'];
        $recit_name = $recit_img['name'];
        $recit_tmp = $recit_img['tmp_name'];
        $recit_separate = explode('.', $recit_name);
        $file_extension = strtolower(end($recit_separate));
        $extensions = array('jpeg', 'jpg', 'png');

        if (in_array($file_extension, $extensions)) {
            $recit_upload_path = '../../WebImages/Recepts/' . $recit_name;
            move_uploaded_file($recit_tmp, $recit_upload_path);
            $recit_img_path = 'WebImages/Recepts/' . $recit_name;
        } else {
            echo "Receipt file not supported";
        }
    }

    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Task completed successfully";

        $sql_taskUpdate = "UPDATE `task` SET `completion`= 2 WHERE  `task_id` = $idTask";
        $result_taskUpdate = mysqli_query($conn, $sql_taskUpdate);

        header('Location: ../../AdminPanel/MyAllTask.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);



}




































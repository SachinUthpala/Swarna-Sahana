<?php

require_once '../Db.conn.php';
session_start();

// Retrieve POST data
$idNumber = $_POST['ID_Number'];
$idTask = $_POST['taskId'];
$weight = $_POST['weight'];
$date = $_POST['date'];
$time = $_POST['time'];
$price = (int)$_POST['price'];

// Commission calculation based on price
if ($price <= 49999) {
    $commition = 1000;
} else if ($price > 49999 && $price <= 99999) {
    $commition = 1000;
} else if ($price > 99999 && $price <= 149999) {
    $commition = 1500;
} else if ($price > 149999 && $price <= 199999) {
    $commition = 2000;
} else if ($price > 199999 && $price <= 249999) {
    $commition = 2500;
} else if ($price > 249999 && $price <= 299999) {
    $commition = 3000;
} else if ($price > 299999 && $price <= 349999) {
    $commition = 3500;
} else if ($price > 349999 && $price <= 399999) {
    $commition = 4000;
} else if ($price > 399999 && $price <= 449999) {
    $commition = 4500;
} else if ($price > 449999 && $price <= 499999) {
    $commition = 5000;
} else {
    $commition = 5000;
}

// Jewelry image upload handling
$j_img_paths = [];
for ($i = 1; $i <= 5; $i++) {
    $jewelry_image = isset($_FILES['jewelry' . ($i == 1 ? '' : $i)]) ? $_FILES['jewelry' . ($i == 1 ? '' : $i)] : null;
    if ($jewelry_image && $jewelry_image['error'] == 0) {
        $j_img_name = $jewelry_image['name'];
        $j_img_tmp = $jewelry_image['tmp_name'];
        $j_img_separate = explode('.', $j_img_name);
        $file_extension = strtolower(end($j_img_separate));
        $extensions = array('jpeg', 'jpg', 'png');
        if (in_array($file_extension, $extensions)) {
            $j_upload_path = '../../WebImages/JewelaryImg/' . $j_img_name;
            move_uploaded_file($j_img_tmp, $j_upload_path);
            $j_img_paths[] = 'WebImages/JewelaryImg/' . $j_img_name;
        } else {
            echo "Jewelry file not supported";
        }
    } else {
        $j_img_paths[] = null;
    }
}

// ID image upload handling (Front & Back)
$id_img_paths = [];
for ($i = 1; $i <= 2; $i++) {
    $id_image = isset($_FILES['id_image' . ($i == 1 ? '_front' : '_back')]) ? $_FILES['id_image' . ($i == 1 ? '_front' : '_back')] : null;
    if ($id_image && $id_image['error'] == 0) {
        $id_name = $id_image['name'];
        $id_tmp = $id_image['tmp_name'];
        $id_separate = explode('.', $id_name);
        $file_extension = strtolower(end($id_separate));
        $extensions = array('jpeg', 'jpg', 'png');
        if (in_array($file_extension, $extensions)) {
            $id_upload_path = '../../WebImages/UserId/' . $id_name;
            move_uploaded_file($id_tmp, $id_upload_path);
            $id_img_paths[] = 'WebImages/UserId/' . $id_name;
        } else {
            echo "ID file not supported";
        }
    } else {
        $id_img_paths[] = null;
    }
}

// Receipt image upload handling
$recit_img_paths = [];
for ($i = 1; $i <= 2; $i++) {
    $recit_image = isset($_FILES['recipt_image' . ($i == 1 ? '' : $i)]) ? $_FILES['recipt_image' . ($i == 1 ? '' : $i)] : null;
    if ($recit_image && $recit_image['error'] == 0) {
        $recit_name = $recit_image['name'];
        $recit_tmp = $recit_image['tmp_name'];
        $recit_separate = explode('.', $recit_name);
        $file_extension = strtolower(end($recit_separate));
        $extensions = array('jpeg', 'jpg', 'png');
        if (in_array($file_extension, $extensions)) {
            $recit_upload_path = '../../WebImages/Recepts/' . $recit_name;
            move_uploaded_file($recit_tmp, $recit_upload_path);
            $recit_img_paths[] = 'WebImages/Recepts/' . $recit_name;
        } else {
            echo "Receipt file not supported";
        }
    } else {
        $recit_img_paths[] = null;
    }
}

// Build the update query
$updateSql = "UPDATE complete_task SET 
                  IdNumber = '$idNumber',
                  weight = '$weight', 
                  price = '$price', 
                  commition = '$commition',
                  compteled_date = '$date',
                  completedTime = '$time'";

// Conditionally update image fields if new images are uploaded
if (!empty($j_img_paths[0])) {
    $updateSql .= ", jewelryImg = '$j_img_paths[0]'";
}
if (!empty($j_img_paths[1])) {
    $updateSql .= ", jewelryImg_1 = '$j_img_paths[1]'";
}
if (!empty($j_img_paths[2])) {
    $updateSql .= ", jewelryImg_2 = '$j_img_paths[2]'";
}
if (!empty($j_img_paths[3])) {
    $updateSql .= ", jewelryImg_3 = '$j_img_paths[3]'";
}
if (!empty($j_img_paths[4])) {
    $updateSql .= ", jewelryImg_4 = '$j_img_paths[4]'";
}
if (!empty($id_img_paths[0])) {
    $updateSql .= ", Id_image = '$id_img_paths[0]'";
}
if (!empty($id_img_paths[1])) {
    $updateSql .= ", Id_image1 = '$id_img_paths[1]'";
}
if (!empty($recit_img_paths[0])) {
    $updateSql .= ", receipt_img = '$recit_img_paths[0]'";
}

// Finalizing the query
$updateSql .= " WHERE taskID = '$idTask'";

if (mysqli_query($conn, $updateSql)) {
    echo "Task updated successfully";
    $_SESSION['taskUpdated'] = 1;
    header('Location: ../../AdminPanel/MyAllTask.php');
} else {
    echo "Error: " . mysqli_error($conn);
}

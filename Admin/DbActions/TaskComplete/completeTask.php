

<?php
require_once '../Db.conn.php';
session_start();

if (isset($_POST['completeTask'])) {

    $_SESSION['completeTask'] = 1;

    // Retrieve POST data safely
    $idTask = $_POST['taskId'] ?? '';
    $id = $_POST['ID_Number'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $price = (int)($_POST['price'] ?? 0);
    $completedBy = $_POST['completedBy'] ?? '';

    // Initialize variables for image paths to prevent "undefined" errors
    $j_img_path = $j_img_path1 = $j_img_path2 = $j_img_path3 = $j_img_path4 = '';
    $id_img_path = $id_img_path1 = $recit_img_path = '';

    // Helper function for file uploads
    function uploadImage($fileKey, $targetFolder)
    {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES[$fileKey];
            $fileName = basename($file['name']);
            $tmpName = $file['tmp_name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpeg', 'jpg', 'png'];

            if (in_array($ext, $allowed)) {
                $uploadPath = "../../WebImages/$targetFolder/" . $fileName;
                $relativePath = "WebImages/$targetFolder/" . $fileName;
                if (move_uploaded_file($tmpName, $uploadPath)) {
                    return $relativePath;
                }
            }
        }
        return '';
    }

    // Jewelry image uploads
    $j_img_path  = uploadImage('jewelry',  'JewelaryImg');
    $j_img_path1 = uploadImage('jewelry1', 'JewelaryImg');
    $j_img_path2 = uploadImage('jewelry2', 'JewelaryImg');
    $j_img_path3 = uploadImage('jewelry3', 'JewelaryImg');
    $j_img_path4 = uploadImage('jewelry4', 'JewelaryImg');

    // ID image uploads
    $id_img_path  = uploadImage('id_image', 'UserId');
    $id_img_path1 = uploadImage('id_image1', 'UserId');

    // Receipt image upload
    // Receipt image uploads
$recit_img_path  = uploadImage('recipt_image', 'Recepts');
$recit_img_path1 = uploadImage('recipt_image1', 'Recepts');
$recit_img_path2 = uploadImage('recipt_image2', 'Recepts');
$recit_img_path3 = uploadImage('recipt_image3', 'Recepts');
$recit_img_path4 = uploadImage('recipt_image4', 'Recepts');


// calculating commitions
$sqlCalcomuser = "SELECT * FROM users WHERE	UserName = '$completedBy'";
$commitioncalresult = mysqli_query($conn, $sqlCalcomuser);
$commitioncalresultrow = mysqli_fetch_assoc($commitioncalresult);

$promaotionlevel  =  (int)$commitioncalresultrow['promotionLevel'];


if($promaotionlevel == 0){

// Calculate commission for probetion
    if ($price <= 99999) {
        $commition = 750;
    } elseif ($price <= 199999) {
        $commition = 1000;
    }  elseif ($price <= 299999) {
        $commition = 2000;
    } elseif ($price <= 399999) {
        $commition = 3000;
    }  elseif ($price <= 499999) {
        $commition = 4000;
    } else {
        $commition = 4000;
    }

}elseif($promaotionlevel == 1) {

//calculate commition for conformed

    if ($price <= 99999) {
        $commition = 1000;
    } elseif ($price <= 199999) {
        $commition = 1500;
    }  elseif ($price <= 299999) {
        $commition = 2500;
    } elseif ($price <= 399999) {
        $commition = 3500;
    }  elseif ($price <= 499999) {
        $commition = 4500;
    } else {
        $commition = 4500;
    }
}elseif($promaotionlevel == 2){

// Calculate commission for manager level
    if ($price <= 99999) {
        $commition = 1000;
    } elseif ($price <= 149999) {
        $commition = 1500;
    } elseif ($price <= 199999) {
        $commition = 2000;
    } elseif ($price <= 249999) {
        $commition = 2500;
    } elseif ($price <= 299999) {
        $commition = 3000;
    } elseif ($price <= 349999) {
        $commition = 3500;
    } elseif ($price <= 399999) {
        $commition = 4000;
    } elseif ($price <= 449999) {
        $commition = 4500;
    } elseif ($price <= 499999) {
        $commition = 5000;
    } else {
        $commition = 5000;
    }

}

    

    

    // Insert into pending_complete_task
 $sql = "INSERT INTO pending_complete_task (
    IdNumber, weight, price, commition, jewelryImg, jewelryImg_1, jewelryImg_2, jewelryImg_3, jewelryImg_4,
    Id_image, Id_image1,
    receipt_img, receipt_img1, receipt_img2, receipt_img3, receipt_img4,
    taskID, compteled_date, completedTime, completedBy
) VALUES (
    '$id', '$weight', '$price', '$commition',
    '$j_img_path', '$j_img_path1', '$j_img_path2', '$j_img_path3', '$j_img_path4',
    '$id_img_path', '$id_img_path1',
    '$recit_img_path', '$recit_img_path1', '$recit_img_path2', '$recit_img_path3', '$recit_img_path4',
    '$idTask', '$date', '$time', '$completedBy'
)";


    if (mysqli_query($conn, $sql)) {

        // Mark task as completed
        $sql_taskUpdate = "UPDATE task SET completion = 4 WHERE task_id = '$idTask'";
        mysqli_query($conn, $sql_taskUpdate);

        // Check and update commission_total
        $checkCommition_sql = "SELECT completedBy FROM commition_total WHERE completedBy = '$completedBy'";
        $resultCheckCommition = mysqli_query($conn, $checkCommition_sql);

        if ($resultCheckCommition && $resultCheckCommition->num_rows > 0) {
            $updateCommition_sql = "UPDATE commition_total
                                    SET Commition_pending = Commition_pending + $commition
                                    WHERE completedBy = '$completedBy'";
            mysqli_query($conn, $updateCommition_sql);
        } else {
            $insertCommition_sql = "INSERT INTO commition_total (taskId, completedBy , Commition, Commition_pending)
                                    VALUES ('$idTask', '$completedBy',0 , '$commition')";
            mysqli_query($conn, $insertCommition_sql);
        }

        

        header('Location: ../../AdminPanel/MyAllTask.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
        header('Location: ../../AdminPanel/MyAllTask.php');
        exit;
    }
}
?>


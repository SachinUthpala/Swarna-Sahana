<?php  
require_once '../Db.conn.php';
session_start();

$id = $_POST['completeId'] ?? '';

if (empty($id)) {
    die("Invalid request: Task ID missing.");
}

// Fetch data from pending_complete_task
$sql = "SELECT * FROM pending_complete_task WHERE cid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If no record found
if (!$row) {
    die("No record found for this Task ID.");
}

// Extract values safely
$IdNumber        = $row['IdNumber'];
$weight          = $row['weight'];
$price           = $row['price'];
$commition       = $row['commition'];
$jewelryImg      = $row['jewelryImg'];
$jewelryImg_1    = $row['jewelryImg_1'];
$jewelryImg_2    = $row['jewelryImg_2'];
$jewelryImg_3    = $row['jewelryImg_3'];
$jewelryImg_4    = $row['jewelryImg_4'];
$Id_image        = $row['Id_image'];
$Id_image1       = $row['Id_image1'];
$receipt_img     = $row['receipt_img'];
$taskID          = $row['taskID'];
$compteled_date  = $row['compteled_date'];
$completedTime   = $row['completedTime'];
$completedBy     = $row['completedBy'];

// ✅ Insert into complete_task
$sql_insert = "INSERT INTO complete_task (
    IdNumber, weight, price, commition,
    jewelryImg, jewelryImg_1, jewelryImg_2, jewelryImg_3, jewelryImg_4,
    Id_image, Id_image1, receipt_img,
    taskID, compteled_date, completedTime, completedBy
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt_insert = $conn->prepare($sql_insert);

// ✅ Correct parameter types
// s = string, d = double (for weight/price), i = integer
$stmt_insert->bind_param(
    "sddssssssssissss",
    $IdNumber,
    $weight,
    $price,
    $commition,
    $jewelryImg,
    $jewelryImg_1,
    $jewelryImg_2,
    $jewelryImg_3,
    $jewelryImg_4,
    $Id_image,
    $Id_image1,
    $receipt_img,
    $taskID,
    $compteled_date,
    $completedTime,
    $completedBy
);

// ✅ Execute insert and handle results
if ($stmt_insert->execute()) {

    // Delete from pending_complete_task
    $sql_delete = "DELETE FROM pending_complete_task WHERE taskID = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $taskID);
    $stmt_delete->execute();

    // Update task as verified
    $sql_taskUpdate = "UPDATE task SET completion = 2 WHERE task_id = ?";
    $stmt_taskUpdate = $conn->prepare($sql_taskUpdate);
    $stmt_taskUpdate->bind_param("i", $taskID);
    $stmt_taskUpdate->execute();

    //update commition table
    $updateCommition_sql = "UPDATE commition_total 
                        SET Commition_pending = Commition_pending - $commition, 
                            Commition = Commition + $commition 
                        WHERE completedBy = '$completedBy'";

    mysqli_query($conn, $updateCommition_sql);

    // Update taskcreatorcommition table
    // $sql2 = "UPDATE taskcreatorcommition SET Commition = Commition + 2000";
    // mysqli_query($conn, $sql2);

    //getting created user
    $sql123con = "SELECT createdBy FROM task WHERE task_id = $taskID ";
    $resultcon23 = mysqli_query($conn, $sql123con);
    $row23com = mysqli_fetch_assoc($resultcon23);

    if($row23com['createdBy'] == 0){
        // Update taskcreatorcommition table
        $sql2 = "UPDATE taskcreatorcommition SET Commition = Commition + 2000";
        mysqli_query($conn, $sql2);
    }else{
        $taskcreatorID = $row23com['createdBy'];
        $sqlselectPromotionlevel = "SELECT * from users WHERE UserId = $taskcreatorID";
        $resultpromotionlevel = mysqli_query($conn, $sqlselectPromotionlevel);
        $rowpromotionlevel = mysqli_fetch_assoc($resultpromotionlevel);

        if($rowpromotionlevel['promotionLevel'] == 0){
            $taskcreatorcommition = 500;
        }elseif($rowpromotionlevel['promotionLevel'] == 1){
            $taskcreatorcommition = 1000;
        }elseif($rowpromotionlevel['promotionLevel'] == 2){
            $taskcreatorcommition = 1500;
        }elseif($rowpromotionlevel['promotionLevel'] == 3){
            $taskcreatorcommition = 2000;
        }elseif($rowpromotionlevel['promotionLevel'] == 4){
            $taskcreatorcommition = 2000;
        }elseif($rowpromotionlevel['promotionLevel'] == 5){
            $taskcreatorcommition = 2000;
        }elseif($rowpromotionlevel['promotionLevel'] == 6){
            $taskcreatorcommition = 2000;
        }


        $creatorname = $rowpromotionlevel['UserName'];
        $creatorId = $taskcreatorID;
        $promotionstatusss = $rowpromotionlevel['promotionLevel'];

        //cheking user avilable i task crator table
        $sqlcheckuserAvilable = "SELECT * FROM taskcreatorcommitionnew WHERE creatorId = $creatorId";

         $result = mysqli_query($conn, $sqlcheckuserAvilable);

        if ($result && mysqli_num_rows($result) > 0) {

            // User already exists -> update commission
            $sqlupdatecommitiontaskcreator = "
                UPDATE taskcreatorcommitionnew 
                SET commition = commition + $taskcreatorcommition 
                WHERE creatorId = $creatorId
            ";

            mysqli_query($conn, $sqlupdatecommitiontaskcreator);

        } else {

            // User does not exist -> insert new record
            $sqlfortaskcreatorinsertion = "
                INSERT INTO taskcreatorcommitionnew
                (creatorId, creatorname, commition, intensitive, promotionStatus) 
                VALUES 
                ($creatorId, '$creatorname', $taskcreatorcommition, 0.00, '$promotionstatusss')
            ";

            mysqli_query($conn, $sqlfortaskcreatorinsertion);
        }

        
    }

    // Redirect
    $_SESSION['ActionComplete'] = 1;
    header('Location: ../../AdminPanel/AllVerifyPending.php');
    exit;
} else {
    // Log or show error
    echo "Database Insert Error: " . $stmt_insert->error;
    header('Location: ../../AdminPanel/AllVerifyPending.php?status=error');
    exit;
}
?>

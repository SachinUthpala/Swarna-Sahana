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





    // Delete from pending_complete_task
    $sql_delete = "DELETE FROM pending_complete_task WHERE taskID = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $taskID);
    $stmt_delete->execute();

    // Update task as verified
    $sql_taskUpdate = "UPDATE task SET completion = 5 WHERE task_id = ?";
    $stmt_taskUpdate = $conn->prepare($sql_taskUpdate);
    $stmt_taskUpdate->bind_param("i", $taskID);
    $stmt_taskUpdate->execute();

    $updateCommition_sql = "UPDATE commition_total 
                        SET Commition_pending = Commition_pending - $commition
                        WHERE completedBy = '$completedBy'";

    mysqli_query($conn, $updateCommition_sql);


  
    // Redirect
    $_SESSION['ActionComplete'] = 1;
    header('Location: ../../AdminPanel/AllVerifyPending.php');
    exit;

?>

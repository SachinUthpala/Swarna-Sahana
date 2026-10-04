<?php

require_once '../Db.conn.php';

session_start();

error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../AdminPanel/");
    exit;
}

$costId = isset($_POST['costId']) ? (int)$_POST['costId'] : 0;
$payAmount = isset($_POST['payAmount']) ? (float)$_POST['payAmount'] : 0;

if ($costId <= 0 || $payAmount <= 0) {
    $_SESSION['PaymentError'] = 1;

    header("Location: ../../AdminPanel/AllDailyBoardCampingCost.php");
    exit;
}


// Get current payment information
$sql = "SELECT amount, paidAmount 
        FROM bordcampingcost 
        WHERE costId = ? 
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $costId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if (!$row) {

    $_SESSION['PaymentError'] = 1;

    header("Location: ../../AdminPanel/AllDailyBoardCampingCost.php");
    exit;
}


$totalAmount = (float)$row['amount'];
$paidAmount = (float)$row['paidAmount'];

$remainingAmount = $totalAmount - $paidAmount;


// IMPORTANT:
// Check again on the server
if ($payAmount > $remainingAmount) {

    $_SESSION['PaymentError'] = 2;

    header("Location: ../../AdminPanel/AllDailyBoardCampingCost.php");
    exit;
}


// Calculate new paid amount
$newPaidAmount = $paidAmount + $payAmount;


// Update payment
$updateSql = "UPDATE bordcampingcost 
              SET paidAmount = ?
              WHERE costId = ?";

$updateStmt = mysqli_prepare($conn, $updateSql);

mysqli_stmt_bind_param(
    $updateStmt,
    "di",
    $newPaidAmount,
    $costId
);

if (mysqli_stmt_execute($updateStmt)) {

    $_SESSION['PaymentSuccess'] = 1;

} else {

    $_SESSION['PaymentError'] = 3;
}


header("Location: ../../AdminPanel/AllDailyBoardCampingCost.php");
exit;
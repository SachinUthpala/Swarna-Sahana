<?php

require_once '../Db.conn.php';

session_start();

header('Content-Type: application/json');


// Check login
if (empty($_SESSION['UserId'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);

    exit();
}


// Check expense ID
if (!isset($_POST['expId']) || !is_numeric($_POST['expId'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid expense ID.'
    ]);

    exit();
}


$expId = (int) $_POST['expId'];


// Reject expense
$sql = "
    UPDATE expencess
    SET approved_exp = 2
    WHERE expenxess_id = ?
";


$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {

    echo json_encode([
        'success' => false,
        'message' => 'Database prepare error.'
    ]);

    exit();
}


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $expId
);


if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        'success' => true,
        'message' => 'Expense rejected successfully.'
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Failed to reject expense.'
    ]);
}


mysqli_stmt_close($stmt);

?>
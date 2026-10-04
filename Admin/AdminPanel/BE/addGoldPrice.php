<?php
header('Content-Type: application/json');
require '../../DbActions/Db.conn.php';

// Get and sanitize inputs
$date = isset($_POST['date']) ? trim($_POST['date']) : null;
$price = isset($_POST['price']) ? trim($_POST['price']) : null;

if (!$date || !$price || !is_numeric($price)) {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
    exit;
}

// Check if a record with this date already exists
$stmt = $conn->prepare("SELECT id FROM goldprice WHERE createdDate = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Date exists → update the price
    $stmt->close();
    $updateStmt = $conn->prepare("UPDATE goldprice SET price = ? WHERE createdDate = ?");
    $updateStmt->bind_param("ds", $price, $date);

    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Gold price updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed: " . $updateStmt->error]);
    }

    $updateStmt->close();

} else {
    // Date does not exist → insert new row
    $stmt->close();
    $insertStmt = $conn->prepare("INSERT INTO goldprice (createdDate, price) VALUES (?, ?)");
    $insertStmt->bind_param("sd", $date, $price);

    if ($insertStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Gold price added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Insert failed: " . $insertStmt->error]);
    }

    $insertStmt->close();
}

$conn->close();
?>

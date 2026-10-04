<?php
header('Content-Type: application/json');

require '../../DbActions/Db.conn.php';

// Sanitize input
$code = isset($_POST['carrots']) ? trim($_POST['carrots']) : '';
$carrots = isset($_POST['code']) ? intval($_POST['code']) : 0;

if ($code === '' || $carrots <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
    exit;
}

// Check if code already exists
$stmt = $conn->prepare("SELECT typeID FROM goldtype WHERE code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Code already exists."]);
    exit;
}
$stmt->close();

// Insert new gold type
$stmt = $conn->prepare("INSERT INTO goldtype (code, carrots) VALUES (?, ?)");
$stmt->bind_param("si", $code, $carrots);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Insert failed."]);
}
$stmt->close();
$conn->close();
?>

<?php
header('Content-Type: application/json');

require '../../DbActions/Db.conn.php';

$sql = "SELECT price FROM goldprice ORDER BY createdDate DESC LIMIT 1";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
  echo json_encode(["success" => true, "price" => (float)$row['price']]);
} else {
  echo json_encode(["success" => false, "message" => "No price found"]);
}

$conn->close();

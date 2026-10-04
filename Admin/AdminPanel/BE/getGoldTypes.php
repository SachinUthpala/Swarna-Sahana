<?php


// Fetch gold types
$sql = "SELECT code, carrots FROM goldtype ORDER BY code ASC";
$result = $conn->query($sql);


while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['carrots'] . '"> Code : ' . htmlspecialchars($row['code']) . '</option>';
  }


$conn->close();
?>

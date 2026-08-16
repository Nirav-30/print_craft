<?php

header("Content-Type: application/json");

require_once "db.php";

$sql = "SELECT * FROM products ORDER BY id DESC";

$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$conn->close();

?>
<?php

header("Content-Type: application/json");

require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);
    exit;
}

$name = $data["name"];
$email = $data["email"];
$phone = $data["phone"];
$address = $data["address"];
$total = $data["total"];


/* Insert Order */

$sql = "INSERT INTO orders
        (customer_name, email, phone, address, total_amount)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssd",
    $name,
    $email,
    $phone,
    $address,
    $total
);


if ($stmt->execute()) {

    $order_id = $stmt->insert_id;

    echo json_encode([
        "success" => true,
        "message" => "Order placed successfully",
        "order_id" => $order_id
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Unable to place order"
    ]);
}


$stmt->close();
$conn->close();

?>
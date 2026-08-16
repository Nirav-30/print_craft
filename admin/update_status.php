<?php

header("Content-Type: application/json");

require_once "../api/db.php";


$data = json_decode(
    file_get_contents("php://input"),
    true
);


if (!$data) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);

    exit;
}


$order_id = intval($data["order_id"]);

$status = $data["status"];


$allowed_status = [
    "Pending",
    "Processing",
    "Shipped",
    "Delivered",
    "Cancelled"
];


if (!in_array($status, $allowed_status)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid status"
    ]);

    exit;
}


$sql = "UPDATE orders
        SET status = ?
        WHERE id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "si",
    $status,
    $order_id
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Status updated"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Update failed"
    ]);

}


$stmt->close();

$conn->close();

?>
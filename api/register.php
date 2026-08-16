<?php

header("Content-Type: application/json");

require_once "db.php";


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


$name = trim($data["name"] ?? "");
$email = trim($data["email"] ?? "");
$phone = trim($data["phone"] ?? "");
$password = $data["password"] ?? "";


if ($name === "" || $email === "" || $password === "") {

    echo json_encode([
        "success" => false,
        "message" => "Please fill all required fields"
    ]);

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email address"
    ]);

    exit;
}


if (strlen($password) < 6) {

    echo json_encode([
        "success" => false,
        "message" => "Password must be at least 6 characters"
    ]);

    exit;
}


/* Check existing email */

$check = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check->bind_param("s", $email);

$check->execute();

$check->store_result();


if ($check->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Email already registered"
    ]);

    $check->close();
    $conn->close();

    exit;
}

$check->close();


/* Secure password */

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/* Insert user */

$sql = "INSERT INTO users
        (name, email, password, phone)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $hashedPassword,
    $phone
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Registration successful"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Registration failed"
    ]);
}


$stmt->close();
$conn->close();

?>
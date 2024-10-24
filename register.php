<?php
// register.php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password)) {
    $username = $data->username;
    $password = password_hash($data->password, PASSWORD_BCRYPT); // Hashing password

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    try {
        $stmt->execute([$username, $password]);
        echo json_encode(["message" => "User registered successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "User already exists."]);
    }
} else {
    echo json_encode(["error" => "Invalid input."]);
}
?>

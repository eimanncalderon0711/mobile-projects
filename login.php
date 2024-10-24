<?php
// login.php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) && isset($data->password)) {
    $username = $data->username;
    $password = $data->password;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(["message" => "Login successful.", "user" => $user]);
    } else {
        echo json_encode(["error" => "Invalid username or password."]);
    }
} else {
    echo json_encode(["error" => "Invalid input."]);
}
?>

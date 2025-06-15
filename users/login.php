<?php
require '../config.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    unset($user['password']); 
    echo json_encode(['data' => $user]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Username atau password salah']);
}
?>
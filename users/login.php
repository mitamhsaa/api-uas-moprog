<?php
require '../config.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    unset($user['password']);
    $response['status'] = true;
    $response['data'] = $user;
    $response['message'] = 'Login berhasil';
} else {
    http_response_code(401);
    $response['message'] = 'Username atau password salah';
}

echo json_encode($response);
?>
<?php
header('Content-Type: application/json');
require '../conn.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

if (empty($email) || empty($password)) {
    http_response_code(400);
    $response['message'] = 'Email dan password wajib diisi';
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    unset($user['password']);
    $response['status'] = true;
    $response['data'] = $user;
    $response['message'] = 'Login berhasil';
} else {
    http_response_code(401);
    $response['message'] = 'Email atau password salah';
}

echo json_encode($response);

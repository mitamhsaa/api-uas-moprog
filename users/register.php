<?php
require '../config.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$universitas = $data['universitas'] ?? '';
$jurusan = $data['jurusan'] ?? '';

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

if (!$username || !$email || !$password) {
    http_response_code(400);
    $response['message'] = 'Field wajib tidak boleh kosong';
    echo json_encode($response);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    $response['message'] = 'Email sudah terdaftar';
    echo json_encode($response);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT INTO users (username, email, password, universitas, jurusan, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$success = $stmt->execute([$username, $email, $hashedPassword, $universitas, $jurusan]);

$response['status'] = $success;
$response['message'] = $success ? 'Registrasi berhasil' : 'Registrasi gagal';

echo json_encode($response);
?>
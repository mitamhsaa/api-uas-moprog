<?php
require '../config.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$universitas = $data['universitas'] ?? '';
$jurusan = $data['jurusan'] ?? '';

if (!$username || !$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Field wajib tidak boleh kosong']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'Email sudah terdaftar']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT INTO users (username, email, password, universitas, jurusan, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$success = $stmt->execute([$username, $email, $hashedPassword, $universitas, $jurusan]);

echo json_encode(['success' => $success]);
?>
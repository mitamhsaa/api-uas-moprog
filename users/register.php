<?php
header('Content-Type: application/json');
require '../conn.php';

$data = json_decode(file_get_contents("php://input"), true);

$username     = $data['username'] ?? '';
$email        = $data['email'] ?? '';
$password     = $data['password'] ?? '';
$universitas  = $data['universitas'] ?? '';
$jurusan      = $data['jurusan'] ?? '';

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

// Validasi input
if (empty($username) || empty($email) || empty($password) || empty($universitas) || empty($jurusan)) {
    http_response_code(400);
    $response['message'] = 'Semua field wajib diisi';
    echo json_encode($response);
    exit;
}

// Cek apakah username atau email sudah ada
$check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    http_response_code(409);
    $response['message'] = 'Username atau email sudah digunakan';
    echo json_encode($response);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$createdAt = date("Y-m-d H:i:s");

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO users (username, email, password, universitas, jurusan, created_at) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $username, $email, $hashedPassword, $universitas, $jurusan, $createdAt);

if ($stmt->execute()) {
    $response['status'] = true;
    $response['message'] = 'Registrasi berhasil';
    $response['data'] = [
        'id' => $stmt->insert_id,
        'username' => $username,
        'email' => $email,
        'universitas' => $universitas,
        'jurusan' => $jurusan,
        'created_at' => $createdAt
    ];
} else {
    http_response_code(500);
    $response['message'] = 'Registrasi gagal';
}

echo json_encode($response);

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$user_id = $data['user_id'] ?? null;

if (!$id || !$user_id) {
    $response['message'] = 'ID dan user_id wajib diisi.';
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

$checkQuery = "SELECT * FROM tugas WHERE id = ? AND user_id = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("ii", $id, $user_id);
$checkStmt->execute();
$result = $checkStmt->get_result();
$existing = $result->fetch_assoc();

if (!$existing) {
    $response['message'] = 'Data tidak ditemukan atau bukan milik user.';
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}


$nama_tugas = $data['nama_tugas'] ?? $existing['nama_tugas'];
$matkul = $data['matkul'] ?? $existing['matkul'];
$deskripsi = array_key_exists('deskripsi', $data) ? $data['deskripsi'] : $existing['deskripsi'];
$deadline = $data['deadline'] ?? $existing['deadline'];
$status = $data['status'] ?? $existing['status'];

$updateQuery = "UPDATE tugas SET 
    nama_tugas = ?, 
    matkul = ?, 
    deskripsi = ?, 
    deadline = ?, 
    status = ?
    WHERE id = ? AND user_id = ?";

$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param(
    "sssssii",
    $nama_tugas,
    $matkul,
    $deskripsi,
    $deadline,
    $status,
    $id,
    $user_id
);

if ($updateStmt->execute()) {
    $response['status'] = true;
    $response['message'] = 'Data berhasil diperbarui';
    $response['data'] = [
        'id' => $id,
        'user_id' => $user_id,
        'nama_tugas' => $nama_tugas,
        'matkul' => $matkul,
        'deskripsi' => $deskripsi,
        'deadline' => $deadline,
        'status' => $status
    ];
} else {
    $response['message'] = 'Gagal memperbarui data: ' . $conn->error;
}

echo json_encode($response, JSON_PRETTY_PRINT);

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$user_id = $data['user_id'] ?? null;

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

if (!$id || !$user_id) {
    $response['message'] = 'ID dan user_id wajib diisi';
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

$query = "SELECT * FROM tugas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existing = $result->fetch_assoc();

if (!$existing) {
    $response['message'] = 'Data tidak ditemukan';
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}


$kode_matkul = $data['kode_matkul'] ?? $existing['kode_matkul'];
$kelompok = $data['kelompok'] ?? $existing['kelompok'];
$nama_tugas = $data['nama_tugas'] ?? $existing['nama_tugas'];
$matkul = $data['matkul'] ?? $existing['matkul'];
$deskripsi = array_key_exists('deskripsi', $data) ? $data['deskripsi'] : $existing['deskripsi']; // Bisa null
$deadline = $data['deadline'] ?? $existing['deadline'];
$status = $data['status'] ?? $existing['status'];


$updateQuery = "UPDATE tugas SET 
    user_id = ?, 
    kode_matkul = ?, 
    kelompok = ?, 
    nama_tugas = ?, 
    matkul = ?, 
    deskripsi = ?, 
    deadline = ?, 
    status = ? 
    WHERE id = ?";

$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param(
    "isssssssi",
    $user_id,
    $kode_matkul,
    $kelompok,
    $nama_tugas,
    $matkul,
    $deskripsi,
    $deadline,
    $status,
    $id
);

if ($updateStmt->execute()) {
    $response['status'] = true;
    $response['message'] = 'Data berhasil diperbarui';
} else {
    $response['message'] = 'Gagal memperbarui data';
}

echo json_encode($response, JSON_PRETTY_PRINT);

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status' => false,
    'data' => [],
    'message' => '',
];


if (!isset($_GET['user_id'])) {
    http_response_code(400);
    $response['message'] = 'Parameter user_id tidak ditemukan';
    echo json_encode($response);
    exit;
}

$user_id = $_GET['user_id'];
$hari = $_GET['hari'] ?? null;

try {
    if ($hari) {
        
        $sql = "SELECT * FROM jadwal_kuliah WHERE user_id = ? AND hari = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $hari);
    } else {
        
        $sql = "SELECT * FROM jadwal_kuliah WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response['status'] = true;
        $response['data'] = $data;
        $response['message'] = 'Berhasil mengambil data jadwal kuliah';
    } else {
        $response['message'] = 'Tidak ada data jadwal kuliah';
    }

    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);

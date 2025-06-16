<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status' => false,
    'data' => [],
    'message' => '',
];


if (!isset($_GET['user_id'])) {
    http_response_code(400);
    $response['message'] = 'Parameter user_id wajib dikirim';
    echo json_encode($response);
    exit;
}

$user_id = $_GET['user_id'];


$sql = "SELECT * FROM jadwal_kuliah WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    $response['message'] = 'Gagal mempersiapkan query';
    echo json_encode($response);
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $response['status'] = true;
    $response['data'] = $data;
    $response['message'] = 'Data jadwal berhasil diambil';
} else {
    $response['message'] = 'Tidak ada data jadwal ditemukan';
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>

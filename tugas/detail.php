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
} else {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM tugas WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
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
        $response['message'] = 'Berhasil mengambil data tugas';
    } else {
        $response['message'] = 'Tidak ada data tugas';
    }
    $stmt->close();
}
echo json_encode($response); ?>
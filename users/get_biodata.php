<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php"; 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT id, username, email, universitas, jurusan FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $response = [
            'status' => true,
            'data' => $user,
            'message' => 'Biodata ditemukan',
        ];
    } else {
        $response = [
            'status' => false,
            'data' => null,
            'message' => 'Data tidak ditemukan',
        ];
    }

    $stmt->close();
} else {
    $response = [
        'status' => false,
        'data' => null,
        'message' => 'ID tidak valid',
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>

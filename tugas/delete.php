<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];


if (isset($_GET['id']) && isset($_GET['user_id']) && !empty($_GET['id']) && !empty($_GET['user_id'])) {
    $id = intval($_GET['id']);
    $user_id = intval($_GET['user_id']);

    
    $checkSql = "SELECT * FROM tugas WHERE id = ? AND user_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $id, $user_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
    
        $deleteSql = "DELETE FROM tugas WHERE id = ? AND user_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("ii", $id, $user_id);

        if ($deleteStmt->execute()) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus.';
        } else {
            $response['message'] = 'Gagal menghapus data: ' . $deleteStmt->error;
        }

        $deleteStmt->close();
    } else {
        $response['message'] = 'Data tidak ditemukan atau tidak milik user ini.';
    }

    $checkStmt->close();
} else {
    $response['message'] = 'Parameter "id" dan "user_id" wajib diisi.';
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>

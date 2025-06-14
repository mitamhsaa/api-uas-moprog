<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (!empty($id)) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $response = [
                'status' => true,
                'data' => '',
                'message' => 'Data Berhasil Dihapus',
            ];
        } else {
            $response = [
                'status' => false,
                'data' => '',
                'message' => 'Gagal Menghapus Data',
            ];
        }

    } else {
        $response = [
            'status' => false,
            'data' => '',
            'message' => 'Tidak ada id dipilih',
        ];
    }
}
echo json_encode($response, JSON_PRETTY_PRINT);
?>
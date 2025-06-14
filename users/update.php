<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$universitas = $_POST['universitas'];
$jurusan = $_POST['jurusan'];

if (!empty($id) && !empty($username) && !empty($email) && !empty($universitas) && !empty($jurusan)) {
    $sql = "UPDATE users SET username = ?, email = ?, universitas = ?, jurusan = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssi", $username, $email, $universitas, $jurusan, $id);

        if ($stmt->execute()) {
            $response = [
                'status' => true,
                'data' => '',
                'message' => 'Data berhasil diperbarui',
            ];
        } else {
            $response = [
                'status' => false,
                'data' => '',
                'message' => 'Gagal mengeksekusi query',
            ];
        }
    } else {
        $response = [
            'status' => false,
            'data' => '',
            'message' => 'Gagal mempersiapkan statement',
        ];
    }
} else {
    $response = [
        'status' => false,
        'data' => '',
        'message' => 'Data tidak lengkap',
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>

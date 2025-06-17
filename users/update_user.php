<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$data = json_decode(file_get_contents("php://input"), true);

$response = [
    'status' => false,
    'message' => 'Permintaan tidak valid',
    'data' => null,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $data['id'] ?? '';
    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $universitas = $data['universitas'] ?? '';
    $jurusan = $data['jurusan'] ?? '';

    if (empty($id) || empty($username) || empty($email)) {
        $response['message'] = 'Field id, username, dan email wajib diisi.';
    } else {
        $sql = "UPDATE users SET username=?, email=?, universitas=?, jurusan=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $universitas, $jurusan, $id);

        if ($stmt->execute()) {
            $response['status'] = true;
            $response['message'] = 'Data user berhasil diperbarui.';
        } else {
            $response['message'] = 'Gagal memperbarui data: ' . $stmt->error;
        }
    }
}

echo json_encode($response);
?>

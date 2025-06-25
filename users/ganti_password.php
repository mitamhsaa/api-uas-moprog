<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'] ?? '';
    $old_password = $data['old_password'] ?? '';
    $new_password = $data['new_password'] ?? '';

    if (empty($id) || empty($old_password) || empty($new_password)) {
        $response['message'] = 'Field tidak boleh kosong';
        echo json_encode($response);
        exit;
    }

    
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $response['message'] = 'User tidak ditemukan';
        echo json_encode($response);
        exit;
    }

    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    if (!password_verify($old_password, $hashedPassword)) {
        $response['message'] = 'Password lama salah';
        echo json_encode($response);
        exit;
    }

    $newHashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newHashedPassword, $id);

    if ($updateStmt->execute()) {
        $response['status'] = true;
        $response['message'] = 'Password berhasil diubah';
    } else {
        $response['message'] = 'Gagal mengubah password';
    }

    echo json_encode($response);
}
?>

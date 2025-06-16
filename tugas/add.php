<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // echo "Data diterima:\n";
    // print_r($_POST);

    $user_id    = $_POST['user_id'] ?? '';
    $nama_tugas = $_POST['nama_tugas'] ?? '';
    $matkul     = $_POST['matkul'] ?? '';
    $deskripsi  = $_POST['deskripsi'] ?? '';
    $deadline   = $_POST['deadline'] ?? '';
    $status     = $_POST['status'] ?? '';

    if (empty($user_id) || empty($nama_tugas)) {
        $response['message'] = "Field wajib tidak boleh kosong (user_id, nama_tugas)";
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    $sql = "INSERT INTO tugas (user_id, nama_tugas, matkul, deskripsi, deadline, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssss", $user_id, $nama_tugas, $matkul, $deskripsi, $deadline, $status);

        if ($stmt->execute()) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil ditambahkan';
            $response['data'] = [
                'user_id'    => $user_id,
                'nama_tugas' => $nama_tugas,
                'matkul'     => $matkul,
                'deskripsi'  => $deskripsi,
                'deadline'   => $deadline,
                'status'     => $status,
            ];
        } else {
            $response['message'] = 'Gagal menambahkan data: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'Gagal menyiapkan query: ' . $conn->error;
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        'status' => false,
        'data' => null,
        'message' => 'Gunakan metode POST untuk mengirim data.'
    ], JSON_PRETTY_PRINT);
}

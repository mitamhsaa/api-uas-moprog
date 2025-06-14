<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

// Set header agar response dalam bentuk JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Ambil data dari form (x-www-form-urlencoded)
    $username    = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email       = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password    = isset($_POST['password']) ? trim($_POST['password']) : '';
    $universitas = isset($_POST['universitas']) ? trim($_POST['universitas']) : '';
    $jurusan     = isset($_POST['jurusan']) ? trim($_POST['jurusan']) : '';

    $encryptedPassword = md5($password);
    
    // Siapkan response default
    $response = [
        'status'  => false,
        'data'    => null,
        'message' => '',
    ];

    // Validasi input kosong
    if (empty($username) || empty($email) || empty($password) || empty($universitas) || empty($jurusan)) {
        $response['message'] = 'Semua field wajib diisi';
        echo json_encode($response);
        exit;
    }

    // Query untuk insert ke database
    $sql = "INSERT INTO users (username, email, password, universitas, jurusan) 
            VALUES ('$username', '$email', '$encryptedPassword', '$universitas', '$jurusan')";

    if (mysqli_query($conn, $sql)) {
        $response['status']  = true;
        $response['message'] = 'Data berhasil ditambahkan';
        $response['data'] = [
            'username'    => $username,
            'email'       => $email,
            'universitas' => $universitas,
            'jurusan'     => $jurusan
        ];
    } else {
        $response['message'] = 'Gagal menambahkan data: ' . mysqli_error($conn);
    }

    echo json_encode($response);
} else {
    echo json_encode([
        'status'  => false,
        'data'    => null,
        'message' => 'Gunakan metode POST untuk mengirim data.'
    ]);
}
?>

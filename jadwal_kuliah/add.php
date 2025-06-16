<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

$response = [
    'status'  => false,
    'data'    => null,
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user_id      = $_POST['user_id'] ?? '';
    $kode_matkul  = $_POST['kode_matkul'] ?? '';
    $nama_matkul  = $_POST['nama_matkul'] ?? '';
    $kelompok     = $_POST['kelompok'] ?? '';
    $hari         = $_POST['hari'] ?? '';
    $jam_mulai    = $_POST['jam_mulai'] ?? '';
    $jam_selesai  = $_POST['jam_selesai'] ?? '';
    $ruangan      = $_POST['ruangan'] ?? '';


    if (
        empty($user_id) || empty($kode_matkul) || empty($nama_matkul) ||
        empty($kelompok) || empty($hari) || empty($jam_mulai) ||
        empty($jam_selesai) || empty($ruangan)
    ) {
        $response['message'] = 'Semua field wajib diisi';
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    
    $sql = "INSERT INTO jadwal_kuliah (
        user_id, kode_matkul, nama_matkul, kelompok, hari, jam_mulai, jam_selesai, ruangan
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "isssssss",
            $user_id,
            $kode_matkul,
            $nama_matkul,
            $kelompok,
            $hari,
            $jam_mulai,
            $jam_selesai,
            $ruangan
        );

        if ($stmt->execute()) {
            $response['status']  = true;
            $response['message'] = 'Data berhasil ditambahkan';
            $response['data'] = [
                'user_id'       => $user_id,
                'kode_matkul'   => $kode_matkul,
                'nama_matkul'   => $nama_matkul,
                'kelompok'      => $kelompok,
                'hari'          => $hari,
                'jam_mulai'     => $jam_mulai,
                'jam_selesai'   => $jam_selesai,
                'ruangan'       => $ruangan
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
        'status'  => false,
        'data'    => null,
        'message' => 'Gunakan metode POST untuk mengirim data.'
    ], JSON_PRETTY_PRINT);
}
?>

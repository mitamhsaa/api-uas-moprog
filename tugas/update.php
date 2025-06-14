<?php
include "../conn.php";

// Ambil data dari POST
$id = $_POST['id'];
$user_id = $_POST['user_id'];
$kode_matkul = $_POST['kode_matkul'];
$kelompok = $_POST['kelompok'];
$nama_tugas = $_POST['nama_tugas'];
$matkul = $_POST['matkul'];
$deskripsi = $_POST['deskripsi'];
$deadline = $_POST['deadline'];
$status = $_POST['status'];

// Validasi semua data tidak kosong
if (
    !empty($id) && !empty($user_id) && !empty($kode_matkul) && !empty($kelompok) 
    && !empty($nama_tugas) && !empty($matkul) && !empty($deskripsi) && !empty($deadline) && !empty($status)
) {
    // Query update
    $sql = "UPDATE users SET 
                user_id = ?, 
                kode_matkul = ?,
                kelompok = ?,
                nama_tugas = ?,  
                matkul = ?, 
                deskripsi = ?, 
                deadline = ?, 
                status = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter: i s s s s s s s i (total 9 parameter)
        $stmt->bind_param(
            "isssssssi",
            $user_id,
            $kode_matkul,
            $kelompok,
            $nama_tugas,
            $matkul,
            $deskripsi,
            $deadline,
            $status,
            $id
        );

        // Eksekusi statement
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

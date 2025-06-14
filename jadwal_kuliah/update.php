<?php
include "../conn.php";

// Ambil data dari POST
$id = $_POST['id'];
$user_id = $_POST['user_id'];
$kode_matkul = $_POST['kode_matkul'];
$nama_matkul = $_POST['nama_matkul'];
$kelompok = $_POST['kelompok'];
$hari = $_POST['hari'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$ruangan = $_POST['ruangan'];

// Validasi semua data tidak kosong
if (
    !empty($id) && !empty($user_id) && !empty($kode_matkul) && !empty($nama_matkul) &&
    !empty($kelompok) && !empty($hari) && !empty($jam_mulai) && !empty($jam_selesai) && !empty($ruangan)
) {
    // Query update
    $sql = "UPDATE users SET 
                user_id = ?, 
                kode_matkul = ?, 
                nama_matkul = ?, 
                kelompok = ?, 
                hari = ?, 
                jam_mulai = ?, 
                jam_selesai = ?, 
                ruangan = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter: i s s s s s s s i (total 9 parameter)
        $stmt->bind_param(
            "isssssssi",
            $user_id,
            $kode_matkul,
            $nama_matkul,
            $kelompok,
            $hari,
            $jam_mulai,
            $jam_selesai,
            $ruangan,
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

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


include "../conn.php";


$input = json_decode(file_get_contents("php://input"), true);

$id           = isset($input['id']) ? trim($input['id']) : '';
$user_id      = isset($input['user_id']) ? trim($input['user_id']) : '';
$kode_matkul  = isset($input['kode_matkul']) ? trim($input['kode_matkul']) : '';
$nama_matkul  = isset($input['nama_matkul']) ? trim($input['nama_matkul']) : '';
$kelompok     = isset($input['kelompok']) ? trim($input['kelompok']) : '';
$hari         = isset($input['hari']) ? trim($input['hari']) : '';
$jam_mulai    = isset($input['jam_mulai']) ? trim($input['jam_mulai']) : '';
$jam_selesai  = isset($input['jam_selesai']) ? trim($input['jam_selesai']) : '';
$ruangan      = isset($input['ruangan']) ? trim($input['ruangan']) : '';


if (
    $id && $user_id && $kode_matkul && $nama_matkul &&
    $kelompok && $hari && $jam_mulai && $jam_selesai && $ruangan
) {
    $sql = "UPDATE jadwal_kuliah SET 
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

        if ($stmt->execute()) {
            $response = [
                'status' => true,
                'data' => null,
                'message' => 'Data berhasil diperbarui',
            ];
        } else {
            $response = [
                'status' => false,
                'data' => null,
                'message' => 'Gagal mengeksekusi query: ' . $stmt->error,
            ];
        }

        $stmt->close();
    } else {
        $response = [
            'status' => false,
            'data' => null,
            'message' => 'Gagal mempersiapkan query: ' . $conn->error,
        ];
    }
} else {
    $response = [
        'status' => false,
        'data' => null,
        'message' => 'Data tidak lengkap',
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>

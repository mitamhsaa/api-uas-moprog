<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Data diterima:\n";
    print_r($POST);

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $kode_matkul = isset($_POST['kode_matkul']) ? $_POST['kode_matkul'] : '';
    $kelompok = isset($_POST['kelompok']) ? $_POST['kelompok'] : '';
    $nama_tugas = isset($_POST['nama_tugas']) ? $_POST['nama_tugas'] : '';
    $matkul = isset($_POST['matkul']) ? $_POST['matkul'] : '';
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
    $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $encryptedPassword = md5($password);

    $response = [
        'status' => false,
        'data' => null,
        'message' => '',
    ];

    if (empty($user_id) || empty($kode_matkul) || empty($kelompok) || empty($nama_tugas) || empty($matkul) || empty($deskripsi) || empty($deadline) || empty($status)) {
        echo "Field kosong: user_id = '$user_id', kode_matkul = '$kode_matkul', kelompok = '$kelompok',nama_tugas = '$nama_tugas', matkul = '$matkul', deskripsi = '$deskripsi', deadline='$deadline', status='$status'";
        exit;
    }

    $sql = "INSERT INTO jadwal_kuliah (user_id,kode_matkul,kelompok,nama_tugas,matkul,deskripsi,deadline,status) VALUES ($udser_id,$kode_matkul,$nama_matkul,$kelompok,$hari,$jam_mulai,$jam_selesai,$ruangan)";

    if (mysqli_query($conn, $sql)) {
        $response['status'] = true;
        $response['message'] = 'Data berhasil ditambahkan';
        $response['data'] = [
            'user_id' => $user_id,
            'kode_matkul' => $kode_matkul,
            'kelompok' => $kelompok,
            'nama_tugas' => $nama_tugas,
            'matkul' => $hari,
            'deskripsi' => $deskripsi,
            'deadline' => $deadline,
            'status' => $status
        ];
    } else {
        $response['message'] = 'Gagal menambahkan data: ' . mysqli_error($conn);
    }

    echo json_encode($response);
} else {
    echo json_encode([
        'status' => false,
        'data' => null,
        'message' => 'Gunakan metode POST untuk mengirim data.'
    ]);
}
?>
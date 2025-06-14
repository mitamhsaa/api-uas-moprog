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
        $nama_matkul = isset($_POST['nama_matkul']) ? $_POST['nama_matkul'] : '';
        $kelompok = isset($_POST['kelompok']) ? $_POST['kelompok'] : '';
        $hari = isset($_POST['hari']) ? $_POST['hari'] : '';
        $jam_mulai = isset($_POST['jam_mulai']) ? $_POST['jam_mulai'] : '';
        $jam_selesai = isset($_POST['jam_selesai']) ? $_POST['jam_selesai'] : '';
        $ruangan = isset($_POST['ruangan']) ?$_POST['ruangan'] : '';

     $encryptedPassword = md5($password);

      $response = [
        'status'  => false,
        'data'    => null,
        'message' => '',
    ];

    if(empty($user_id) || empty($kode_matkul) || empty($nama_matkul) || empty($kelompok) || empty($hari) || empty($jam_mulai) || empty($jam_selesai) || empty($ruangan)){
        echo "Field kosong: user_id = '$user_id', kode_matkul = '$kode_matkul', nama_matkul = '$nama_matkul', kelompok = '$kelompok', hari = '$hari', jam_mulai = '$jam_mulai', jam_selesai='$jam_selesai', ruangan='$ruangan'";
        exit;
    }

    $sql = "INSERT INTO jadwal_kuliah (user_id,kode_matkul,nama_matkul,kelompok,hari,jam_mulai,jam_selesai,ruangan) VALUES ($udser_id,$kode_matkul,$nama_matkul,$kelompok,$hari,$jam_mulai,$jam_selesai,$ruangan)";

    if(mysqli_query($conn, $sql)){
        $response['status']  = true;
        $response['message'] = 'Data berhasil ditambahkan';
        $response['data'] = [
            'user_id'        => $user_id,
            'kode_matkul'    => $kode_matkul,
            'nama_matkul'    => $nama_matkul,
            'kelompok'       => $kelompok,
            'hari'           => $hari,
            'jam_mulai'      => $jam_mulai,
            'jam_selesai'    => $jam_selesai,
            'ruangan'        => $ruangan
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



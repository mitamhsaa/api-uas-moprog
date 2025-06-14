<?php 
include "../conn.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    if(!empty($id)){
        $sql = "DELETE FROM tugas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);

        if($stmt->execute()){
            $response = [
                'status' => true,
                'data' => '',
                'message' => 'Data Berhasil Dihapus',
            ];
        } else{
            $response = [
                'status' => false,
                'data' => '',
                'message' => 'Gagal Menghapus Data',
             ];
        } 

    } else{
            $response = [
                'status' => false,
                'data' => '',
                'message' => 'Tidak ada id dipilih',
            ];
        } 
    }
    echo json_encode($response, JSON_PRETTY_PRINT);
?>

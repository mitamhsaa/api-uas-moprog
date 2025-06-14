<?php 
include "../conn.php";

if (!isset($_GET['id'])){
    $response = [
    'status' => false,
    'data' => '',
    'message' => '',
    ];
}
else{
    $id = $_GET['id'];
    $sql = "SELECT * FROM jadwal_kuliah WHERE id = ?";
    $stmt = $conn->prepare ($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $response = [
        'status' => true,
        'data' => $result->fetch_assoc(),
        'message' => 'Berhasil',
    ];
    }
    else{
        $response = [
        'status' => false,
        'data' => '',
        'message' => 'Tidak',
    ];
    } 
}
echo json_encode($response);
?>
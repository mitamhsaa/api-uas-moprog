<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

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
    $sql = "SELECT * FROM users WHERE id = ?";
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
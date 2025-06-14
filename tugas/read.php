<?php
include "../conn.php";

$sql = "SELECT * from tugas";
$result = $conn->query($sql);

$response = [
    'status' => false,
    'data' => '',
    'message' => '',
];

if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $response['status'] = true;
    $response['data'] = $data;
    $response['message'] = 'Data Berhasil di dapat';

} else{
    $response['status'] = false;
    $response['data'] = '';
    $response['message'] = 'Data tidak ada';
}

echo json_encode($response);
?>
